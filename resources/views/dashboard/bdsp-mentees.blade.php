@extends('layouts.bdsp')
@section('title', 'My Mentees')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header and Stats -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Mentorship Management</h1>
            <p class="text-gray-500">Manage mentorship sessions and track progress</p>
        </div>
        <a href="#" class="bg-[#b81d8f] text-white px-5 py-2 rounded-lg font-semibold shadow hover:bg-[#a01a7d] transition">+ Schedule Session</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center">
            <div class="text-sm text-gray-500 mb-1">Total Sessions</div>
            <div class="text-2xl font-bold">3</div>
            <i class="bi bi-people-fill text-[#b81d8f] text-2xl mt-2"></i>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center">
            <div class="text-sm text-gray-500 mb-1">Scheduled</div>
            <div class="text-2xl font-bold">2</div>
            <i class="bi bi-calendar-event-fill text-blue-600 text-2xl mt-2"></i>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center">
            <div class="text-sm text-gray-500 mb-1">Completed</div>
            <div class="text-2xl font-bold text-green-600">1</div>
            <i class="bi bi-clock text-green-600 text-2xl mt-2"></i>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center">
            <div class="text-sm text-gray-500 mb-1">Avg. Rating</div>
            <div class="text-2xl font-bold text-orange-500">4.8</div>
            <i class="bi bi-star-fill text-orange-400 text-2xl mt-2"></i>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="border-b border-gray-200 mb-4">
            <nav class="flex space-x-8" aria-label="Tabs">
                <a href="#" class="text-[#b81d8f] border-b-2 border-[#b81d8f] px-1 pb-2 font-semibold">Scheduled (2)</a>
                <a href="#" class="text-gray-500 hover:text-[#b81d8f] px-1 pb-2">Completed (1)</a>
                <a href="#" class="text-gray-500 hover:text-[#b81d8f] px-1 pb-2">All (3)</a>
            </nav>
        </div>
        <!-- Session List -->
        <div class="space-y-6">
            <!-- Session Card Example -->
            <div class="bg-gray-50 rounded-lg p-4 flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" class="h-10 w-10 rounded-full" alt="Mentor">
                    <div>
                        <div class="font-semibold">Dr. Kemi Adebayo <span class="text-xs text-gray-400 ml-2">Mentor</span></div>
                        <div class="text-sm text-gray-500">Business Model Validation</div>
                        <div class="flex items-center text-xs text-gray-400 mt-1">
                            <i class="bi bi-calendar-event mr-1"></i> 2025-01-25 at 2:00 PM
                            <span class="mx-2">|</span>
                            <i class="bi bi-clock mr-1"></i> 60 minutes
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 mt-4 md:mt-0">
                    <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs font-semibold">Scheduled</span>
                    <button class="text-red-500 hover:underline text-xs">Cancel</button>
                    <button class="text-[#b81d8f] hover:underline text-xs">Reschedule</button>
                    <button class="bg-[#b81d8f] text-white px-3 py-1 rounded text-xs font-semibold">Join Session</button>
                </div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4">
                    <img src="https://randomuser.me/api/portraits/women/45.jpg" class="h-10 w-10 rounded-full" alt="Mentor">
                    <div>
                        <div class="font-semibold">Dr. Kemi Adebayo <span class="text-xs text-gray-400 ml-2">Mentor</span></div>
                        <div class="text-sm text-gray-500">Market Research Strategy</div>
                        <div class="flex items-center text-xs text-gray-400 mt-1">
                            <i class="bi bi-calendar-event mr-1"></i> 2025-01-28 at 11:00 AM
                            <span class="mx-2">|</span>
                            <i class="bi bi-clock mr-1"></i> 60 minutes
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 mt-4 md:mt-0">
                    <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs font-semibold">Scheduled</span>
                    <button class="text-red-500 hover:underline text-xs">Cancel</button>
                    <button class="text-[#b81d8f] hover:underline text-xs">Reschedule</button>
                    <button class="bg-[#b81d8f] text-white px-3 py-1 rounded text-xs font-semibold">Join Session</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 