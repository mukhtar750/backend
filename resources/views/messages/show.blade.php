@extends('layouts.entrepreneur')

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
                        <p class="text-sm text-gray-500">{{ ucfirst($otherUser->role) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Container -->
        <div class="flex flex-col h-96">
            <!-- Messages List -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messagesContainer">
                @foreach($messages as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="flex items-end gap-2 {{ $message->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                            {{-- Avatar --}}
                            <img src="{{ $message->sender->avatar ?? 'https://i.pravatar.cc/32?u=' . $message->sender_id }}" class="h-8 w-8 rounded-full object-cover" alt="{{ $message->sender->name }}">
                            <div class="max-w-xs lg:max-w-md">
                                <div class="px-4 py-2 rounded-lg {{ $message->sender_id === auth()->id() ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-900' }}">
                                    @if($message->isImage())
                                        <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $message->file_path) }}" class="max-h-40 rounded mb-2" alt="Image">
                                        </a>
                                    @elseif($message->isFile())
                                        <div class="flex items-center space-x-2">
                                            <i class="bi bi-file-earmark"></i>
                                            <span>{{ $message->file_name }}</span>
                                            <a href="{{ route('messages.download', $message->id) }}" class="text-blue-500">
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
            <div class="border-t border-gray-200 p-4">
                <form id="messageForm" class="flex items-center space-x-3">
                    <div class="flex-1">
                        <textarea id="messageInput" rows="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none resize-none" placeholder="Type your message..."></textarea>
                    </div>
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
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    
    messageForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const content = messageInput.value.trim();
        if (!content) return;

        const formData = new FormData();
        formData.append('recipient_id', {{ $otherUser->id }});
        formData.append('content', content);

        try {
            const response = await fetch('/messages', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                messageInput.value = '';
                location.reload(); // Simple refresh for now
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