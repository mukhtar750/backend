@extends('layouts.mentee')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-end mb-4">
        <a href="{{ route('messages.index') }}" class="bg-[#b81d8f] text-white px-5 py-2 rounded-lg shadow hover:bg-[#a01a7d] transition flex items-center gap-2">
            <i class="bi bi-chat-dots"></i> Messages
        </a>
    </div>
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, {{ $mentee->name }} (Mentee)</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Your Mentor</h2>
            @if($mentor)
                <div class="flex items-center space-x-4">
                    <img src="{{ $mentor->profile_photo_url ?? asset('images/avatar-placeholder.png') }}" alt="Mentor" class="w-12 h-12 rounded-full">
                    <div>
                        <p class="font-bold text-[#b81d8f]">{{ $mentor->name }}</p>
                        <p class="text-xs text-gray-500">{{ ucfirst($mentor->role) }}</p>
                        <a href="{{ route('messages.create', ['recipient' => $mentor->id]) }}" class="text-xs text-[#b81d8f] hover:underline flex items-center mt-1"><i class="bi bi-envelope mr-1"></i> Message</a>
                    </div>
                </div>
            @else
                <p class="text-2xl font-bold text-[#b81d8f]">Not assigned</p>
            @endif
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Upcoming Sessions</h2>
            <p class="text-2xl font-bold text-[#b81d8f]">{{ $upcomingSessions->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Profile Status</h2>
            <p class="text-2xl font-bold text-[#b81d8f]">Active</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Upcoming Sessions</h2>
            @forelse($upcomingSessions as $session)
                <div class="mb-4 p-4 border border-gray-100 rounded-lg flex items-center justify-between">
                    <div>
                        <div class="font-medium">{{ $session->topic ?? 'Session' }}</div>
                        <div class="text-sm text-gray-500">With: {{ $mentor ? $mentor->name : 'Mentor' }}</div>
                        <div class="text-xs text-gray-400">{{ $session->date_time ? $session->date_time->format('D, M d, h:i A') : '' }}</div>
                    </div>
                    @if($session->meeting_link)
                        <a href="{{ $session->meeting_link }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-pink-600 text-white rounded-lg shadow hover:bg-pink-700 transition font-bold border-2 border-pink-700 text-xs"><i class="fas fa-video mr-2"></i> Join</a>
                    @endif
                </div>
            @empty
                <div class="text-gray-500">No upcoming sessions.</div>
            @endforelse
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Messages</h2>
            @forelse($messages as $message)
                <a href="{{ route('messages.show', $message->conversation_id) }}" class="block p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-center">
                        <img src="{{ $message->sender->profile_photo_url ?? asset('images/avatar-placeholder.png') }}" alt="Sender" class="h-8 w-8 rounded-full object-cover mr-3">
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-800">{{ $message->sender->name }}</span>
                                <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-gray-600 text-sm mt-1">{{ Str::limit($message->content, 80) }}</div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-gray-500">No recent messages.</div>
            @endforelse
            <div class="pt-4 text-center">
                <a href="{{ route('messages.index') }}" class="text-[#b81d8f] font-medium hover:underline">View all messages</a>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Past Sessions</h2>
        @forelse($pastSessions as $session)
            <div class="mb-4 p-4 border border-gray-100 rounded-lg flex items-center justify-between">
                <div>
                    <div class="font-medium">{{ $session->topic ?? 'Session' }}</div>
                    <div class="text-sm text-gray-500">With: {{ $mentor ? $mentor->name : 'Mentor' }}</div>
                    <div class="text-xs text-gray-400">{{ $session->date_time ? $session->date_time->format('D, M d, h:i A') : '' }}</div>
                </div>
                <span class="text-xs px-2 py-1 rounded-full {{ $session->status == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($session->status) }}</span>
            </div>
        @empty
            <div class="text-gray-500">No past sessions.</div>
        @endforelse
    </div>
</div>
@endsection 