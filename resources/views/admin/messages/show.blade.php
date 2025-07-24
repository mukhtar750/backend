@extends('admin.layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="bi bi-chat-dots-fill text-2xl text-purple-600"></i>
                <h1 class="text-2xl font-bold text-gray-900">Conversation with {{ $otherUser->name }}</h1>
                <span class="text-xs text-gray-500">({{ ucfirst($otherUser->role) }})</span>
            </div>
            <a href="{{ route('admin.messages') }}" class="text-purple-600 hover:text-purple-800 font-medium">← Back to Messages</a>
        </div>
        <div class="p-6 space-y-4" style="min-height: 300px; background: #f8f5ff;">
            @foreach($messages as $msg)
                <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="flex items-end gap-2 {{ $msg->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                        <img src="{{ $msg->sender->avatar ?? 'https://i.pravatar.cc/32?u=' . $msg->sender_id }}" class="h-8 w-8 rounded-full object-cover" alt="{{ $msg->sender->name }}">
                        <div class="max-w-xs lg:max-w-md">
                            <div class="px-4 py-2 rounded-2xl {{ $msg->sender_id === auth()->id() ? 'bg-pink-500 text-white' : 'bg-white text-gray-900 shadow' }}">
                                {{ $msg->content }}
                                <div class="text-xs opacity-75 mt-1">{{ $msg->sender->name }} • {{ $msg->created_at->format('g:i A, M d') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="border-t border-gray-200 p-4 bg-white">
            <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-3">
                @csrf
                <input type="hidden" name="recipient_id" value="{{ $otherUser->id }}">
                <div class="flex-1">
                    <textarea name="content" rows="1" class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-pink-500 focus:outline-none resize-none bg-gray-50" placeholder="Type a message..." required></textarea>
                </div>
                <input type="file" name="file" class="hidden" id="fileInput">
                <label for="fileInput" class="cursor-pointer text-xl text-gray-400 hover:text-purple-600"><i class="bi bi-paperclip"></i></label>
                <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-full shadow hover:bg-pink-600 transition">Send</button>
            </form>
        </div>
    </div>
</div>
@endsection 