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
@foreach($messages as $message)
    <div class="mb-2 flex items-start @if($message->sender_id === auth()->id()) justify-end @endif">
        <div class="max-w-xs w-fit p-3 rounded-lg shadow @if($message->sender_id === auth()->id()) bg-purple-100 text-right @else bg-white @endif">
            <div class="text-xs text-gray-500 mb-1">{{ $message->sender->name }}</div>
            @if($message->isImage())
                <img src="{{ asset('storage/'.$message->file_path) }}" alt="Image" class="rounded mb-2 max-h-40">
            @elseif($message->isFile())
                <a href="{{ route('messages.downloadFile', $message->id) }}" class="text-blue-600 underline" target="_blank">
                    {{ $message->file_name }} ({{ $message->getFileSizeFormatted() }})
                </a>
            @endif
            <div>{{ $message->content }}</div>
            <div class="text-[10px] text-gray-400 mt-1">{{ $message->created_at->format('M d, H:i') }}</div>
        </div>
    </div>
@endforeach
<script>
document.addEventListener('DOMContentLoaded', function() {
    var chatContainer = document.getElementById('chat-messages');
    if (chatContainer) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
});
</script> 