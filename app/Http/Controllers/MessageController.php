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

        $possibleChats = [];
        $conversationUserIds = [];

        foreach ($conversations as $conv) {
            $otherUser = $conv->getOtherUser($user->id);
            $conversationUserIds[] = $otherUser->id;
            $possibleChats[] = [
                'type' => 'conversation',
                'id' => $conv->id,
                'user' => $otherUser,
                'unreadCount' => $conv->getUnreadCount($user->id),
                'latestMessage' => $conv->latestMessage,
            ];
        }

        foreach ($messageableUsers as $mu) {
            if (!in_array($mu->id, $conversationUserIds)) {
                $possibleChats[] = [
                    'type' => 'new',
                    'id' => $mu->id,
                    'user' => $mu,
                    'unreadCount' => 0,
                    'latestMessage' => null,
                ];
            }
        }

        // Dynamic layout selection based on user role
        $layout = match ($user->role) {
            'entrepreneur' => 'layouts.entrepreneur',
            'bdsp' => 'layouts.bdsp',
            'mentor' => 'layouts.mentor',
            'mentee' => 'layouts.mentee',
            'admin' => 'admin.layouts.admin',
            default => 'layouts.app',
        };

        return view('messages.index', compact('possibleChats', 'messageableUsers', 'layout'));
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

        // Return JSON for AJAX/JS requests
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'conversation' => $conversation,
                'messages' => $messages,
                'otherUser' => $otherUser,
            ]);
        }

        return view('messages.show', compact('conversation', 'messages', 'otherUser'));
    }

    public function adminShow($conversationId)
    {
        $user = Auth::user();
        $conversation = \App\Models\Conversation::with(['userOne', 'userTwo', 'messages.sender'])
            ->findOrFail($conversationId);

        // Check if user is participant (admin can see all)
        if ($user->role !== 'admin' && !$conversation->isParticipant($user->id)) {
            abort(403, 'You are not authorized to view this conversation.');
        }

        // Mark messages as read
        $conversation->markAsRead($user->id);

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        $otherUser = $conversation->getOtherUser($user->id);

        return view('admin.messages.show', compact('conversation', 'messages', 'otherUser'));
    }

    public function create(Request $request)
    {
        $recipientId = $request->input('recipient');
        $recipient = null;
        if ($recipientId) {
            $recipient = \App\Models\User::find($recipientId);
        }
        $messageableUsers = auth()->user()->getMessageableUsers();
        return view('messages.create', compact('recipient', 'messageableUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
            'file' => 'nullable|file|mimes:pdf,doc,docx,mp4,png,jpeg,jpg|max:10240', // 10MB, allowed types
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
            $extension = strtolower($file->getClientOriginalExtension());
            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $messageType = in_array($extension, $imageExtensions) ? 'image' : 'file';
            $filePath = $file->store('messages', 'public');
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'content' => $request->content,
            'message_type' => $messageType,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $fileSize,
        ]);

        $message->load('sender');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'conversation' => $conversation,
            ]);
        }

        // For normal form POST, redirect to the correct conversation page
        $route = $user->role === 'admin' ? 'admin.messages.show' : 'messages.show';
        return redirect()->route($route, $conversation->id)->with('success', 'Message sent!');
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
