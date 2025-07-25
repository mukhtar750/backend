@extends('layouts.investor')

@section('title', 'Investor Dashboard')

@section('content')
<div class="max-w-7xl mx-auto mt-8">
    <!-- Welcome Banner & Stats Row -->
    <div class="rounded-2xl p-8 md:p-10 mb-10 bg-gradient-to-r from-green-400 via-blue-500 to-purple-600 text-white shadow flex flex-col gap-6">
        <div class="flex items-center gap-3 mb-2">
            <span class="text-3xl font-bold">Welcome, {{ $investorName ?? (Auth::user()->name ?? 'Grace') }}!</span>
            <i class="bi bi-briefcase-fill text-2xl"></i>
        </div>
        <div class="text-lg text-white/90 mb-6">Discover the next generation of African startups ready for investment.</div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white/10 border border-white/30 rounded-xl p-5 flex flex-col items-center text-center hover:bg-white/20 transition">
                <div class="text-sm mb-1">Browse Startups</div>
                <div class="text-2xl font-bold text-white">{{ $startupsCount ?? 48 }} <span class="font-normal text-base">available</span></div>
            </div>
            <div class="bg-white/10 border border-white/30 rounded-xl p-5 flex flex-col items-center text-center hover:bg-white/20 transition">
                <div class="text-sm mb-1">Upcoming Pitches</div>
                <div class="text-2xl font-bold text-white">{{ $pitchesCount ?? 3 }} <span class="font-normal text-base">events</span></div>
            </div>
            <div class="bg-white/10 border border-white/30 rounded-xl p-5 flex flex-col items-center text-center hover:bg-white/20 transition">
                <div class="text-sm mb-1">Portfolio Value</div>
                <div class="text-2xl font-bold text-white">{{ $portfolioValue ?? '$2.5M' }}</div>
            </div>
            <div class="bg-white/10 border border-white/30 rounded-xl p-5 flex flex-col items-center text-center hover:bg-white/20 transition">
                <div class="text-sm mb-1">Success Rate</div>
                <div class="text-2xl font-bold text-white">{{ $successRate ?? '78%' }}</div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col items-start shadow-sm">
            <div class="flex items-center gap-2 mb-2">
                <i class="bi bi-graph-up-arrow text-purple-600 text-2xl"></i>
                <span class="text-sm font-medium text-gray-500">Startup Profiles</span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $startupProfiles ?? 48 }}</div>
            <div class="text-sm text-gray-400">{{ $startupProfilesNew ?? '12 new this month' }}</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col items-start shadow-sm">
            <div class="flex items-center gap-2 mb-2">
                <i class="bi bi-calendar-event-fill text-blue-600 text-2xl"></i>
                <span class="text-sm font-medium text-gray-500">Pitch Events</span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $pitchEvents ?? 8 }}</div>
            <div class="text-sm text-gray-400">{{ $pitchEventsUpcoming ?? '3 upcoming' }}</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col items-start shadow-sm">
            <div class="flex items-center gap-2 mb-2">
                <i class="bi bi-award-fill text-green-600 text-2xl"></i>
                <span class="text-sm font-medium text-gray-500">Success Stories</span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $successStories ?? 15 }}</div>
            <div class="text-sm text-green-600 font-semibold">{{ $successRateText ?? '+20% success rate' }}</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col items-start shadow-sm">
            <div class="flex items-center gap-2 mb-2">
                <i class="bi bi-eye-fill text-orange-600 text-2xl"></i>
                <span class="text-sm font-medium text-gray-500">Profile Views</span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $profileViews ?? 156 }}</div>
            <div class="text-sm text-green-600 font-semibold">{{ $profileViewsChange ?? '+35% this month' }}</div>
        </div>
    </div>

    <!-- Portfolio Insights -->
    <div class="bg-white rounded-xl border border-gray-200 p-8 mb-10 shadow-sm">
        <div class="text-lg font-semibold mb-6 text-gray-900">Portfolio Insights</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <div class="relative flex flex-col items-center justify-center">
                <div class="absolute inset-0 bg-white/80 flex items-center justify-center z-10 rounded-xl">
                    <span class="bg-yellow-100 text-yellow-800 px-4 py-1 rounded-full font-semibold text-sm shadow">Coming Soon!</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 opacity-30">{{ $portfolioTotal ?? '$2.5M' }}</div>
                <div class="text-sm text-gray-500 opacity-30">Total Investments</div>
                <div class="text-xs text-green-600 mt-1 opacity-30">{{ $portfolioTotalChange ?? '+15% This year' }}</div>
            </div>
            <div class="relative flex flex-col items-center justify-center">
                <div class="absolute inset-0 bg-white/80 flex items-center justify-center z-10 rounded-xl">
                    <span class="bg-yellow-100 text-yellow-800 px-4 py-1 rounded-full font-semibold text-sm shadow">Coming Soon!</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 opacity-30">{{ $portfolioActive ?? 12 }}</div>
                <div class="text-sm text-gray-500 opacity-30">Active Startups</div>
                <div class="text-xs text-green-600 mt-1 opacity-30">{{ $portfolioActiveChange ?? '+3 This quarter' }}</div>
            </div>
            <div class="relative flex flex-col items-center justify-center">
                <div class="absolute inset-0 bg-white/80 flex items-center justify-center z-10 rounded-xl">
                    <span class="bg-yellow-100 text-yellow-800 px-4 py-1 rounded-full font-semibold text-sm shadow">Coming Soon!</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 opacity-30">{{ $portfolioROI ?? '3.2x' }}</div>
                <div class="text-sm text-gray-500 opacity-30">Avg. ROI</div>
                <div class="text-xs text-green-600 mt-1 opacity-30">{{ $portfolioROIChange ?? '+0.5x Portfolio avg' }}</div>
            </div>
            <div class="relative flex flex-col items-center justify-center">
                <div class="absolute inset-0 bg-white/80 flex items-center justify-center z-10 rounded-xl">
                    <span class="bg-yellow-100 text-yellow-800 px-4 py-1 rounded-full font-semibold text-sm shadow">Coming Soon!</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 opacity-30">{{ $portfolioExits ?? 2 }}</div>
                <div class="text-sm text-gray-500 opacity-30">Exit Events</div>
                <div class="text-xs text-green-600 mt-1 opacity-30">{{ $portfolioExitsChange ?? '+1 This year' }}</div>
            </div>
        </div>
    </div>

    <!-- Investment Opportunities Filter Bar -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div class="text-lg font-semibold text-gray-900 mb-4 md:mb-0">Investment Opportunities</div>
        <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
            <select class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                <option>All Sectors</option>
                <option>FinTech</option>
                <option>Healthcare</option>
                <option>Sustainability</option>
                <option>E-commerce</option>
            </select>
            <select class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                <option>All Stages</option>
                <option>Seed</option>
                <option>Pre-Series A</option>
                <option>Series A</option>
            </select>
            <button class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2 hover:bg-green-700 transition">
                <i class="bi bi-funnel"></i> Apply Filters
            </button>
        </div>
    </div>

    <!-- Teaser Startup Cards (Limited View) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Example Card 1 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" class="rounded-full w-12 h-12" alt="">
                <div>
                    <div class="font-bold text-lg text-gray-900">EcoTech Solutions</div>
                    <div class="text-xs text-gray-500">by Sarah Johnson &middot; Updated 2 days ago</div>
                </div>
            </div>
            <div class="mb-2">
                <span class="text-xs text-gray-500">Sector</span>
                <span class="font-semibold text-gray-800 ml-2">Clean Technology</span>
            </div>
            <div class="mb-2">
                <span class="text-xs text-gray-500">Stage</span>
                <span class="font-semibold text-gray-800 ml-2">Seed</span>
            </div>
            <div class="mb-2 flex gap-4">
                <div><span class="text-xs text-gray-500">Seeking</span> <span class="font-semibold text-green-600 ml-1">$250K</span></div>
                <div><span class="text-xs text-gray-500">Revenue</span> <span class="font-semibold text-gray-800 ml-1">$25K MRR</span></div>
            </div>
            <div class="text-sm text-gray-600 mb-3">Sustainable packaging solutions for e-commerce businesses with biodegradable materials.</div>
            <div class="flex flex-wrap gap-2 mb-3">
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">B2B</span>
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">Sustainability</span>
                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">E-commerce</span>
            </div>
            <div class="flex justify-between text-xs text-gray-500 mb-3">
                <div>Traction <span class="font-semibold text-gray-800 ml-1">50K+ users</span></div>
                <div>Team Size <span class="font-semibold text-gray-800 ml-1">8 people</span></div>
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                <i class="bi bi-geo-alt"></i> Lagos, Nigeria
                <span class="ml-auto flex items-center gap-1 text-yellow-500"><i class="bi bi-star-fill"></i> 4.8</span>
            </div>
            <div class="flex gap-2 mt-auto">
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium flex-1 hover:bg-green-700 transition" data-request-access>View Profile</button>
                <button class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 font-medium flex-1 hover:bg-gray-100 transition">Request Access</button>
            </div>
        </div>
        <!-- Example Card 2 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-full w-12 h-12" alt="">
                <div>
                    <div class="font-bold text-lg text-gray-900">FinanceFlow</div>
                    <div class="text-xs text-gray-500">by Michael Chen &middot; Updated 1 day ago</div>
                </div>
            </div>
            <div class="mb-2">
                <span class="text-xs text-gray-500">Sector</span>
                <span class="font-semibold text-gray-800 ml-2">Fintech</span>
            </div>
            <div class="mb-2">
                <span class="text-xs text-gray-500">Stage</span>
                <span class="font-semibold text-gray-800 ml-2">Pre-Series A</span>
            </div>
            <div class="mb-2 flex gap-4">
                <div><span class="text-xs text-gray-500">Seeking</span> <span class="font-semibold text-green-600 ml-1">$500K</span></div>
                <div><span class="text-xs text-gray-500">Revenue</span> <span class="font-semibold text-gray-800 ml-1">$45K MRR</span></div>
            </div>
            <div class="text-sm text-gray-600 mb-3">Digital banking platform for small businesses across Africa with integrated payment solutions.</div>
            <div class="flex flex-wrap gap-2 mb-3">
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">B2B</span>
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">Banking</span>
                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">Payments</span>
            </div>
            <div class="flex justify-between text-xs text-gray-500 mb-3">
                <div>Traction <span class="font-semibold text-gray-800 ml-1">1K+ businesses</span></div>
                <div>Team Size <span class="font-semibold text-gray-800 ml-1">12 people</span></div>
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                <i class="bi bi-geo-alt"></i> Cape Town, South Africa
                <span class="ml-auto flex items-center gap-1 text-yellow-500"><i class="bi bi-star-fill"></i> 4.6</span>
            </div>
            <div class="flex gap-2 mt-auto">
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium flex-1 hover:bg-green-700 transition" data-request-access>View Profile</button>
                <button class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 font-medium flex-1 hover:bg-gray-100 transition">Request Access</button>
            </div>
        </div>
        <!-- Example Card 3 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <img src="https://randomuser.me/api/portraits/men/54.jpg" class="rounded-full w-12 h-12" alt="">
                <div>
                    <div class="font-bold text-lg text-gray-900">HealthTech Hub</div>
                    <div class="text-xs text-gray-500">by Aisha Patel &middot; Updated 3 hours ago</div>
                </div>
            </div>
            <div class="mb-2">
                <span class="text-xs text-gray-500">Sector</span>
                <span class="font-semibold text-gray-800 ml-2">Healthcare</span>
            </div>
            <div class="mb-2">
                <span class="text-xs text-gray-500">Stage</span>
                <span class="font-semibold text-gray-800 ml-2">Series A</span>
            </div>
            <div class="mb-2 flex gap-4">
                <div><span class="text-xs text-gray-500">Seeking</span> <span class="font-semibold text-green-600 ml-1">$1M</span></div>
                <div><span class="text-xs text-gray-500">Revenue</span> <span class="font-semibold text-gray-800 ml-1">$80K MRR</span></div>
            </div>
            <div class="text-sm text-gray-600 mb-3">Telemedicine platform connecting patients with healthcare providers across rural Africa.</div>
            <div class="flex flex-wrap gap-2 mb-3">
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">B2C</span>
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">Healthcare</span>
                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">Telemedicine</span>
            </div>
            <div class="flex justify-between text-xs text-gray-500 mb-3">
                <div>Traction <span class="font-semibold text-gray-800 ml-1">10K+ patients</span></div>
                <div>Team Size <span class="font-semibold text-gray-800 ml-1">15 people</span></div>
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                <i class="bi bi-geo-alt"></i> Nairobi, Kenya
                <span class="ml-auto flex items-center gap-1 text-yellow-500"><i class="bi bi-star-fill"></i> 4.9</span>
            </div>
            <div class="flex gap-2 mt-auto">
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium flex-1 hover:bg-green-700 transition" data-request-access>View Profile</button>
                <button class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 font-medium flex-1 hover:bg-gray-100 transition">Request Access</button>
            </div>
        </div>
    </div>

    <!-- IRP Impact Stories / Success Stories Placeholder -->
    <div class="bg-white rounded-xl border border-gray-200 p-8 mb-10 shadow-sm">
        <div class="text-lg font-semibold mb-4 text-gray-900">IRP Impact Stories & Success Stories</div>
        <div class="text-gray-500 text-sm">Curated stories and anonymized pitch deck teasers will appear here. Investors can request access for deeper engagement.</div>
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