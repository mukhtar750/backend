@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $startup->name }}</h4>
                    <a href="{{ route('investor.startup_profiles') }}" class="btn btn-sm btn-light">Back to Startups</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @if (session('info'))
                        <div class="alert alert-info" role="alert">
                            {{ session('info') }}
                        </div>
                    @endif
                    
                    @if (!$hasAccess)
                        <!-- Investor Teaser View -->
                        <div class="investor-teaser-view">
                            <div class="row mb-4">
                                <div class="col-md-3 text-center">
                                    @if ($startup->logo)
                                        <img src="{{ asset('storage/' . $startup->logo) }}" alt="{{ $startup->name }} Logo" class="img-fluid mb-3" style="max-height: 150px; max-width: 100%;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <i class="fas fa-building fa-4x text-secondary"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <h3 class="mb-1">{{ $startup->name }}</h3>
                                    @if ($startup->tagline)
                                        <p class="text-muted mb-3">{{ $startup->tagline }}</p>
                                    @endif
                                    
                                    <div class="mb-3">
                                        <span class="badge badge-primary">{{ $startup->sector }}</span>
                                        @if ($startup->business_model)
                                            <span class="badge badge-info">{{ $startup->business_model }}</span>
                                        @endif
                                        <span class="badge badge-secondary">{{ $startup->funding_stage }}</span>
                                    </div>
                                    
                                    @if ($startup->headquarters_location)
                                        <p class="mb-2"><i class="fas fa-map-marker-alt mr-2"></i>{{ $startup->headquarters_location }}</p>
                                    @endif
                                    
                                    @if ($startup->year_founded)
                                        <p class="mb-2"><i class="fas fa-calendar-alt mr-2"></i>Founded: {{ $startup->year_founded }}</p>
                                    @endif
                                    
                                    @if ($startup->website)
                                        <p class="mb-2">
                                            <i class="fas fa-globe mr-2"></i>
                                            <a href="{{ $startup->website }}" target="_blank" rel="noopener noreferrer">{{ $startup->website }}</a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">About the Startup</h5>
                                        </div>
                                        <div class="card-body">
                                            @if ($startup->description)
                                                <p>{{ $startup->description }}</p>
                                            @else
                                                <p class="text-muted">No description provided.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info">
                                <h5><i class="fas fa-lock mr-2"></i>Full Profile Access</h5>
                                <p>To view the complete startup profile with detailed information, please request access from the founder.</p>
                                <form action="{{ route('investor.request_access', $startup->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    <div class="form-group">
                                        <label for="message">Message to Founder (Optional)</label>
                                        <textarea name="message" id="message" class="form-control" rows="3" placeholder="Introduce yourself and explain why you're interested in this startup..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Request Full Access</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Full Profile View (when access is granted) -->
                        <div class="full-profile-view">
                            <div class="alert alert-success mb-4">
                                <i class="fas fa-check-circle mr-2"></i> You have been granted full access to this startup profile.
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-3 text-center">
                                    @if ($startup->logo)
                                        <img src="{{ asset('storage/' . $startup->logo) }}" alt="{{ $startup->name }} Logo" class="img-fluid mb-3" style="max-height: 150px; max-width: 100%;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <i class="fas fa-building fa-4x text-secondary"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <h3 class="mb-1">{{ $startup->name }}</h3>
                                    @if ($startup->tagline)
                                        <p class="text-muted mb-3">{{ $startup->tagline }}</p>
                                    @endif
                                    
                                    <div class="mb-3">
                                        <span class="badge badge-primary">{{ $startup->sector }}</span>
                                        @if ($startup->business_model)
                                            <span class="badge badge-info">{{ $startup->business_model }}</span>
                                        @endif
                                        <span class="badge badge-secondary">{{ $startup->funding_stage }}</span>
                                    </div>
                                    
                                    @if ($startup->headquarters_location)
                                        <p class="mb-2"><i class="fas fa-map-marker-alt mr-2"></i>{{ $startup->headquarters_location }}</p>
                                    @endif
                                    
                                    @if ($startup->year_founded)
                                        <p class="mb-2"><i class="fas fa-calendar-alt mr-2"></i>Founded: {{ $startup->year_founded }}</p>
                                    @endif
                                    
                                    @if ($startup->website)
                                        <p class="mb-2">
                                            <i class="fas fa-globe mr-2"></i>
                                            <a href="{{ $startup->website }}" target="_blank" rel="noopener noreferrer">{{ $startup->website }}</a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Basic Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <h6>Description</h6>
                                            <p>{{ $startup->description ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Industry & Category -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Industry & Category</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <h6>Industry Sector</h6>
                                            <p>{{ $startup->sector ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <h6>Target Market</h6>
                                            <p>{{ $startup->target_market ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <h6>Business Model</h6>
                                            <p>{{ $startup->business_model ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Location -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Location</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h6>Headquarters</h6>
                                            <p>{{ $startup->headquarters_location ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6>Operating Regions</h6>
                                            <p>{{ $startup->operating_regions ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Team Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Team Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h6>Founder</h6>
                                            <p>{{ $startup->founder->name ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6>Team Size</h6>
                                            <p>{{ $startup->team_size ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <h6>Key Team Members</h6>
                                            <p>{{ $startup->key_team_members ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Problem & Solution -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Problem & Solution</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h6>Problem Statement</h6>
                                            <p>{{ $startup->problem_statement ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6>Solution</h6>
                                            <p>{{ $startup->solution ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <h6>Innovation Factors</h6>
                                            <p>{{ $startup->innovation_factors ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Market & Traction -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Market & Traction</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h6>Target Market Size</h6>
                                            <p>{{ $startup->target_market_size ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6>Current Users/Customers</h6>
                                            <p>{{ $startup->current_customers ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6>Key Metrics</h6>
                                            <p>{{ $startup->key_metrics ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6>Partnerships</h6>
                                            <p>{{ $startup->partnerships ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <h6>Achievements/Awards</h6>
                                            <p>{{ $startup->achievements ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Technology & Operations -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Technology & Operations</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <h6>Technology Stack</h6>
                                            <p>{{ $startup->technology_stack ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <h6>Operational Model</h6>
                                            <p>{{ $startup->operational_model ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <h6>IP/Patents</h6>
                                            <p>{{ $startup->ip_patents ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Funding & Financials -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Funding & Financials</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <h6>Funding Stage</h6>
                                            <p>{{ $startup->funding_stage ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <h6>Amount Raised</h6>
                                            <p>{{ $startup->amount_raised ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <h6>Monthly Burn Rate</h6>
                                            <p>{{ $startup->monthly_burn_rate ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6>Funding Needed</h6>
                                            <p>{{ $startup->funding_needed ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6>Funding Use</h6>
                                            <p>{{ $startup->funding_use ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Documents & Media -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Documents & Media</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <h6>Pitch Deck</h6>
                                            @if ($startup->pitch_deck)
                                                <a href="{{ asset('storage/' . $startup->pitch_deck) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-pdf mr-1"></i> View Pitch Deck
                                                </a>
                                            @else
                                                <p class="text-muted">Not provided</p>
                                            @endif
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <h6>Demo Video</h6>
                                            @if ($startup->demo_video)
                                                <a href="{{ $startup->demo_video }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-video mr-1"></i> Watch Demo
                                                </a>
                                            @else
                                                <p class="text-muted">Not provided</p>
                                            @endif
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <h6>Company Registration</h6>
                                            @if ($startup->company_registration)
                                                <a href="{{ asset('storage/' . $startup->company_registration) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file mr-1"></i> View Document
                                                </a>
                                            @else
                                                <p class="text-muted">Not provided</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Goals & Needs -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Goals & Needs</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h6>Current Challenges</h6>
                                            <p>{{ $startup->current_challenges ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6>Support Needed</h6>
                                            <p>{{ $startup->support_needed ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <h6>Future Vision</h6>
                                            <p>{{ $startup->future_vision ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection