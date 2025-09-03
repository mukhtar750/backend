@extends('admin.layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Training Programs</h1>
        <button class="bg-[#b81d8f] hover:bg-[#a01a7d] text-white px-4 py-2 rounded-lg shadow transition flex items-center">
            <i class="bi bi-plus-circle mr-2"></i> Create Training
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        @php
            $summaryCards = [
                ['title' => 'Total Programs', 'value' => '3', 'icon' => 'bi-book', 'color' => 'purple'],
                ['title' => 'Upcoming', 'value' => '2', 'icon' => 'bi-calendar-check', 'color' => 'blue'],
                ['title' => 'Total Participants', 'value' => '60', 'icon' => 'bi-people', 'color' => 'green'],
                ['title' => 'Avg. Attendance', 'value' => '87%', 'icon' => 'bi-clock', 'color' => 'orange'],
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

    <!-- Tabs for Program Status -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="#" class="border-[#b81d8f] text-[#b81d8f] whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" aria-current="page">Upcoming (2)</a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Ongoing (1)</a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Completed (0)</a>
            </nav>
        </div>
    </div>

    <!-- Program Listings -->
    <div x-data="{ showModal: false, participants: [], meetingLink: '' }" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Business Model Canvas Workshop -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="bi bi-book text-[#b81d8f] mr-3 text-2xl"></i> Business Model Canvas Workshop
                </h3>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Upcoming</span>
            </div>
            <p class="text-gray-600 mb-4">Learn to create and validate your business model using the proven Business Model Canvas framework.</p>
            <div class="text-gray-700 text-sm mb-4">
                <p><strong>Instructor:</strong> Dr. Kemi Adebayo</p>
                <p><strong>Date & Time:</strong> 2025-01-25 at 10:00 AM</p>
                <p><strong>Duration:</strong> 180 minutes</p>
                <p><strong>Participants:</strong> 18/25</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm mb-1">Registration Progress</p>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-[#b81d8f] h-2.5 rounded-full" style="width: 72%"></div>
                </div>
                <p class="text-right text-gray-500 text-xs mt-1">72%</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm mb-2">Materials:</p>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">Canvas Template</span>
                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">Case Studies</span>
                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">Workbook</span>
                </div>
            </div>
            <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                <div class="flex space-x-3 text-gray-500">
                    <i class="bi bi-eye text-lg cursor-pointer hover:text-[#b81d8f]"></i>
                    <i class="bi bi-pencil text-lg cursor-pointer hover:text-[#b81d8f]"></i>
                    <i class="bi bi-trash text-lg cursor-pointer hover:text-[#b81d8f]"></i>
                </div>
                <div class="flex gap-3 items-center">
                    <!-- Join Session button (show if meeting link exists) -->
                    <a href="https://zoom.us/j/123456789" target="_blank" class="flex items-center gap-2 bg-pink-600 text-white px-5 py-2 rounded-xl shadow-lg hover:bg-pink-700 transition text-sm font-bold border-2 border-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-300">
                        <i class="bi bi-camera-video-fill text-lg"></i>
                        Join Session
                    </a>
                    <!-- View Participants button -->
                    <button @click="showModal = true; participants = ['Aisha Muhammad', 'Musa Abdul', 'Grace Mwangi']; meetingLink = 'https://zoom.us/j/123456789'" class="flex items-center gap-2 bg-blue-50 text-blue-700 px-4 py-2 rounded-lg shadow hover:bg-blue-100 transition text-sm font-semibold border border-blue-200">
                        <i class="bi bi-people-fill text-lg"></i>
                        View Participants
                    </button>
                </div>
            </div>
        </div>
        <!-- Financial Planning for Startups -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="bi bi-camera-video text-[#b81d8f] mr-3 text-2xl"></i> Financial Planning for Startups
                </h3>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Upcoming</span>
            </div>
            <p class="text-gray-600 mb-4">Master the fundamentals of financial planning, forecasting, and investor-ready financial models.</p>
            <div class="text-gray-700 text-sm mb-4">
                <p><strong>Instructor:</strong> Grace Mwangi</p>
                <p><strong>Date & Time:</strong> 2025-01-28 at 2:00 PM</p>
                <p><strong>Duration:</strong> 120 minutes</p>
                <p><strong>Participants:</strong> 22/30</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm mb-1">Registration Progress</p>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-[#b81d8f] h-2.5 rounded-full" style="width: 73%"></div>
                </div>
                <p class="text-right text-gray-500 text-xs mt-1">73%</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm mb-2">Materials:</p>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">Financial Templates</span>
                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">Excel Models</span>
                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">Reading List</span>
                </div>
            </div>
            <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                <div class="flex space-x-3 text-gray-500">
                    <i class="bi bi-eye text-lg cursor-pointer hover:text-[#b81d8f]"></i>
                    <i class="bi bi-pencil text-lg cursor-pointer hover:text-[#b81d8f]"></i>
                    <i class="bi bi-trash text-lg cursor-pointer hover:text-[#b81d8f]"></i>
                </div>
                <div class="flex gap-3 items-center">
                    <!-- Join Session button (show if meeting link exists) -->
                    <a href="https://zoom.us/j/987654321" target="_blank" class="flex items-center gap-2 bg-pink-600 text-white px-5 py-2 rounded-xl shadow-lg hover:bg-pink-700 transition text-sm font-bold border-2 border-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-300">
                        <i class="bi bi-camera-video-fill text-lg"></i>
                        Join Session
                    </a>
                    <!-- View Participants button -->
                    <button @click="showModal = true; participants = ['John Doe', 'Fatima Al-Rashid', 'Kwame Asante']; meetingLink = 'https://zoom.us/j/987654321'" class="flex items-center gap-2 bg-blue-50 text-blue-700 px-4 py-2 rounded-lg shadow hover:bg-blue-100 transition text-sm font-semibold border border-blue-200">
                        <i class="bi bi-people-fill text-lg"></i>
                        View Participants
                    </button>
                </div>
            </div>
        </div>
        <!-- Modal for Participants -->
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40" style="display: none;" @keydown.escape.window="showModal = false">
            <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative">
                <button @click="showModal = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
                <h4 class="text-lg font-bold mb-4 flex items-center gap-2"><i class="bi bi-people-fill"></i> Participants</h4>
                <ul class="mb-6">
                    <template x-for="participant in participants" :key="participant">
                        <li class="py-2 border-b last:border-b-0 text-gray-700 flex items-center gap-2">
                            <i class="bi bi-person-circle text-pink-600"></i>
                            <span x-text="participant"></span>
                        </li>
                    </template>
                </ul>
                <a :href="meetingLink" target="_blank" class="flex items-center gap-2 bg-pink-600 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-pink-700 transition text-base font-bold border-2 border-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-300 w-full justify-center">
                    <i class="bi bi-camera-video-fill text-lg"></i>
                    Join Session
                </a>
            </div>
        </div>
    </div>
@endsection