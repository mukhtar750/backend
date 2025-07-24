<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    public function show($slug)
    {
        $group = Group::where('slug', $slug)->firstOrFail();
        if (!$group->canAccess(Auth::user())) {
            abort(403);
        }
        $messages = $group->messages()->with('sender')->orderBy('created_at', 'asc')->get();
        return view('groups.show', compact('group', 'messages'));
    }

    public function storeMessage(Request $request, $slug)
    {
        $group = Group::where('slug', $slug)->firstOrFail();
        if (!$group->canAccess(Auth::user())) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'content' => 'required|string|max:1000',
            'file' => 'nullable|file|mimes:pdf,doc,docx,mp4,png,jpeg,jpg|max:10240', // 10MB, allowed types
        ]);

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
            $filePath = $file->store('group_messages', 'public');
        }

        $message = GroupMessage::create([
            'group_id' => $group->id,
            'sender_id' => Auth::id(),
            'content' => $request->content,
            'message_type' => $messageType,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $fileSize,
        ]);

        $message->load('sender');

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function getMessages($slug)
    {
        $group = Group::where('slug', $slug)->firstOrFail();
        if (!$group->canAccess(Auth::user())) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        $messages = $group->messages()->with('sender')->orderBy('created_at', 'asc')->get();
        return response()->json(['messages' => $messages]);
    }
}