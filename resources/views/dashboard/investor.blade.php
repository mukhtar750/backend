@extends('layouts.investor')

@section('title', 'Investor Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-green-400 to-blue-500 rounded-xl p-6 text-white flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">
                Welcome, {{ Auth::user()->name }}! 👋
            </h2>
            <p>Discover the next generation of African startups ready for investment.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-2">
            <button class="bg-white text-green-600 font-semibold px-4 py-2 rounded shadow">Browse Startups</button>
            <button class="bg-white text-green-600 font-semibold px-4 py-2 rounded shadow">Upcoming Pitches</button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Startup Profiles</div>
                <div class="text-3xl font-bold text-gray-900">48</div>
                <div class="text-sm text-gray-400">12 new this month</div>
            </div>
            <div class="bg-purple-100 p-3 rounded-full">
                <i class="bi bi-people-fill text-purple-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Pitch Events</div>
                <div class="text-3xl font-bold text-gray-900">8</div>
                <div class="text-sm text-gray-400">3 upcoming</div>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="bi bi-calendar-event-fill text-blue-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Success Stories</div>
                <div class="text-3xl font-bold text-gray-900">15</div>
                <div class="text-sm text-green-500">+20% success rate</div>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="bi bi-award-fill text-green-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Profile Views</div>
                <div class="text-3xl font-bold text-gray-900">156</div>
                <div class="text-sm text-green-500">+35% this month</div>
            </div>
            <div class="bg-orange-100 p-3 rounded-full">
                <i class="bi bi-eye-fill text-orange-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Investment Opportunities -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
            <h3 class="text-lg font-bold">Investment Opportunities</h3>
            <div class="flex space-x-2 mt-2 md:mt-0">
                <select class="border rounded px-2 py-1 text-sm">
                    <option>All Sectors</option>
                    <option>FinTech</option>
                    <option>HealthTech</option>
                    <option>Clean Technology</option>
                </select>
                <select class="border rounded px-2 py-1 text-sm">
                    <option>All Stages</option>
                    <option>Seed</option>
                    <option>Pre-Series A</option>
                    <option>Series A</option>
                </select>
                <button class="bg-green-500 text-white px-4 py-1 rounded">Filter</button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Startup Card 1 -->
            <div class="bg-gray-50 rounded-lg p-4 shadow flex flex-col">
                <div class="flex items-center space-x-2 mb-2">
                    <img src="https://i.pravatar.cc/40?img=1" class="rounded-full w-10 h-10" alt="">
                    <div>
                        <div class="font-bold">EcoTech Solutions</div>
                        <div class="text-xs text-gray-500">by Sarah Johnson</div>
                    </div>
                </div>
                <div class="text-xs text-gray-600">Sector: Clean Technology</div>
                <div class="text-xs text-gray-600">Stage: Seed</div>
                <div class="text-xs text-green-600 font-bold">Seeking: $250K</div>
                <p class="text-xs mt-2">Sustainable packaging solutions for e-commerce businesses</p>
                <div class="flex items-center justify-between mt-4">
                    <button class="bg-green-500 text-white px-4 py-1 rounded">View Profile</button>
                    <div class="flex items-center text-yellow-500 text-sm">
                        ★★★★☆ 4.8
                    </div>
                </div>
            </div>
            <!-- Startup Card 2 -->
            <div class="bg-gray-50 rounded-lg p-4 shadow flex flex-col">
                <div class="flex items-center space-x-2 mb-2">
                    <img src="https://i.pravatar.cc/40?img=2" class="rounded-full w-10 h-10" alt="">
                    <div>
                        <div class="font-bold">FinanceFlow</div>
                        <div class="text-xs text-gray-500">by Michael Chen</div>
                    </div>
                </div>
                <div class="text-xs text-gray-600">Sector: FinTech</div>
                <div class="text-xs text-gray-600">Stage: Pre-Series A</div>
                <div class="text-xs text-green-600 font-bold">Seeking: $500K</div>
                <p class="text-xs mt-2">Digital banking platform for small businesses across Africa</p>
                <div class="flex items-center justify-between mt-4">
                    <button class="bg-green-500 text-white px-4 py-1 rounded">View Profile</button>
                    <div class="flex items-center text-yellow-500 text-sm">
                        ★★★★☆ 4.6
                    </div>
                </div>
            </div>
            <!-- Startup Card 3 -->
            <div class="bg-gray-50 rounded-lg p-4 shadow flex flex-col">
                <div class="flex items-center space-x-2 mb-2">
                    <img src="https://i.pravatar.cc/40?img=3" class="rounded-full w-10 h-10" alt="">
                    <div>
                        <div class="font-bold">HealthTech Hub</div>
                        <div class="text-xs text-gray-500">by Aisha Patel</div>
                    </div>
                </div>
                <div class="text-xs text-gray-600">Sector: HealthTech</div>
                <div class="text-xs text-gray-600">Stage: Series A</div>
                <div class="text-xs text-green-600 font-bold">Seeking: $1M</div>
                <p class="text-xs mt-2">Telemedicine platform connecting patients with healthcare providers</p>
                <div class="flex items-center justify-between mt-4">
                    <button class="bg-green-500 text-white px-4 py-1 rounded">View Profile</button>
                    <div class="flex items-center text-yellow-500 text-sm">
                        ★★★★★ 4.9
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Pitch Events & Opportunities by Sector -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Upcoming Pitch Events -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">Upcoming Pitch Events</h3>
            <ul class="space-y-4">
                <li>
                    <div class="flex justify-between items-center">
                        <span class="font-semibold">EdTech Showcase</span>
                        <span class="text-sm text-gray-500">March 15, 2025</span>
                    </div>
                    <div class="text-xs text-gray-500">Virtual &middot; 8 startups</div>
                </li>
                <li>
                    <div class="flex justify-between items-center">
                        <span class="font-semibold">FinTech Innovation Day</span>
                        <span class="text-sm text-gray-500">March 22, 2025</span>
                    </div>
                    <div class="text-xs text-gray-500">Lagos, Nigeria &middot; 12 startups</div>
                </li>
                <li>
                    <div class="flex justify-between items-center">
                        <span class="font-semibold">HealthTech Summit</span>
                        <span class="text-sm text-gray-500">April 5, 2025</span>
                    </div>
                    <div class="text-xs text-gray-500">Cape Town, South Africa &middot; 15 startups</div>
                </li>
            </ul>
            <a href="#" class="text-green-600 text-sm font-semibold mt-4 inline-block">View All Events</a>
        </div>

        <!-- Opportunities by Sector -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">Opportunities by Sector</h3>
            <div class="mb-4">
                <div class="flex justify-between items-center mb-1">
                    <span class="font-semibold">FinTech</span>
                    <span class="text-green-600 font-bold">+25%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                    <div class="bg-green-400 h-2 rounded-full" style="width: 25%"></div>
                </div>
                <div class="text-xs text-gray-500">18 startups</div>
            </div>
            <div class="mb-4">
                <div class="flex justify-between items-center mb-1">
                    <span class="font-semibold">HealthTech</span>
                    <span class="text-green-600 font-bold">+40%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                    <div class="bg-blue-400 h-2 rounded-full" style="width: 40%"></div>
                </div>
                <div class="text-xs text-gray-500">12 startups</div>
            </div>
            <div class="mb-4">
                <div class="flex justify-between items-center mb-1">
                    <span class="font-semibold">AgriTech</span>
                    <span class="text-green-600 font-bold">+15%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                    <div class="bg-yellow-400 h-2 rounded-full" style="width: 15%"></div>
                </div>
                <div class="text-xs text-gray-500">8 startups</div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="font-semibold">EdTech</span>
                    <span class="text-green-600 font-bold">+30%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                    <div class="bg-purple-400 h-2 rounded-full" style="width: 30%"></div>
                </div>
                <div class="text-xs text-gray-500">10 startups</div>
            </div>
        </div>
    </div>
</div>
@endsection