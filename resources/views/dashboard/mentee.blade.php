@extends('layouts.mentee')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Welcome Banner -->
    <div class="rounded-2xl p-8 bg-gradient-to-r from-[#b81d8f] to-[#a01a7d] text-white shadow-lg">
        <div class="flex flex-col gap-6">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold mb-2">Welcome back, {{ $mentee->name }}! <span class="inline-block">👋</span></h2>
                <p class="text-base text-pink-100 max-w-xl">Your mentorship journey is progressing beautifully. Keep up the great work!</p>
            </div>
            <div class="flex flex-col md:flex-row gap-4 w-full mt-4">
                <div class="flex-1 min-w-[180px] rounded-xl px-6 py-5 border border-white/30 bg-white/20 backdrop-blur-md shadow-sm flex flex-col items-start justify-center">
                    <span class="text-xs text-white/80 mb-1">Mentor</span>
                    <span class="font-semibold text-lg text-white">{{ $mentor ? $mentor->name : 'Not Assigned' }}</span>
                </div>
                <div class="flex-1 min-w-[180px] rounded-xl px-6 py-5 border border-white/30 bg-white/20 backdrop-blur-md shadow-sm flex flex-col items-start justify-center">
                    <span class="text-xs text-white/80 mb-1">Upcoming Sessions</span>
                    <span class="font-semibold text-lg text-white">{{ $upcomingSessions->count() }} sessions</span>
                </div>
                <div class="flex-1 min-w-[180px] rounded-xl px-6 py-5 border border-white/30 bg-white/20 backdrop-blur-md shadow-sm flex flex-col items-start justify-center">
                    <span class="text-xs text-white/80 mb-1">Profile Status</span>
                    <span class="font-semibold text-lg text-white">Active</span>
                </div>
                <div class="flex-1 min-w-[180px] flex flex-col items-center justify-center mt-4 md:mt-0">
                    <a href="{{ route('messages.index') }}" class="bg-white/30 hover:bg-white/50 text-white font-semibold px-6 py-2 rounded-lg shadow transition flex items-center gap-2">
                        <i class="bi bi-chat-dots"></i> View Messages
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-[#b81d8f]">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-[#b81d8f]/10">
                    <i class="bi bi-person-badge text-2xl text-[#b81d8f]"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Your Mentor</h3>
                    @if($mentor)
                        <p class="text-2xl font-bold text-[#b81d8f]">{{ $mentor->name }}</p>
                        <p class="text-sm text-gray-500">@displayRole($mentor->role)</p>
                    @else
                        <p class="text-2xl font-bold text-gray-400">Not assigned</p>
                    @endif
                </div>
            </div>
            @if($mentor)
                <div class="mt-4">
                    <a href="{{ route('messages.create', ['recipient' => $mentor->id]) }}" class="inline-flex items-center px-4 py-2 bg-[#b81d8f] text-white rounded-lg hover:bg-[#a01a7d] transition">
                        <i class="bi bi-envelope mr-2"></i> Message Mentor
                    </a>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <i class="bi bi-calendar-check text-2xl text-green-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Upcoming Sessions</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $upcomingSessions->count() }}</p>
                    <p class="text-sm text-gray-500">Scheduled sessions</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <i class="bi bi-check-circle text-2xl text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Profile Status</h3>
                    <p class="text-2xl font-bold text-blue-600">Active</p>
                    <p class="text-sm text-gray-500">Ready for mentorship</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Upcoming Sessions -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Upcoming Sessions</h2>
                <span class="text-sm text-gray-500">{{ $upcomingSessions->count() }} sessions</span>
            </div>
            @forelse($upcomingSessions as $session)
                <div class="mb-4 p-4 border border-gray-100 rounded-xl hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="font-semibold text-gray-800">{{ $session->topic ?? 'Mentorship Session' }}</div>
                            <div class="text-sm text-gray-500">With: {{ $mentor ? $mentor->name : 'Mentor' }}</div>
                            <div class="text-xs text-gray-400 mt-1">
                                <i class="bi bi-clock mr-1"></i>
                                {{ $session->date_time ? $session->date_time->format('D, M d, h:i A') : 'TBD' }}
                            </div>
                        </div>
                        @if($session->meeting_link)
                            <a href="{{ $session->meeting_link }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-[#b81d8f] text-white rounded-lg hover:bg-[#a01a7d] transition font-semibold text-sm">
                                <i class="bi bi-camera-video mr-2"></i> Join
                            </a>
                        @else
                            <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                <i class="bi bi-clock mr-1"></i> Pending
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-calendar text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No upcoming sessions</h3>
                    <p class="text-gray-500">Your mentor will schedule sessions for you.</p>
                </div>
            @endforelse
        </div>

        <!-- Recent Messages -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Recent Messages</h2>
                <a href="{{ route('messages.index') }}" class="text-[#b81d8f] hover:underline text-sm font-medium">View all</a>
            </div>
            @forelse($messages as $message)
                <a href="{{ route('messages.show', $message->conversation_id) }}" class="block p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200 rounded-lg">
                    <div class="flex items-center">
                        <img src="{{ $message->sender->profile_photo_url ?? asset('images/avatar-placeholder.png') }}" alt="Sender" class="h-10 w-10 rounded-full object-cover mr-3">
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-800">{{ $message->sender->name }}</span>
                                <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-gray-600 text-sm mt-1">{{ Str::limit($message->content, 80) }}</div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-chat text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No recent messages</h3>
                    <p class="text-gray-500">Start a conversation with your mentor.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Past Sessions -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Past Sessions</h2>
        @forelse($pastSessions as $session)
            <div class="mb-4 p-4 border border-gray-100 rounded-xl hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="font-semibold text-gray-800">{{ $session->topic ?? 'Mentorship Session' }}</div>
                        <div class="text-sm text-gray-500">With: {{ $mentor ? $mentor->name : 'Mentor' }}</div>
                        <div class="text-xs text-gray-400 mt-1">
                            <i class="bi bi-calendar mr-1"></i>
                            {{ $session->date_time ? $session->date_time->format('D, M d, h:i A') : 'TBD' }}
                        </div>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $session->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        <i class="bi bi-check-circle mr-1"></i>
                        {{ ucfirst($session->status) }}
                    </span>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-calendar-check text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No past sessions</h3>
                <p class="text-gray-500">Your completed sessions will appear here.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection 