@extends('layouts.entrepreneur')
@section('title', 'Entrepreneur Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Gradient Welcome Banner -->
    <div class="rounded-xl p-8 bg-gradient-to-r from-[#7b2ff2] to-[#f357a8] text-white shadow-lg">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-base text-pink-100 max-w-xl">You're making great progress in your investment readiness journey.</p>
                <div class="flex flex-col sm:flex-row gap-3 mt-4">
                    <div class="bg-[#a259e6] bg-opacity-80 rounded-lg px-4 py-2 flex flex-col items-center">
                        <span class="text-xs text-white">Next Milestone</span>
                        <span class="font-semibold text-white">Pitch Deck Completion</span>
                    </div>
                    <div class="bg-[#a259e6] bg-opacity-80 rounded-lg px-4 py-2 flex flex-col items-center">
                        <span class="text-xs text-white">Days Left</span>
                        <span class="font-semibold text-white">14 days</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center">
            <div class="text-sm text-gray-500 mb-1">Progress</div>
            <div class="text-3xl font-bold">68%</div>
            <div class="text-xs text-gray-400">Program completion</div>
            <div class="mt-2"><i class="bi bi-graph-up text-green-500 text-2xl"></i></div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center">
            <div class="text-sm text-gray-500 mb-1">Training Sessions</div>
            <div class="text-3xl font-bold">12</div>
            <div class="text-xs text-gray-400">8 completed</div>
            <div class="mt-2"><i class="bi bi-journal-text text-blue-500 text-2xl"></i></div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center">
            <div class="text-sm text-gray-500 mb-1">Mentorship Hours</div>
            <div class="text-3xl font-bold">24</div>
            <div class="text-xs text-green-500">+15% this month</div>
            <div class="mt-2"><i class="bi bi-person-lines-fill text-purple-500 text-2xl"></i></div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex flex-col items-center">
            <div class="text-sm text-gray-500 mb-1">Pitch Ready</div>
            <div class="text-3xl font-bold">85%</div>
            <div class="text-xs text-gray-400">Assessment score</div>
            <div class="mt-2"><i class="bi bi-easel text-orange-500 text-2xl"></i></div>
        </div>
    </div>

    <!-- Learning Progress & Upcoming Tasks -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-bold">Learning Progress</h3>
                <span class="text-xs text-[#b81d8f] font-semibold">68% Complete</span>
            </div>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-xs mb-1"><span>Business Model Canvas</span><span class="text-gray-400">100%</span></div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs mb-1"><span>Financial Planning</span><span class="text-gray-400">80%</span></div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 80%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs mb-1"><span>Market Research</span><span class="text-gray-400">100%</span></div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs mb-1"><span>Pitch Deck Creation</span><span class="text-gray-400">60%</span></div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 60%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs mb-1"><span>Legal Framework</span><span class="text-gray-400">0%</span></div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gray-300 h-2 rounded-full" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">Upcoming Tasks</h3>
            <ul class="space-y-3">
                <li class="flex items-center justify-between">
                    <div class="flex items-center"><span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>Submit Financial Projections</div>
                    <span class="text-xs text-gray-400">Due Tomorrow</span>
                </li>
                <li class="flex items-center justify-between">
                    <div class="flex items-center"><span class="w-2 h-2 rounded-full bg-yellow-400 mr-2"></span>Complete Market Analysis Quiz</div>
                    <span class="text-xs text-gray-400">Due 3 days</span>
                </li>
                <li class="flex items-center justify-between">
                    <div class="flex items-center"><span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>Schedule Mentor Meeting</div>
                    <span class="text-xs text-gray-400">Due 1 week</span>
                </li>
                <li class="flex items-center justify-between">
                    <div class="flex items-center"><span class="w-2 h-2 rounded-full bg-purple-500 mr-2"></span>Pitch Deck Review Session</div>
                    <span class="text-xs text-gray-400">Due 2 weeks</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Recent Achievements -->
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <h3 class="text-lg font-bold mb-4">Recent Achievements</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg flex items-center">
                <i class="bi bi-award-fill text-yellow-400 text-2xl mr-3"></i>
                <div>
                    <div class="font-semibold">Business Model Workshop</div>
                    <div class="text-xs text-yellow-600">Expert</div>
                    <div class="text-xs text-gray-400">2 days ago</div>
                </div>
            </div>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg flex items-center">
                <i class="bi bi-star-fill text-yellow-400 text-2xl mr-3"></i>
                <div>
                    <div class="font-semibold">Financial Literacy Test</div>
                    <div class="text-xs text-yellow-600">Excellence</div>
                    <div class="text-xs text-gray-400">1 week ago</div>
                </div>
            </div>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg flex items-center">
                <i class="bi bi-trophy-fill text-yellow-400 text-2xl mr-3"></i>
                <div>
                    <div class="font-semibold">Market Research Project</div>
                    <div class="text-xs text-yellow-600">Outstanding</div>
                    <div class="text-xs text-gray-400">2 weeks ago</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 