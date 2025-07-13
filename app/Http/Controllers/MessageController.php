<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $conversations = $user->getConversations();
        $messageableUsers = $user->getMessageableUsers();
        
        return view('messages.index', compact('conversations', 'messageableUsers'));
    }

    public function show($conversationId)
    {
        $user = Auth::user();
        $conversation = Conversation::with(['userOne', 'userTwo', 'messages.sender'])
            ->findOrFail($conversationId);

        // Check if user is participant
        if (!$conversation->isParticipant($user->id)) {
            abort(403, 'You are not authorized to view this conversation.');
        }

        // Mark messages as read
        $conversation->markAsRead($user->id);

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        $otherUser = $conversation->getOtherUser($user->id);

        return view('messages.show', compact('conversation', 'messages', 'otherUser'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
            'file' => 'nullable|file|max:10240', // 10MB max
        ]);

        $user = Auth::user();
        $recipient = User::findOrFail($request->recipient_id);

        // Check if user can message recipient
        if (!$user->canMessage($recipient)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to message this user.'
            ], 403);
        }

        // Find or create conversation
        $conversation = Conversation::findOrCreateBetween($user->id, $recipient->id);

        // Handle file upload
        $filePath = null;
        $fileName = null;
        $fileSize = null;
        $messageType = 'text';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            
            // Determine file type
            $extension = strtolower($file->getClientOriginalExtension());
            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($extension, $imageExtensions)) {
                $messageType = 'image';
            } else {
                $messageType = 'file';
            }

            $filePath = $file->store('messages', 'public');
        }

        // Create message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'content' => $request->content,
            'message_type' => $messageType,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $fileSize,
        ]);

        // Update conversation last message time
        $conversation->update([
            'last_message_at' => now()
        ]);

        // Load sender relationship for response
        $message->load('sender');

        return response()->json([
            'success' => true,
            'message' => $message,
            'conversation' => $conversation
        ]);
    }

    public function getConversations()
    {
        $user = Auth::user();
        $conversations = $user->getConversations();

        return response()->json([
            'conversations' => $conversations
        ]);
    }

    public function getMessages($conversationId)
    {
        $user = Auth::user();
        $conversation = Conversation::findOrFail($conversationId);

        if (!$conversation->isParticipant($user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this conversation.'
            ], 403);
        }

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        $conversation->markAsRead($user->id);

        return response()->json([
            'messages' => $messages
        ]);
    }

    public function markAsRead($conversationId)
    {
        $user = Auth::user();
        $conversation = Conversation::findOrFail($conversationId);

        if (!$conversation->isParticipant($user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to access this conversation.'
            ], 403);
        }

        $conversation->markAsRead($user->id);

        return response()->json([
            'success' => true
        ]);
    }

    public function getUnreadCount()
    {
        $user = Auth::user();
        $count = $user->getUnreadMessageCount();

        return response()->json([
            'count' => $count
        ]);
    }

    public function downloadFile($messageId)
    {
        $user = Auth::user();
        $message = Message::with('conversation')->findOrFail($messageId);

        // Check if user is participant in conversation
        if (!$message->conversation->isParticipant($user->id)) {
            abort(403, 'You are not authorized to download this file.');
        }

        if (!$message->file_path) {
            abort(404, 'File not found.');
        }

        $path = Storage::disk('public')->path($message->file_path);
        
        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        return response()->download($path, $message->file_name);
    }

    public function deleteMessage($messageId)
    {
        $user = Auth::user();
        $message = Message::findOrFail($messageId);

        // Only sender can delete their message
        if ($message->sender_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You can only delete your own messages.'
            ], 403);
        }

        // Delete file if exists
        if ($message->file_path) {
            Storage::disk('public')->delete($message->file_path);
        }

        $message->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
