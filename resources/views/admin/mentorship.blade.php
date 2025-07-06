@extends('admin.layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mentorship Management</h1>
        <button class="bg-magenta text-white px-4 py-2 rounded-lg shadow hover:bg-magenta-700 transition flex items-center">
            <i class="bi bi-plus-circle mr-2"></i> Schedule Session
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        @php
            $summaryCards = [
                ['title' => 'Total Sessions', 'value' => '3', 'icon' => 'bi-people', 'color' => 'magenta'],
                ['title' => 'Scheduled', 'value' => '2', 'icon' => 'bi-calendar-check', 'color' => 'blue'],
                ['title' => 'Completed', 'value' => '1', 'icon' => 'bi-check-circle', 'color' => 'green'],
                ['title' => 'Avg. Rating', 'value' => '4.8', 'icon' => 'bi-star', 'color' => 'orange'],
            ];
        @endphp

        @foreach ($summaryCards as $card)
            <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
                <div>
                    <p class="text-gray-500">{{ $card['title'] }}</p>
                    <div class="text-2xl font-bold text-{{ $card['color'] }}-600">{{ $card['value'] }}</div>
                </div>
                <i class="bi {{ $card['icon'] }} text-{{ $card['color'] }}-400 text-4xl"></i>
            </div>
        @endforeach
    </div>

    <!-- Tabs for Session Status -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="#" class="border-magenta-500 text-magenta-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" aria-current="page">Scheduled (2)</a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Completed (1)</a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">All (3)</a>
            </nav>
        </div>
    </div>

    <!-- Session Listings -->
    <div class="grid grid-cols-1 gap-6">
        <!-- Business Model Validation Session -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center mb-4">
                <img src="https://via.placeholder.com/40" alt="Mentor Avatar" class="rounded-full mr-3">
                <div>
                    <p class="font-semibold text-gray-800">Dr. Kemi Adebayo</p>
                    <p class="text-gray-500 text-sm">Mentor</p>
                </div>
                <i class="bi bi-camera-video text-gray-400 text-xl ml-auto cursor-pointer"></i>
                <img src="https://via.placeholder.com/40" alt="Mentee Avatar" class="rounded-full ml-4 mr-3">
                <div>
                    <p class="font-semibold text-gray-800">Fatima Al-Rashid</p>
                    <p class="text-gray-500 text-sm">Mentee</p>
                </div>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Business Model Validation</h3>
            <div class="text-gray-700 text-sm mb-4">
                <p class="flex items-center"><i class="bi bi-calendar mr-2"></i> 2025-01-25 at 2:00 PM</p>
                <p class="flex items-center"><i class="bi bi-clock mr-2"></i> 60 minutes</p>
            </div>
            <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                <div class="flex space-x-3 text-gray-500">
                    <i class="bi bi-file-earmark-text text-lg cursor-pointer hover:text-magenta-600"></i>
                    <i class="bi bi-envelope text-lg cursor-pointer hover:text-magenta-600"></i>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Scheduled</span>
                    <a href="#" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Cancel</a>
                    <a href="#" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Reschedule</a>
                    <button class="bg-magenta text-white px-3 py-1 rounded-lg shadow hover:bg-magenta-700 transition text-sm">Join Session</button>
                </div>
            </div>
        </div>

        <!-- Market Research Strategy Session -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center mb-4">
                <img src="https://via.placeholder.com/40" alt="Mentor Avatar" class="rounded-full mr-3">
                <div>
                    <p class="font-semibold text-gray-800">Dr. Kemi Adebayo</p>
                    <p class="text-gray-500 text-sm">Mentor</p>
                </div>
                <i class="bi bi-telephone text-gray-400 text-xl ml-auto cursor-pointer"></i>
                <img src="https://via.placeholder.com/40" alt="Mentee Avatar" class="rounded-full ml-4 mr-3">
                <div>
                    <p class="font-semibold text-gray-800">Amina Hassan</p>
                    <p class="text-gray-500 text-sm">Mentee</p>
                </div>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Market Research Strategy</h3>
            <div class="text-gray-700 text-sm mb-4">
                <p class="flex items-center"><i class="bi bi-calendar mr-2"></i> 2025-01-28 at 11:00 AM</p>
                <p class="flex items-center"><i class="bi bi-clock mr-2"></i> 60 minutes</p>
            </div>
            <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                <div class="flex space-x-3 text-gray-500">
                    <i class="bi bi-file-earmark-text text-lg cursor-pointer hover:text-magenta-600"></i>
                    <i class="bi bi-envelope text-lg cursor-pointer hover:text-magenta-600"></i>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Scheduled</span>
                    <a href="#" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Cancel</a>
                    <a href="#" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Reschedule</a>
                    <button class="bg-magenta text-white px-3 py-1 rounded-lg shadow hover:bg-magenta-700 transition text-sm">Join Session</button>
                </div>
            </div>
        </div>
    </div>
@endsection