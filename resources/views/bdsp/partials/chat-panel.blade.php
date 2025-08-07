<div class="flex flex-col h-full">
    <!-- Chat Header -->
    <div class="sticky top-0 z-10 bg-white border-b flex items-center gap-3 px-6 py-4">
        <img src="https://i.pravatar.cc/40?u={{ $otherUser->id }}" class="h-10 w-10 rounded-full object-cover" alt="{{ $otherUser->name }}">
        <div class="flex-1">
            <div class="font-semibold text-lg text-gray-900">{{ $otherUser->name }}</div>
            <div class="text-xs text-gray-500">@displayRole($otherUser->role)</div>
        </div>
        <div class="flex gap-2">
            <button class="p-2 rounded-full hover:bg-gray-100"><i class="bi bi-telephone text-lg"></i></button>
            <button class="p-2 rounded-full hover:bg-gray-100"><i class="bi bi-camera-video text-lg"></i></button>
            <button class="p-2 rounded-full hover:bg-gray-100"><i class="bi bi-info-circle text-lg"></i></button>
        </div>
    </div>
    <!-- Message History -->
    <div class="flex-1 overflow-y-auto p-6 bg-gradient-to-b from-gray-50 to-white flex flex-col gap-4" id="messagesContainer">
        @foreach($messages as $message)
            <div class="flex {{ $message->sender_id === auth()->id() ? 'items-start gap-3 flex-row-reverse' : 'items-start gap-3' }}">
                <img src="https://i.pravatar.cc/32?u={{ $message->sender_id }}" class="h-8 w-8 rounded-full object-cover" alt="{{ $message->sender->name }}">
                <div>
                    <div class="{{ $message->sender_id === auth()->id() ? 'bg-purple-100' : 'bg-gray-100' }} rounded-2xl px-4 py-2 text-gray-800 shadow-sm">
                        @if($message->isFile())
                            <div class="flex items-center space-x-2">
                                <i class="bi bi-file-earmark"></i>
                                <span>{{ $message->file_name }}</span>
                                <a href="{{ route('messages.download', $message->id) }}" class="text-blue-500"><i class="bi bi-download"></i></a>
                            </div>
                        @endif
                        <div>{{ $message->content }}</div>
                        <div class="text-xs opacity-75 mt-1 {{ $message->sender_id === auth()->id() ? 'text-right' : '' }}">{{ $message->sender->name }} • {{ $message->created_at->format('g:i A') }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div> 