@extends('layouts.entrepreneur')
@section('title', 'Training Calendar')
@section('content')
<div class="max-w-5xl mx-auto mt-10">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Training Calendar</h2>
        <p class="text-gray-500 mt-1">View and register for upcoming training sessions and workshops designed to help you grow as an entrepreneur.</p>
    </div>
    <!-- Stats Row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">Upcoming Sessions</div>
            <div class="text-2xl font-bold text-[#b81d8f]">2</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">Registered</div>
            <div class="text-2xl font-bold text-[#b81d8f]">1</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">Completed</div>
            <div class="text-2xl font-bold text-[#16a34a]">1</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">Total Hours Attended</div>
            <div class="text-2xl font-bold text-blue-600">3.5h</div>
        </div>
    </div>
    <!-- Tabs -->
    <div x-data="{ tab: 'upcoming' }" class="mb-6">
        <div class="flex border-b">
            <button @click="tab = 'upcoming'" :class="tab === 'upcoming' ? 'border-[#b81d8f] text-[#b81d8f]' : 'border-transparent text-gray-500'" class="px-6 py-2 font-medium border-b-2 focus:outline-none">Upcoming ({{ $sessions->count() }})</button>
            <button @click="tab = 'registered'" :class="tab === 'registered' ? 'border-[#b81d8f] text-[#b81d8f]' : 'border-transparent text-gray-500'" class="px-6 py-2 font-medium border-b-2 focus:outline-none">Registered ({{ count($registrations) }})</button>
            <button @click="tab = 'completed'" :class="tab === 'completed' ? 'border-[#b81d8f] text-[#b81d8f]' : 'border-transparent text-gray-500'" class="px-6 py-2 font-medium border-b-2 focus:outline-none">Completed (0)</button>
        </div>
        <!-- Upcoming Tab -->
        <div x-show="tab === 'upcoming'" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($sessions as $session)
            <div class="bg-[#f7f6fd] border-2 border-[#b81d8f] rounded-2xl p-6 flex flex-col shadow-sm relative">
                <div class="flex items-center gap-3 mb-2">
                    <div class="bg-purple-100 rounded-full p-2"><i class="bi bi-journal-bookmark text-2xl text-purple-500"></i></div>
                    <div>
                        <div class="font-bold text-gray-900">{{ $session->title }}</div>
                        <div class="text-sm text-gray-500">{{ $session->description }}</div>
                    </div>
                    <span class="ml-auto bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">Upcoming</span>
                </div>
                <div class="text-sm text-gray-700 mb-2">{{ $session->description }}</div>
                <div class="text-xs text-gray-500 mb-1">Instructor: <span class="text-gray-700 font-medium">{{ $session->trainer }}</span></div>
                <div class="text-xs text-gray-500 mb-1">Date & Time: <span class="text-gray-700 font-medium">{{ \Carbon\Carbon::parse($session->date_time)->format('Y-m-d \a\t h:i A') }}</span></div>
                <div class="text-xs text-gray-500 mb-1">Duration: <span class="text-gray-700 font-medium">{{ $session->duration }} minutes</span></div>
                <div class="text-xs text-gray-500 mb-1">Participants: <span class="text-gray-700 font-medium">{{ $session->participants_count ?? '-' }}</span></div>
                <div class="mt-2">
                    <div class="text-xs text-gray-500 mb-1">Registration Progress</div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-purple-400 rounded-full" style="width: 72%"></div>
                    </div>
                </div>
                <div class="mt-3 flex flex-wrap gap-2">
                    @if(isset($session->materials) && is_array($session->materials))
                        @foreach($session->materials as $material)
                            <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">{{ $material }}</span>
                        @endforeach
                    @endif
                </div>
                <div class="flex gap-3 mt-6">
                    @if(in_array($session->id, $registrations))
                        @if(!empty($session->meeting_link))
                            <a href="{{ $session->meeting_link }}" target="_blank" class="flex-1 bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center gap-2 justify-center">
                                <i class="bi bi-camera-video-fill text-lg"></i> Join Session
                            </a>
                        @else
                            <span class="flex-1 bg-gray-300 text-white px-5 py-2 rounded-lg font-semibold flex items-center gap-2 justify-center cursor-not-allowed">No Link Yet</span>
                        @endif
                    @else
                        <form method="POST" action="{{ route('training-sessions.register', $session->id) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-[#b81d8f] text-white px-5 py-2 rounded-lg font-semibold hover:bg-[#a01a7d] transition flex items-center gap-2 justify-center">
                                <i class="bi bi-person-plus-fill text-lg"></i> Register
                            </button>
                        </form>
                    @endif
                    <button class="border border-gray-300 rounded-lg px-5 py-2 text-gray-700 font-medium hover:bg-gray-100 transition">View Details</button>
                </div>
            </div>
            @endforeach
        </div>
        <!-- Registered Tab -->
        <div x-show="tab === 'registered'" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($sessions as $session)
                @if(in_array($session->id, $registrations))
                <div class="bg-[#f7f6fd] border-2 border-blue-400 rounded-2xl p-6 flex flex-col shadow-sm relative">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="bg-blue-100 rounded-full p-2"><i class="bi bi-journal-bookmark text-2xl text-blue-500"></i></div>
                        <div>
                            <div class="font-bold text-gray-900">{{ $session->title }}</div>
                            <div class="text-sm text-gray-500">{{ $session->description }}</div>
                        </div>
                        <span class="ml-auto bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">Registered</span>
                    </div>
                    <div class="text-sm text-gray-700 mb-2">{{ $session->description }}</div>
                    <div class="text-xs text-gray-500 mb-1">Instructor: <span class="text-gray-700 font-medium">{{ $session->trainer }}</span></div>
                    <div class="text-xs text-gray-500 mb-1">Date & Time: <span class="text-gray-700 font-medium">{{ \Carbon\Carbon::parse($session->date_time)->format('Y-m-d \a\t h:i A') }}</span></div>
                    <div class="text-xs text-gray-500 mb-1">Duration: <span class="text-gray-700 font-medium">{{ $session->duration }} minutes</span></div>
                    <div class="text-xs text-gray-500 mb-1">Participants: <span class="text-gray-700 font-medium">{{ $session->participants_count ?? '-' }}</span></div>
                    <div class="mt-2">
                        <div class="text-xs text-gray-500 mb-1">Registration Progress</div>
                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-400 rounded-full" style="width: 72%"></div>
                        </div>
                    </div>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @if(isset($session->materials) && is_array($session->materials))
                            @foreach($session->materials as $material)
                                <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">{{ $material }}</span>
                            @endforeach
                        @endif
                    </div>
                    <div class="flex gap-3 mt-6">
                        @if(!empty($session->meeting_link))
                            <a href="{{ $session->meeting_link }}" target="_blank" class="flex-1 bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center gap-2 justify-center">
                                <i class="bi bi-camera-video-fill text-lg"></i> Join Session
                            </a>
                        @else
                            <span class="flex-1 bg-gray-300 text-white px-5 py-2 rounded-lg font-semibold flex items-center gap-2 justify-center cursor-not-allowed">No Link Yet</span>
                        @endif
                        <button class="border border-gray-300 rounded-lg px-5 py-2 text-gray-700 font-medium hover:bg-gray-100 transition">View Details</button>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        <!-- Completed Tab -->
        <div x-show="tab === 'completed'" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Placeholder for completed sessions -->
        </div>
    </div>
</div>
@endsection 