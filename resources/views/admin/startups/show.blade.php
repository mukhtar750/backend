@extends('admin.layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-8 mt-8">
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('admin.user-management', ['tab' => 'startup-profiles']) }}" class="text-purple-600 hover:underline inline-block"><i class="bi bi-arrow-left"></i> Back to Startup Profiles</a>
        <form action="{{ route('admin.startups.destroy', $startup->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this startup profile?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Delete Startup
            </button>
        </form>
    </div>
    <h1 class="text-2xl font-bold mb-2">{{ $startup->name }}</h1>
    <div class="mb-4 flex items-center gap-4">
        @if($startup->logo)
            <img src="{{ asset('storage/' . $startup->logo) }}" alt="Logo" class="h-16 w-16 rounded-full">
        @else
            <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                <i class="bi bi-building text-3xl text-gray-600"></i>
            </div>
        @endif
        <div>
            <div class="text-lg font-semibold">{{ $startup->tagline ?? 'No tagline' }}</div>
            <div class="text-sm text-gray-500">{{ $startup->website ?? 'No website' }}</div>
        </div>
        <span class="ml-auto px-3 py-1 rounded-full text-xs font-semibold
            @if($startup->status === 'approved') bg-green-100 text-green-800
            @elseif($startup->status === 'pending') bg-yellow-100 text-yellow-800
            @elseif($startup->status === 'rejected') bg-red-100 text-red-800
            @else bg-gray-100 text-gray-800 @endif">
            {{ ucfirst($startup->status) }}
        </span>
    </div>
    
    <!-- Admin Controls -->
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Admin Controls</h3>
        
        <!-- Anonymous Teaser Toggle -->
        <div class="flex items-center justify-between mb-4">
            <div>
                <h4 class="font-medium text-gray-700">Anonymous Teaser Mode</h4>
                <p class="text-sm text-gray-600">
                    {{ $startup->anonymous_teaser 
                        ? 'Startup name is hidden from investors. They see "Anonymous Startup" instead.'
                        : 'Startup name is visible to investors in teaser view.' }}
                </p>
            </div>
            <form action="{{ route('admin.startups.toggle_anonymous_teaser', $startup->id) }}" method="POST" class="ml-4">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium transition-colors
                    {{ $startup->anonymous_teaser 
                        ? 'bg-yellow-600 text-white hover:bg-yellow-700' 
                        : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                    {{ $startup->anonymous_teaser ? 'Disable Anonymous Mode' : 'Enable Anonymous Mode' }}
                </button>
            </form>
        </div>
        
        <!-- Approval Controls -->
        @if($startup->status === 'pending')
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.startups.approve', $startup->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                    Approve Startup
                </button>
            </form>
            <form action="{{ route('admin.startups.reject', $startup->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors"
                        onclick="return confirm('Are you sure you want to reject this startup profile?')">
                    Reject Startup
                </button>
            </form>
        </div>
        @endif
    </div>
    <div class="mb-6">
        <h2 class="font-semibold text-gray-700 mb-1">Founder</h2>
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                <i class="bi bi-person text-gray-600"></i>
            </div>
            <div>
                <div class="font-semibold">{{ $startup->founder->name ?? 'Unknown' }}</div>
                <div class="text-sm text-gray-500">{{ $startup->founder->email ?? 'No email' }}</div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Business Details</h3>
            <div class="mb-1"><span class="font-medium">Sector:</span> {{ $startup->sector ?? 'N/A' }}</div>
            <div class="mb-1"><span class="font-medium">Funding Stage:</span> {{ $startup->funding_stage ?? 'N/A' }}</div>
            <div class="mb-1"><span class="font-medium">Year Founded:</span> {{ $startup->year_founded ?? 'N/A' }}</div>
            <div class="mb-1"><span class="font-medium">Team Size:</span> {{ $startup->team_size ?? 'N/A' }}</div>
            <div class="mb-1"><span class="font-medium">Headquarters:</span> {{ $startup->headquarters_location ?? 'N/A' }}</div>
            <div class="mb-1"><span class="font-medium">Operating Regions:</span> {{ $startup->operating_regions ?? 'N/A' }}</div>
            <div class="mb-1"><span class="font-medium">LinkedIn:</span> <a href="{{ $startup->linkedin_url }}" class="text-blue-600 hover:underline" target="_blank">{{ $startup->linkedin_url }}</a></div>
        </div>
        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Pitch & Metrics</h3>
            <div class="mb-1"><span class="font-medium">Problem Statement:</span> {{ $startup->problem_statement ?? 'N/A' }}</div>
            <div class="mb-1"><span class="font-medium">Solution:</span> {{ $startup->solution ?? 'N/A' }}</div>
            <div class="mb-1"><span class="font-medium">Innovation:</span> {{ $startup->innovation_differentiator ?? 'N/A' }}</div>
            <div class="mb-1"><span class="font-medium">Target Market Size:</span> {{ $startup->target_market_size ?? 'N/A' }}</div>
            <div class="mb-1"><span class="font-medium">Current Customers:</span> {{ $startup->current_customers ?? 'N/A' }}</div>
            <div class="mb-1"><span class="font-medium">Monthly Revenue:</span> {{ $startup->monthly_revenue ?? 'N/A' }}</div>
            <div class="mb-1"><span class="font-medium">Key Metrics:</span> {{ $startup->key_metrics ?? 'N/A' }}</div>
            <div class="mb-1"><span class="font-medium">Partnerships:</span> {{ $startup->partnerships ?? 'N/A' }}</div>
            <div class="mb-1"><span class="font-medium">Achievements:</span> {{ $startup->achievements ?? 'N/A' }}</div>
        </div>
    </div>
    <div class="mt-6">
        <h3 class="font-semibold text-gray-700 mb-2">Technology & Operations</h3>
        <div class="mb-1"><span class="font-medium">Technology Stack:</span> {{ $startup->technology_stack ?? 'N/A' }}</div>
        <div class="mb-1"><span class="font-medium">Operational Model:</span> {{ $startup->operational_model ?? 'N/A' }}</div>
        <div class="mb-1"><span class="font-medium">IP/Patents:</span> {{ $startup->ip_patents ?? 'N/A' }}</div>
        <div class="mb-1"><span class="font-medium">Amount Raised:</span> {{ $startup->amount_raised ?? 'N/A' }}</div>
        <div class="mb-1"><span class="font-medium">Monthly Burn Rate:</span> {{ $startup->monthly_burn_rate ?? 'N/A' }}</div>
        <div class="mb-1"><span class="font-medium">Funding Needed:</span> {{ $startup->funding_needed ?? 'N/A' }}</div>
        <div class="mb-1"><span class="font-medium">Funding Use:</span> {{ $startup->funding_use ?? 'N/A' }}</div>
    </div>
</div>
@endsection