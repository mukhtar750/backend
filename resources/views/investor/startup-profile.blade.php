@extends('layouts.investor')

@section('title', ($startup->anonymous_teaser ? 'Anonymous Startup' : $startup->name) . ' - Startup Profile')

@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <a href="{{ route('dashboard.investor') }}" class="text-purple-600 hover:underline mb-4 inline-block"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
    
    <!-- Startup Header -->
    <div class="bg-white rounded-xl border border-gray-200 p-8 mb-8 shadow-sm">
        <div class="flex items-start gap-6">
            @if($startup->anonymous_teaser)
                <div class="w-24 h-24 rounded-xl bg-gray-300 flex items-center justify-center">
                    <i class="bi bi-building text-4xl text-gray-600"></i>
                </div>
            @elseif($startup->logo)
                <img src="{{ asset('storage/' . $startup->logo) }}" alt="{{ $startup->name }}" class="w-24 h-24 rounded-xl object-cover">
            @else
                <div class="w-24 h-24 rounded-xl bg-gray-300 flex items-center justify-center">
                    <i class="bi bi-building text-4xl text-gray-600"></i>
                </div>
            @endif
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    @if($startup->anonymous_teaser)
                        Anonymous Startup
                    @else
                        {{ $startup->name }}
                    @endif
                </h1>
                <p class="text-lg text-gray-600 mb-4">
                    {{ $startup->tagline ?? 'No tagline available' }}
                </p>
                <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                    <div><i class="bi bi-geo-alt"></i> {{ $startup->headquarters_location ?? 'Location not specified' }}</div>
                    <div><i class="bi bi-calendar"></i> Founded {{ $startup->year_founded ?? 'N/A' }}</div>
                    <div><i class="bi bi-people"></i> {{ $startup->team_size ?? 'N/A' }} team members</div>
                    <div><i class="bi bi-globe"></i> <a href="{{ $startup->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $startup->website ?? 'No website' }}</a></div>
                </div>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                    <i class="bi bi-check-circle mr-1"></i> Approved
                </span>
            </div>
        </div>
    </div>

    <!-- Founder Information -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8 shadow-sm">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Founder</h2>
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">
                <i class="bi bi-person text-2xl text-gray-600"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ $startup->founder->name ?? 'Unknown' }}</h3>
                <p class="text-gray-600">{{ $startup->founder->email ?? 'No email available' }}</p>
                @if($startup->linkedin_url)
                    <a href="{{ $startup->linkedin_url }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                        <i class="bi bi-linkedin"></i> LinkedIn Profile
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Business Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Company Information -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Company Information</h2>
            <div class="space-y-3">
                <div>
                    <span class="text-sm font-medium text-gray-500">Sector</span>
                    <p class="text-gray-900">{{ $startup->sector ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Funding Stage</span>
                    <p class="text-gray-900">{{ $startup->funding_stage ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Operating Regions</span>
                    <p class="text-gray-900">{{ $startup->operating_regions ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Technology Stack</span>
                    <p class="text-gray-900">{{ $startup->technology_stack ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">IP/Patents</span>
                    <p class="text-gray-900">{{ $startup->ip_patents ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Financial Information -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Financial Information</h2>
            <div class="space-y-3">
                <div>
                    <span class="text-sm font-medium text-gray-500">Monthly Revenue</span>
                    <p class="text-gray-900">{{ $startup->monthly_revenue ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Amount Raised</span>
                    <p class="text-gray-900">{{ $startup->amount_raised ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Monthly Burn Rate</span>
                    <p class="text-gray-900">{{ $startup->monthly_burn_rate ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Funding Needed</span>
                    <p class="text-gray-900 font-semibold text-green-600">{{ $startup->funding_needed ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Funding Use</span>
                    <p class="text-gray-900">{{ $startup->funding_use ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Business Model & Market -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Business Model -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Business Model</h2>
            <div class="space-y-3">
                <div>
                    <span class="text-sm font-medium text-gray-500">Problem Statement</span>
                    <p class="text-gray-900">{{ $startup->problem_statement ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Solution</span>
                    <p class="text-gray-900">{{ $startup->solution ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Innovation Differentiator</span>
                    <p class="text-gray-900">{{ $startup->innovation_differentiator ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Operational Model</span>
                    <p class="text-gray-900">{{ $startup->operational_model ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Market & Traction -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Market & Traction</h2>
            <div class="space-y-3">
                <div>
                    <span class="text-sm font-medium text-gray-500">Target Market Size</span>
                    <p class="text-gray-900">{{ $startup->target_market_size ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Current Customers</span>
                    <p class="text-gray-900">{{ $startup->current_customers ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Key Metrics</span>
                    <p class="text-gray-900">{{ $startup->key_metrics ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Partnerships</span>
                    <p class="text-gray-900">{{ $startup->partnerships ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Achievements</span>
                    <p class="text-gray-900">{{ $startup->achievements ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Additional Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <span class="text-sm font-medium text-gray-500">Current Challenges</span>
                <p class="text-gray-900">{{ $startup->current_challenges ?? 'N/A' }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500">Support Needed</span>
                <p class="text-gray-900">{{ $startup->support_needed ?? 'N/A' }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500">Future Vision</span>
                <p class="text-gray-900">{{ $startup->future_vision ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Contact Information</h2>
        <div class="flex flex-wrap gap-4">
            @if($startup->website)
                <a href="{{ $startup->website }}" target="_blank" class="inline-flex items-center gap-2 text-blue-600 hover:underline">
                    <i class="bi bi-globe"></i> Website
                </a>
            @endif
            @if($startup->linkedin_url)
                <a href="{{ $startup->linkedin_url }}" target="_blank" class="inline-flex items-center gap-2 text-blue-600 hover:underline">
                    <i class="bi bi-linkedin"></i> LinkedIn
                </a>
            @endif
            @if($startup->founder->email)
                <a href="mailto:{{ $startup->founder->email }}" class="inline-flex items-center gap-2 text-blue-600 hover:underline">
                    <i class="bi bi-envelope"></i> Email Founder
                </a>
            @endif
        </div>
    </div>
</div>
@endsection