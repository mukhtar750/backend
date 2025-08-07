@php
    $role = auth()->user()->role;
    $layout = $role === 'mentee' ? 'layouts.mentee' : ($role === 'entrepreneur' ? 'layouts.entrepreneur' : 'layouts.' . $role);
@endphp
@extends($layout)

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('messages.index') }}" class="text-gray-500 hover:text-gray-700">
                        <i class="bi bi-arrow-left text-xl"></i>
                    </a>
                    <div class="relative w-10 h-10">
                        <img src="{{ $otherUser->avatar ?? 'https://i.pravatar.cc/40?u=' . $otherUser->id }}" class="w-10 h-10 rounded-full object-cover" alt="{{ $otherUser->name }}">
                        @if($otherUser->is_online ?? false)
                            <span class="absolute bottom-0 right-0 h-3 w-3 bg-green-400 border-2 border-white rounded-full"></span>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">{{ $otherUser->name }}</h1>
                        <p class="text-sm text-gray-500">@displayRole($otherUser->role)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Container -->
        <div class="flex flex-col h-96">
            <!-- Messages List -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messagesContainer">
                @foreach($messages as $message)
                    <div class="mb-2 flex items-start @if($message->sender_id === auth()->id()) justify-end @endif">
                        <div class="max-w-xs w-fit p-3 rounded-lg shadow @if($message->sender_id === auth()->id()) bg-purple-100 text-right @else bg-white @endif">
                            <div class="text-xs text-gray-500 mb-1">{{ $message->sender->name }}</div>
                            @if($message->isImage())
                                <img src="{{ asset('storage/'.$message->file_path) }}" alt="Image" class="rounded mb-2 max-h-40">
                            @elseif($message->isFile())
                                <a href="{{ route('messages.download', $message->id) }}" class="text-blue-600 underline" target="_blank">
                                    {{ $message->file_name }} ({{ $message->getFileSizeFormatted() }})
                                </a>
                            @endif
                            <div>{{ $message->content }}</div>
                            <div class="text-[10px] text-gray-400 mt-1">{{ $message->created_at->format('M d, H:i') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Message Input -->
            <div class="border-t border-gray-200 p-4">
                <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-3">
                    @csrf
                    <input type="hidden" name="recipient_id" id="recipientId" value="{{ $otherUser->id }}">
                    <div class="flex-1">
                        <textarea name="content" id="messageContent" rows="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none resize-none" placeholder="Type your message..." required></textarea>
                    </div>
                    <input type="file" name="file" id="messageFile" class="hidden">
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg shadow hover:bg-purple-700 transition">
                        <i class="bi bi-send"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var chatContainer = document.getElementById('messagesContainer');
    if (chatContainer) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
});
</script>
@if(session('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow z-50">
        {{ session('success') }}
    </div>
@endif
@endsection