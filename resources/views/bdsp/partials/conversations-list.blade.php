<div x-data="{ search: '' }" class="h-full flex flex-col">
    <div class="mb-4">
        <input type="text" x-model="search" placeholder="Search..." class="w-full px-3 py-2 rounded-lg border focus:ring-2 focus:ring-purple-400 bg-white" />
    </div>
    <ul class="space-y-2 flex-1 overflow-y-auto pr-1">
        @forelse($conversations as $conversation)
            @php
                $otherUser = $conversation->getOtherUser(auth()->id());
                $unread = $conversation->getUnreadCount(auth()->id());
            @endphp
            <li class="flex items-center gap-3 p-3 rounded-lg cursor-pointer border border-transparent hover:bg-purple-50 transition group relative {{ request()->route('conversation') == $conversation->id ? 'bg-purple-50 border-purple-200' : '' }}"
                onclick="window.location='{{ route('bdsp.messages.show', $conversation->id) }}'">
                <div class="relative">
                    <img src="https://i.pravatar.cc/40?u={{ $otherUser->id }}" class="h-10 w-10 rounded-full object-cover" alt="{{ $otherUser->name }}">
                    @if($otherUser->is_online ?? false)
                        <span class="absolute bottom-0 right-0 h-3 w-3 bg-green-400 border-2 border-white rounded-full"></span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-gray-900 flex items-center gap-2">
                        {{ $otherUser->name }}
                        @if($unread > 0)
                            <span class="ml-1 bg-purple-600 text-white text-xs rounded-full px-2 py-0.5">{{ $unread }}</span>
                        @endif
                    </div>
                    <div class="text-xs text-gray-500 truncate w-32">{{ optional($conversation->latestMessage)->content }}</div>
                </div>
                @if($unread > 0)
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 h-2 w-2 bg-purple-500 rounded-full" title="Unread"></span>
                @endif
            </li>
        @empty
            <li class="text-gray-400 text-center py-8">No conversations yet.</li>
        @endforelse
    </ul>
</div> 