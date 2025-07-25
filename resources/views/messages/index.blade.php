@extends($layout ?? (auth()->user()->role === 'bdsp' ? 'layouts.bdsp' : (auth()->user()->role === 'admin' ? 'admin.layouts.admin' : 'layouts.app')))

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            @php
                $admin = \App\Models\User::where('role', 'admin')->where('is_approved', true)->first();
            @endphp
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Messages</h1>
                <div class="flex gap-2">
                    <a href="{{ route('messages.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-purple-700 transition">New Message</a>
                    @if($admin && auth()->user()->role !== 'admin')
                        <a href="{{ route('messages.create', ['recipient' => $admin->id]) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-yellow-600 transition flex items-center">
                            <i class="bi bi-person-badge mr-2"></i> Message Admin
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex h-96">
            <!-- Sidebar -->
            <div class="w-1/3 border-r border-gray-200 overflow-y-auto">
                <div class="p-4 border-b border-gray-200">
                    <div class="relative">
                        <input type="text" placeholder="Search Messages" class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-purple-500 focus:outline-none pl-10">
                        <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <!-- AWN Hub -->
                <div class="p-4 border-b border-gray-200">
                    <a href="{{ route('groups.show', 'awn-hub') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                        <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                            <i class="bi bi-people-fill text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">AWN Hub</h3>
                            <p class="text-xs text-gray-500">Global community chat</p>
                        </div>
                    </a>
                </div>
                <!-- Private Messages -->
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Private Messages</h2>
                    <div class="space-y-2">
                        @forelse($possibleChats as $chat)
                            @php
                                $otherUser = $chat['user'];
                                $unreadCount = $chat['unreadCount'];
                                $latestMessage = $chat['latestMessage'];
                                $avatar = $otherUser->avatar ?? 'https://i.pravatar.cc/40?u=' . $otherUser->id;
                            @endphp
                            <a href="{{ $chat['type'] === 'conversation' ? route('messages.show', $chat['id']) : route('messages.create', ['recipient' => $otherUser->id]) }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition relative">
                                <div class="relative">
                                    <img src="{{ $avatar }}" class="h-10 w-10 rounded-full object-cover" alt="{{ $otherUser->name }}">
                                    @if($otherUser->is_online ?? false)
                                        <span class="absolute bottom-0 right-0 h-3 w-3 bg-green-400 border-2 border-white rounded-full"></span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-900">{{ $otherUser->name }}</h3>
                                            <div class="text-xs text-gray-500">{{ ucfirst($otherUser->role) }}</div>
                                        </div>
                                        @if($unreadCount > 0)
                                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full animate-pulse">{{ $unreadCount }}</span>
                                        @endif
                                    </div>
                                    @if($latestMessage)
                                        <p class="text-sm text-gray-500 truncate">{{ $latestMessage->content }}</p>
                                        <p class="text-xs text-gray-400">{{ $latestMessage->created_at->diffForHumans() }}</p>
                                    @else
                                        <p class="text-sm text-gray-500 truncate">Start a new conversation</p>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="bi bi-chat text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No private chats</h3>
                                <p class="text-gray-500">Pair with users to start messaging.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <div class="flex-1 flex flex-col items-center justify-center">
                <div class="text-gray-400 text-lg">Select a conversation to view messages.</div>
            </div>
        </div>
    </div>
</div>
@endsection