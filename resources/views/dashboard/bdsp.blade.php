@extends('layouts.bdsp')

@section('title', 'BDSP Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Gradient Welcome Banner -->
    <div class="rounded-xl p-8 bg-gradient-to-r from-[#b81d8f] to-[#6c3483] text-white shadow-lg">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold mb-2">Good morning, {{ Auth::user()->name }}! 🌟</h2>
                <p class="text-base text-pink-100 max-w-xl">
                    You have 3 sessions scheduled today and 2 mentees need your attention.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 mt-4 md:mt-0">
                <a href="#" class="inline-block px-6 py-3 rounded-lg bg-white text-[#b81d8f] font-semibold text-sm shadow hover:bg-pink-50 transition">
                    View Schedule
                </a>
                <a href="#" class="inline-block px-6 py-3 rounded-lg border border-white text-white font-semibold text-sm hover:bg-white hover:text-[#b81d8f] transition">
                    Upload Resource
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Active Mentees</div>
                <div class="text-3xl font-bold text-gray-900">15</div>
                <div class="text-sm text-green-500">+25% from last month</div>
            </div>
            <div class="bg-pink-100 p-3 rounded-full">
                <i class="bi bi-person-fill text-[#b81d8f] text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Sessions This Month</div>
                <div class="text-3xl font-bold text-gray-900">32</div>
                <div class="text-sm text-gray-400">28 completed</div>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="bi bi-calendar-event-fill text-blue-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Resources Uploaded</div>
                <div class="text-3xl font-bold text-gray-900">24</div>
                <div class="text-sm text-green-500">+12% this quarter</div>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="bi bi-journal-arrow-up text-green-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Avg. Rating</div>
                <div class="text-3xl font-bold text-gray-900">4.8</div>
                <div class="text-sm text-gray-400">From mentees</div>
            </div>
            <div class="bg-orange-100 p-3 rounded-full">
                <i class="bi bi-star-fill text-orange-400 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Mentees and Sessions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- My Mentees -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">My Mentees</h3>
            <div class="space-y-4">
                <!-- Example mentee -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="bg-pink-100 text-[#b81d8f] font-bold rounded-full w-10 h-10 flex items-center justify-center">SJ</span>
                        <div>
                            <div class="font-semibold">Sarah Johnson</div>
                            <div class="text-xs text-gray-500">EcoTech Solutions</div>
                            <div class="text-xs text-gray-400">Last session: 2 days ago</div>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <div class="w-24 bg-gray-200 rounded-full h-2 mb-1">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                        <span class="text-xs text-blue-600">on track</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="bg-blue-100 text-blue-600 font-bold rounded-full w-10 h-10 flex items-center justify-center">MC</span>
                        <div>
                            <div class="font-semibold">Michael Chen</div>
                            <div class="text-xs text-gray-500">FinanceFlow</div>
                            <div class="text-xs text-gray-400">Last session: 1 week ago</div>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <div class="w-24 bg-gray-200 rounded-full h-2 mb-1">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width: 70%"></div>
                        </div>
                        <span class="text-xs text-yellow-600">needs attention</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="bg-green-100 text-green-600 font-bold rounded-full w-10 h-10 flex items-center justify-center">AP</span>
                        <div>
                            <div class="font-semibold">Aisha Patel</div>
                            <div class="text-xs text-gray-500">HealthTech Hub</div>
                            <div class="text-xs text-gray-400">Last session: 1 day ago</div>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <div class="w-24 bg-gray-200 rounded-full h-2 mb-1">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 95%"></div>
                        </div>
                        <span class="text-xs text-green-600">excellent</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="bg-purple-100 text-purple-600 font-bold rounded-full w-10 h-10 flex items-center justify-center">DW</span>
                        <div>
                            <div class="font-semibold">David Wilson</div>
                            <div class="text-xs text-gray-500">AgriSmart</div>
                            <div class="text-xs text-gray-400">Last session: 3 days ago</div>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <div class="w-24 bg-gray-200 rounded-full h-2 mb-1">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 60%"></div>
                        </div>
                        <span class="text-xs text-blue-600">on track</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Upcoming Sessions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">Upcoming Sessions</h3>
            <ul class="space-y-4">
                <li>
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-semibold">Sarah Johnson</div>
                            <div class="text-xs text-gray-500">Financial Modeling</div>
                            <div class="text-xs text-gray-400">Today 2:00 PM</div>
                        </div>
                        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs font-semibold">1-on-1</span>
                    </div>
                </li>
                <li>
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-semibold">Michael Chen</div>
                            <div class="text-xs text-gray-500">Market Strategy</div>
                            <div class="text-xs text-gray-400">Tomorrow 10:00 AM</div>
                        </div>
                        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs font-semibold">1-on-1</span>
                    </div>
                </li>
                <li>
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-semibold">Group Session</div>
                            <div class="text-xs text-gray-500">Pitch Preparation</div>
                            <div class="text-xs text-gray-400">Friday 3:00 PM</div>
                        </div>
                        <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs font-semibold">group</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- Recent Feedback -->
    <div class="mt-6">
        <h3 class="text-lg font-bold mb-4">Recent Feedback</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="font-semibold mb-2">Aisha Patel</div>
                <div class="text-yellow-400 mb-1">⭐⭐⭐⭐⭐</div>
                <div class="text-sm text-gray-600">"Excellent guidance on business model canvas"</div>
                <div class="text-xs text-gray-400 mt-2">1 day ago</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="font-semibold mb-2">David Wilson</div>
                <div class="text-yellow-400 mb-1">⭐⭐⭐⭐⭐</div>
                <div class="text-sm text-gray-600">"Very helpful session on market research"</div>
                <div class="text-xs text-gray-400 mt-2">3 days ago</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="font-semibold mb-2">Sarah Johnson</div>
                <div class="text-yellow-400 mb-1">⭐⭐⭐⭐⭐</div>
                <div class="text-sm text-gray-600">"Clear explanations on financial projections"</div>
                <div class="text-xs text-gray-400 mt-2">1 week ago</div>
            </div>
        </div>
    </div>
</div>
@endsection 