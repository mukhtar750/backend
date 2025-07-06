@extends('admin.layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Pitch Events Management</h1>
        <button class="bg-magenta text-white px-4 py-2 rounded-lg shadow hover:bg-magenta-700 transition flex items-center">
            <i class="bi bi-plus-circle mr-2"></i> Create New Event
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        @php
            $summaryCards = [
                ['title' => 'Total Events', 'value' => '5', 'icon' => 'bi-calendar-event', 'color' => 'magenta'],
                ['title' => 'Upcoming', 'value' => '2', 'icon' => 'bi-hourglass-split', 'color' => 'blue'],
                ['title' => 'Completed', 'value' => '3', 'icon' => 'bi-check-circle', 'color' => 'green'],
                ['title' => 'Avg. Participants', 'value' => '75', 'icon' => 'bi-people', 'color' => 'purple'],
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

    <!-- Tabs for Event Status -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="#" class="border-magenta-500 text-magenta-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" aria-current="page">Upcoming (2)</a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Completed (3)</a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">All (5)</a>
            </nav>
        </div>
    </div>

    <!-- Event Listings -->
    <div class="grid grid-cols-1 gap-6">
        <!-- Event 1 -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Annual Innovation Pitch Day</h3>
            <p class="text-gray-700 text-sm mb-4">Showcasing groundbreaking startups and their innovative solutions.</p>
            <div class="text-gray-700 text-sm mb-4">
                <p class="flex items-center"><i class="bi bi-calendar mr-2"></i> Date: 2025-03-15</p>
                <p class="flex items-center"><i class="bi bi-clock mr-2"></i> Time: 10:00 AM - 4:00 PM</p>
                <p class="flex items-center"><i class="bi bi-geo-alt mr-2"></i> Location: Virtual Event</p>
            </div>
            <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                <div class="flex space-x-3 text-gray-500">
                    <i class="bi bi-people text-lg cursor-pointer hover:text-magenta-600"></i> 120 Participants
                </div>
                <div class="flex items-center space-x-2">
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Upcoming</span>
                    <a href="#" class="text-gray-500 hover:text-gray-700 text-sm font-medium">View Details</a>
                    <button class="bg-magenta text-white px-3 py-1 rounded-lg shadow hover:bg-magenta-700 transition text-sm">Register</button>
                </div>
            </div>
        </div>

        <!-- Event 2 -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Tech Startup Showcase</h3>
            <p class="text-gray-700 text-sm mb-4">A platform for emerging tech startups to present their ventures to investors.</p>
            <div class="text-gray-700 text-sm mb-4">
                <p class="flex items-center"><i class="bi bi-calendar mr-2"></i> Date: 2025-04-20</p>
                <p class="flex items-center"><i class="bi bi-clock mr-2"></i> Time: 1:00 PM - 5:00 PM</p>
                <p class="flex items-center"><i class="bi bi-geo-alt mr-2"></i> Location: Conference Hall A</p>
            </div>
            <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                <div class="flex space-x-3 text-gray-500">
                    <i class="bi bi-people text-lg cursor-pointer hover:text-magenta-600"></i> 90 Participants
                </div>
                <div class="flex items-center space-x-2">
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Upcoming</span>
                    <a href="#" class="text-gray-500 hover:text-gray-700 text-sm font-medium">View Details</a>
                    <button class="bg-magenta text-white px-3 py-1 rounded-lg shadow hover:bg-magenta-700 transition text-sm">Register</button>
                </div>
            </div>
        </div>
    </div>
@endsection