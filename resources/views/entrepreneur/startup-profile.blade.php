@extends('layouts.entrepreneur')

@section('title', 'My Startup Profile')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2"><i class="bi bi-building text-[#b81d8f]"></i> My Startup Profile</h1>
        @if($startup)
            <a href="{{ route('entrepreneur.startup-profile.edit', $startup->id) }}" class="bg-[#b81d8f] text-white px-4 py-2 rounded-lg shadow hover:bg-[#a01a7d] transition flex items-center">
                <i class="bi bi-pencil-fill mr-2"></i> Edit Profile
            </a>
        @else
            <a href="{{ route('entrepreneur.startup-profile.create') }}" class="bg-[#b81d8f] text-white px-4 py-2 rounded-lg shadow hover:bg-[#a01a7d] transition flex items-center">
                <i class="bi bi-plus-lg mr-2"></i> Create Profile
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if(!$startup)
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="bi bi-info-circle text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-blue-700">You haven't created a startup profile yet. Click the "Create Profile" button to get started.</p>
                </div>
            </div>
        </div>
    @else
        @if($startup->status == 'pending')
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="bi bi-exclamation-triangle text-yellow-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-yellow-700">Your startup profile is pending approval from an administrator.</p>
                    </div>
                </div>
            </div>
        @elseif($startup->status == 'rejected')
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="bi bi-x-circle text-red-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-red-700">Your startup profile has been rejected. Please update your information and resubmit.</p>
                    </div>
                </div>
            </div>
        @elseif($startup->status == 'active')
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="bi bi-check-circle text-green-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-700">Your startup profile is approved and visible to investors.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Investor Teaser Section -->
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-lg mb-6 border border-pink-100">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="bi bi-eye-fill text-[#b81d8f] mr-2"></i> Investor Teaser View
                    <span class="ml-2 text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">What investors see</span>
                </h2>
                
                <!-- Anonymous Teaser Status -->
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-600">Anonymous Teaser:</span>
                    <span class="text-xs {{ $startup->anonymous_teaser ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} px-2 py-1 rounded-full">
                        {{ $startup->anonymous_teaser ? 'ON' : 'OFF' }}
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Logo and Basic Info -->
                <div class="md:col-span-1">
                    <div class="flex flex-col items-center">
                        @if($startup->logo)
                            <img src="{{ asset('storage/' . $startup->logo) }}" alt="{{ $startup->anonymous_teaser ? 'Anonymous Startup' : $startup->name }}" class="w-24 h-24 object-cover rounded-full mb-3">
                        @else
                            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-3">
                                <i class="bi bi-building text-gray-400 text-3xl"></i>
                            </div>
                        @endif
                        <h3 class="text-lg font-bold text-center">{{ $startup->anonymous_teaser ? 'Anonymous Startup' : $startup->name }}</h3>
                        @if($startup->tagline && !$startup->anonymous_teaser)
                            <p class="text-sm text-gray-600 text-center italic">"{{ $startup->tagline }}"</p>
                        @endif
                    </div>
                </div>
                
                <!-- Teaser Info -->
                <div class="md:col-span-2">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-xs text-gray-500">Industry</p>
                            <p class="font-medium text-sm">{{ $startup->sector }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Business Model</p>
                            <p class="font-medium text-sm">{{ $startup->business_model ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Location</p>
                            <p class="font-medium text-sm">{{ $startup->headquarters_location ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Founded</p>
                            <p class="font-medium text-sm">{{ $startup->year_founded ?? 'Not specified' }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <p class="text-xs text-gray-500 mb-1">Brief Description</p>
                        <p class="text-sm text-gray-700 line-clamp-3">{{ $startup->description ?? 'No description provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Investor Teaser View -->
            @if(auth()->user()->role === 'investor')
            <div class="md:col-span-3">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-lg mb-6 border border-pink-100">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="bi bi-eye-fill text-[#b81d8f] mr-2"></i> Startup Teaser
                        <span class="ml-2 text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">Limited information preview</span>
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Logo and Basic Info -->
                        <div class="md:col-span-1">
                            <div class="flex flex-col items-center">
                                @if($startup->logo)
                                    <img src="{{ asset('storage/' . $startup->logo) }}" alt="{{ $startup->name }}" class="w-24 h-24 object-cover rounded-full mb-3">
                                @else
                                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-3">
                                        <i class="bi bi-building text-gray-400 text-3xl"></i>
                                    </div>
                                @endif
                                <h3 class="text-lg font-bold text-center">{{ $startup->name }}</h3>
                                @if($startup->tagline)
                                    <p class="text-sm text-gray-600 text-center italic">"{{ $startup->tagline }}"</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Teaser Info -->
                        <div class="md:col-span-2">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-xs text-gray-500">Industry</p>
                                    <p class="font-medium text-sm">{{ $startup->sector }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Business Model</p>
                                    <p class="font-medium text-sm">{{ $startup->business_model ?? 'Not specified' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Location</p>
                                    <p class="font-medium text-sm">{{ $startup->headquarters_location ?? 'Not specified' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Founded</p>
                                    <p class="font-medium text-sm">{{ $startup->year_founded ?? 'Not specified' }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <p class="text-xs text-gray-500 mb-1">Brief Description</p>
                                <p class="text-sm text-gray-700 line-clamp-3">{{ $startup->description ?? 'No description provided.' }}</p>
                            </div>
                            
                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('investor.request-access', $startup->id) }}" class="inline-flex items-center px-3 py-1.5 bg-[#b81d8f] text-white text-sm rounded-md hover:bg-[#9a1977] transition">
                                    <i class="bi bi-unlock mr-1"></i> Request Full Access
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- Profile Overview -->
            <div class="md:col-span-1 bg-gray-50 p-6 rounded-lg">
                <div class="flex flex-col items-center mb-6">
                    @if($startup->logo)
                        <img src="{{ asset('storage/' . $startup->logo) }}" alt="{{ $startup->name }}" class="w-32 h-32 object-cover rounded-full mb-4">
                    @else
                        <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                            <i class="bi bi-building text-gray-400 text-5xl"></i>
                        </div>
                    @endif
                    <h2 class="text-xl font-bold text-center">{{ $startup->name }}</h2>
                    @if($startup->tagline)
                        <p class="text-gray-600 text-center italic">"{{ $startup->tagline }}"</p>
                    @endif
                    <p class="text-gray-500 text-center mt-1">{{ $startup->sector }}</p>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="bi bi-person-fill text-gray-500 mr-3 w-5"></i>
                        <div>
                            <p class="text-sm text-gray-500">Founder</p>
                            <p class="font-medium">{{ $startup->founder->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <i class="bi bi-envelope-fill text-gray-500 mr-3 w-5"></i>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium">{{ $startup->founder->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <i class="bi bi-globe text-gray-500 mr-3 w-5"></i>
                        <div>
                            <p class="text-sm text-gray-500">Website</p>
                            <p class="font-medium">
                                @if($startup->website)
                                    <a href="{{ $startup->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $startup->website }}</a>
                                @else
                                    Not provided
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <i class="bi bi-calendar-date text-gray-500 mr-3 w-5"></i>
                        <div>
                            <p class="text-sm text-gray-500">Founded</p>
                            <p class="font-medium">{{ $startup->year_founded ?? 'Not provided' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <i class="bi bi-people-fill text-gray-500 mr-3 w-5"></i>
                        <div>
                            <p class="text-sm text-gray-500">Team Size</p>
                            <p class="font-medium">{{ $startup->team_size ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 space-y-6">
                <!-- Status Section -->                
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="bi bi-info-circle text-[#b81d8f] mr-2"></i> Profile Status
                    </h3>
                    <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                        <div>
                            <h4 class="font-medium">Current Status</h4>
                            <p class="text-sm text-gray-500">Your profile visibility to investors</p>
                        </div>
                        <div class="text-sm">
                            @if($startup->status == 'active')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="bi bi-check-circle-fill mr-1"></i> Approved & Visible
                                </span>
                            @elseif($startup->status == 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="bi bi-clock-fill mr-1"></i> Pending Approval
                                </span>
                            @elseif($startup->status == 'rejected')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="bi bi-x-circle-fill mr-1"></i> Rejected
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Basic Information Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="bi bi-building text-[#b81d8f] mr-2"></i> Basic Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Startup Name</p>
                            <p class="font-medium">{{ $startup->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tagline</p>
                            <p class="font-medium">{{ $startup->tagline ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Website</p>
                            <p class="font-medium">
                                @if($startup->website)
                                    <a href="{{ $startup->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $startup->website }}</a>
                                @else
                                    Not provided
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Founded</p>
                            <p class="font-medium">{{ $startup->year_founded ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Funding Stage</p>
                            <p class="font-medium">{{ $startup->funding_stage }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Business Description</p>
                        @if($startup->description)
                            <p class="text-gray-700">{{ $startup->description }}</p>
                        @else
                            <p class="text-gray-500 italic">No description provided</p>
                        @endif
                    </div>
                </div>
                
                <!-- Industry & Category Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="bi bi-briefcase text-[#b81d8f] mr-2"></i> Industry & Category
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Industry Sector</p>
                            <p class="font-medium">{{ $startup->sector }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Business Model</p>
                            <p class="font-medium">{{ $startup->business_model ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Location Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="bi bi-geo-alt text-[#b81d8f] mr-2"></i> Location
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Headquarters</p>
                            <p class="font-medium">{{ $startup->headquarters_location ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Operating Regions</p>
                            <p class="font-medium">{{ $startup->operating_regions ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Team Information Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="bi bi-people text-[#b81d8f] mr-2"></i> Team Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Founder</p>
                            <p class="font-medium">{{ $startup->founder->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Team Size</p>
                            <p class="font-medium">{{ $startup->team_size ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">LinkedIn</p>
                            <p class="font-medium">
                                @if($startup->linkedin_url)
                                    <a href="{{ $startup->linkedin_url }}" target="_blank" class="text-blue-600 hover:underline">{{ $startup->linkedin_url }}</a>
                                @else
                                    Not provided
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Problem & Solution Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="bi bi-lightbulb text-[#b81d8f] mr-2"></i> Problem & Solution
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Problem Statement</p>
                            <p class="text-gray-700">{{ $startup->problem_statement ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Solution</p>
                            <p class="text-gray-700">{{ $startup->solution ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Innovation/Differentiator</p>
                            <p class="text-gray-700">{{ $startup->innovation_differentiator ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Market & Traction Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="bi bi-graph-up text-[#b81d8f] mr-2"></i> Market & Traction
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Target Market Size</p>
                            <p class="font-medium">{{ $startup->target_market_size ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Current Customers</p>
                            <p class="font-medium">{{ $startup->current_customers ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Monthly Revenue</p>
                            <p class="font-medium">{{ $startup->monthly_revenue ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Key Metrics</p>
                            <p class="font-medium">{{ $startup->key_metrics ?? 'Not provided' }}</p>
                        </div>
                    </div>
                    <div class="space-y-3 mt-2">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Partnerships</p>
                            <p class="text-gray-700">{{ $startup->partnerships ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Achievements</p>
                            <p class="text-gray-700">{{ $startup->achievements ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Technology & Operations Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="bi bi-gear text-[#b81d8f] mr-2"></i> Technology & Operations
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Technology Stack</p>
                            <p class="text-gray-700">{{ $startup->technology_stack ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Operational Model</p>
                            <p class="text-gray-700">{{ $startup->operational_model ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">IP/Patents</p>
                            <p class="text-gray-700">{{ $startup->ip_patents ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Funding & Financials Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="bi bi-cash-coin text-[#b81d8f] mr-2"></i> Funding & Financials
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Raised Funds</p>
                            <p class="font-medium">{{ $startup->has_raised_funds ? 'Yes' : 'No' }}</p>
                        </div>
                        @if($startup->has_raised_funds)
                        <div>
                            <p class="text-sm text-gray-500">Amount Raised</p>
                            <p class="font-medium">{{ $startup->amount_raised ?? 'Not provided' }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-500">Monthly Burn Rate</p>
                            <p class="font-medium">{{ $startup->monthly_burn_rate ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Funding Needed</p>
                            <p class="font-medium">{{ $startup->funding_needed ?? 'Not provided' }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Funding Use</p>
                        <p class="text-gray-700">{{ $startup->funding_use ?? 'Not provided' }}</p>
                    </div>
                </div>
                
                <!-- Documents & Media Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="bi bi-file-earmark text-[#b81d8f] mr-2"></i> Documents & Media
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Pitch Deck</p>
                            <p class="font-medium">
                                @if($startup->pitch_deck)
                                    <a href="{{ asset('storage/' . $startup->pitch_deck) }}" target="_blank" class="text-blue-600 hover:underline flex items-center">
                                        <i class="bi bi-file-earmark-pdf mr-1"></i> View Pitch Deck
                                    </a>
                                @else
                                    Not provided
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Demo Video</p>
                            <p class="font-medium">
                                @if($startup->demo_video)
                                    <a href="{{ $startup->demo_video }}" target="_blank" class="text-blue-600 hover:underline flex items-center">
                                        <i class="bi bi-play-circle mr-1"></i> View Demo
                                    </a>
                                @else
                                    Not provided
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Company Registration</p>
                            <p class="font-medium">
                                @if($startup->company_registration)
                                    <a href="{{ asset('storage/' . $startup->company_registration) }}" target="_blank" class="text-blue-600 hover:underline flex items-center">
                                        <i class="bi bi-file-earmark mr-1"></i> View Document
                                    </a>
                                @else
                                    Not provided
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Goals & Needs Section -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="bi bi-flag text-[#b81d8f] mr-2"></i> Goals & Needs
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Current Challenges</p>
                            <p class="text-gray-700">{{ $startup->current_challenges ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Support Needed</p>
                            <p class="text-gray-700">{{ $startup->support_needed ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Future Vision (2-5 years)</p>
                            <p class="text-gray-700">{{ $startup->future_vision ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection