@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Startup Profiles</h4>
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
                    
                    @if ($startups->isEmpty())
                        <div class="alert alert-info">
                            <p>There are no active startup profiles available at the moment.</p>
                        </div>
                    @else
                        <div class="row">
                            @foreach ($startups as $startup)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                @if ($startup->anonymous_teaser && $startup->logo)
                                                    <div class="mr-3 bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fas fa-building fa-2x text-secondary"></i>
                                                    </div>
                                                @elseif (!$startup->anonymous_teaser && $startup->logo)
                                                    <img src="{{ asset('storage/' . $startup->logo) }}" alt="{{ $startup->name }} Logo" class="mr-3" style="width: 60px; height: 60px; object-fit: contain;">
                                                @else
                                                    <div class="mr-3 bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fas fa-building fa-2x text-secondary"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h5 class="card-title mb-0">
                                                        @if ($startup->anonymous_teaser)
                                                            Anonymous Startup
                                                        @else
                                                            {{ $startup->name }}
                                                        @endif
                                                    </h5>
                                                    @if ($startup->tagline)
                                                        <p class="text-muted mb-0">{{ $startup->tagline }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            
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
                            
                            @if ($startup->description)
                                <p class="card-text mb-3">{{ Str::limit($startup->description, 150) }}</p>
                            @endif
                                            
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <a href="{{ route('investor.view_startup', $startup->id) }}" class="btn btn-primary">View Profile</a>
                                                
                                                @if (isset($accessRequests[$startup->id]))
                                                    @if ($accessRequests[$startup->id]->status === 'pending')
                                                        <span class="badge badge-warning p-2">Access Request Pending</span>
                                                    @elseif ($accessRequests[$startup->id]->status === 'approved')
                                                        <span class="badge badge-success p-2">Full Access Granted</span>
                                                    @elseif ($accessRequests[$startup->id]->status === 'rejected')
                                                        <span class="badge badge-danger p-2">Access Request Declined</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection