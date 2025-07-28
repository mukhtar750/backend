@extends('layouts.investor')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $proposal->title }}</h1>
                <p class="text-gray-600 mt-2">Proposal Details</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('investor.proposals.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Proposals
                </a>
                @if($proposal->canBeReviewed())
                    <a href="{{ route('investor.proposals.edit', $proposal) }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Edit Proposal
                    </a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Status Badge -->
        <div class="mb-6">
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $proposal->getStatusBadgeClass() }}">
                {{ ucfirst(str_replace('_', ' ', $proposal->status)) }}
            </span>
            <span class="text-sm text-gray-500 ml-2">
                Submitted {{ $proposal->created_at->diffForHumans() }}
            </span>
        </div>

        <!-- Proposal Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Basic Information -->
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Basic Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Event Title</label>
                            <p class="text-gray-900 font-medium">{{ $proposal->title }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <p class="text-gray-900">{{ $proposal->description }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Event Type</label>
                            <p class="text-gray-900">{{ $proposal->getEventTypeLabel() }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Target Sector</label>
                            <p class="text-gray-900">{{ $proposal->target_sector ?: 'Any' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Target Stage</label>
                            <p class="text-gray-900">{{ $proposal->target_stage ? $proposal->getTargetStageLabel() : 'Any' }}</p>
                        </div>

                        @if($proposal->target_criteria)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Target Criteria</label>
                                <p class="text-gray-900">{{ $proposal->target_criteria }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Event Logistics -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Event Logistics</h3>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Proposed Date</label>
                                <p class="text-gray-900">{{ $proposal->getFormattedProposedDateTime() }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Duration</label>
                                <p class="text-gray-900">{{ $proposal->getFormattedDuration() }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Location</label>
                            <p class="text-gray-900">{{ $proposal->proposed_location ?: 'TBD' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Event Format</label>
                            <p class="text-gray-900">{{ $proposal->is_virtual ? 'Virtual' : 'In-Person' }}</p>
                        </div>

                        @if($proposal->is_virtual && $proposal->virtual_platform)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Virtual Platform</label>
                                <p class="text-gray-900">{{ $proposal->virtual_platform }}</p>
                            </div>
                        @endif

                        @if($proposal->max_participants)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Max Participants</label>
                                <p class="text-gray-900">{{ $proposal->max_participants }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Financial & Outcomes -->
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Financial Details</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Funding Range</label>
                            <p class="text-gray-900 font-medium">{{ $proposal->getFundingRange() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Expected Outcomes</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Expected Outcomes</label>
                            <p class="text-gray-900">{{ $proposal->expected_outcomes }}</p>
                        </div>

                        @if($proposal->success_metrics)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Success Metrics</label>
                                <p class="text-gray-900">{{ $proposal->success_metrics }}</p>
                            </div>
                        @endif

                        @if($proposal->proposed_format)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Proposed Format</label>
                                <p class="text-gray-900">{{ $proposal->proposed_format }}</p>
                            </div>
                        @endif

                        @if($proposal->supporting_rationale)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Supporting Rationale</label>
                                <p class="text-gray-900">{{ $proposal->supporting_rationale }}</p>
                            </div>
                        @endif

                        @if($proposal->additional_requirements)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Additional Requirements</label>
                                <p class="text-gray-900">{{ $proposal->additional_requirements }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Feedback Section -->
        @if($proposal->admin_feedback)
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Admin Feedback</h3>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-900">{{ $proposal->admin_feedback }}</p>
                </div>
                
                @if($proposal->reviewed_at)
                    <p class="text-sm text-gray-500 mt-2">
                        Reviewed {{ $proposal->reviewed_at->diffForHumans() }}
                        @if($proposal->reviewer)
                            by {{ $proposal->reviewer->name }}
                        @endif
                    </p>
                @endif
            </div>
        @endif

        <!-- Approved Event Link -->
        @if($proposal->isApproved() && $proposal->approvedEvent)
            <div class="mt-8 bg-green-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-green-900 mb-4">✅ Proposal Approved!</h3>
                <p class="text-green-700 mb-4">Your proposal has been approved and the event has been created.</p>
                <a href="{{ route('pitch-events.show', $proposal->approvedEvent) }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    View Created Event
                </a>
            </div>
        @endif

        <!-- Actions -->
        @if($proposal->isPending())
            <div class="mt-8 bg-yellow-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-yellow-900 mb-4">⏳ Under Review</h3>
                <p class="text-yellow-700">Your proposal is currently being reviewed by our admin team. You'll be notified once a decision is made.</p>
            </div>
        @endif

        @if($proposal->isRequestedChanges())
            <div class="mt-8 bg-blue-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-4">📝 Changes Requested</h3>
                <p class="text-blue-700 mb-4">The admin team has requested changes to your proposal. Please review the feedback above and update your proposal accordingly.</p>
                <a href="{{ route('investor.proposals.edit', $proposal) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    Update Proposal
                </a>
            </div>
        @endif

        @if($proposal->isRejected())
            <div class="mt-8 bg-red-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-red-900 mb-4">❌ Proposal Rejected</h3>
                <p class="text-red-700">Unfortunately, your proposal was not approved. Please review the feedback above and consider submitting a new proposal.</p>
            </div>
        @endif
    </div>
</div>
@endsection 