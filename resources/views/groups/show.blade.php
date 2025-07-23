@extends('layouts.app')

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
                    <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="bi bi-people-fill text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">{{ $group->name }}</h1>
                        <p class="text-sm text-gray-500">{{ $group->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Container -->
        <div class="flex flex-col h-96">
            <!-- Messages List -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messagesContainer" style="background-color: #f8f5ff;">
                @foreach($messages as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="flex items-end gap-2 {{ $message->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                            <img src="{{ $message->sender->avatar ?? 'https://i.pravatar.cc/32?u=' . $message->sender_id }}" class="h-8 w-8 rounded-full object-cover" alt="{{ $message->sender->name }}">
                            <div class="max-w-xs lg:max-w-md">
                                <div class="px-4 py-2 rounded-2xl {{ $message->sender_id === auth()->id() ? 'bg-pink-500 text-white' : 'bg-white text-gray-900 shadow' }}">
                                    @if($message->message_type === 'image')
                                        <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $message->file_path) }}" class="max-h-40 rounded mb-2" alt="Image">
                                        </a>
                                    @elseif($message->message_type === 'file')
                                        <div class="flex items-center space-x-2">
                                            <i class="bi bi-file-earmark"></i>
                                            <span>{{ $message->file_name }}</span>
                                            <!-- Adapt download route if needed -->
                                            <a href="{{ asset('storage/' . $message->file_path) }}" class="text-blue-500">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        </div>
                                    @endif
                                    <div>{{ $message->content }}</div>
                                    <div class="text-xs opacity-75 mt-1">
                                        {{ $message->sender->name }} • {{ $message->created_at->format('g:i A') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Message Input -->
            <div class="border-t border-gray-200 p-4 bg-white">
                <form id="messageForm" class="flex items-center space-x-3">
                    <div class="flex-1">
                        <textarea id="messageInput" rows="1" class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-pink-500 focus:outline-none resize-none bg-gray-50" placeholder="Type a message..."></textarea>
                    </div>
                    <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-full shadow hover:bg-pink-600 transition">
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    
    messageForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const content = messageInput.value.trim();
        if (!content) return;

        const formData = new FormData();
        formData.append('content', content);

        try {
            const response = await fetch('/groups/{{ $group->slug }}/messages', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                messageInput.value = '';
                location.reload(); // Refresh to show new message
            } else {
                alert(data.message || 'Failed to send message.');
            }
        } catch (error) {
            console.error('Error sending message:', error);
            alert('Failed to send message. Please try again.');
        }
    });
});
</script>
@endsection