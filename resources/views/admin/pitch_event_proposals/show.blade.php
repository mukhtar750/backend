@extends('admin.layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $proposal->title }}</h1>
                <p class="text-gray-600 mt-2">Review Pitch Event Proposal</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.proposals.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Proposals
                </a>
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

        <!-- Status and Actions -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $proposal->getStatusBadgeClass() }}">
                        {{ ucfirst(str_replace('_', ' ', $proposal->status)) }}
                    </span>
                    <span class="text-sm text-gray-500">
                        Submitted {{ $proposal->created_at->diffForHumans() }}
                    </span>
                </div>
                
                @if($proposal->canBeReviewed())
                    <div class="flex space-x-3">
                        <button onclick="approveProposal({{ $proposal->id }})" 
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200">
                            <i class="fas fa-check mr-2"></i>Approve
                        </button>
                        <button onclick="rejectProposal({{ $proposal->id }})" 
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200">
                            <i class="fas fa-times mr-2"></i>Reject
                        </button>
                        <button onclick="requestChanges({{ $proposal->id }})" 
                                class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition duration-200">
                            <i class="fas fa-edit mr-2"></i>Request Changes
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Proposal Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Proposal Details</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Event Title</label>
                            <p class="text-gray-900 font-medium">{{ $proposal->title }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <p class="text-gray-900">{{ $proposal->description }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Event Type</label>
                                <p class="text-gray-900">{{ $proposal->getEventTypeLabel() }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Target Sector</label>
                                <p class="text-gray-900">{{ $proposal->target_sector ?: 'Any' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Target Stage</label>
                                <p class="text-gray-900">{{ $proposal->target_stage ? $proposal->getTargetStageLabel() : 'Any' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Max Participants</label>
                                <p class="text-gray-900">{{ $proposal->max_participants ?: 'Unlimited' }}</p>
                            </div>
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
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Proposed Date & Time</label>
                                <p class="text-gray-900">{{ $proposal->getFormattedProposedDateTime() }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Duration</label>
                                <p class="text-gray-900">{{ $proposal->getFormattedDuration() }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Location</label>
                                <p class="text-gray-900">{{ $proposal->proposed_location ?: 'TBD' }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
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
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Funding Range</label>
                                <p class="text-gray-900 font-medium">{{ $proposal->getFundingRange() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expected Outcomes -->
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

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Investor Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Investor Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <p class="text-gray-900 font-medium">{{ $proposal->investor->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="text-gray-900">{{ $proposal->investor->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company</label>
                            <p class="text-gray-900">{{ $proposal->investor->company ?: 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Investor Type</label>
                            <p class="text-gray-900">{{ $proposal->investor->type_of_investor ?: 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Review History -->
                @if($proposal->reviewed_at)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Review History</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Reviewed By</label>
                                <p class="text-gray-900">{{ $proposal->reviewer ? $proposal->reviewer->name : 'Unknown' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Reviewed At</label>
                                <p class="text-gray-900">{{ $proposal->reviewed_at->format('M d, Y g:i A') }}</p>
                            </div>
                            @if($proposal->admin_feedback)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Admin Feedback</label>
                                    <p class="text-gray-900">{{ $proposal->admin_feedback }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Approved Event Link -->
                @if($proposal->isApproved() && $proposal->approvedEvent)
                    <div class="bg-green-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-green-900 mb-4">✅ Event Created</h3>
                        <p class="text-green-700 mb-4">This proposal was approved and an event was created.</p>
                        <a href="{{ route('pitch-events.show', $proposal->approvedEvent) }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            View Event
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Approval Modal -->
<div id="approvalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Approve Proposal</h3>
            <form id="approvalForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="admin_feedback" class="block text-sm font-medium text-gray-700 mb-2">Admin Feedback (Optional)</label>
                    <textarea name="admin_feedback" id="admin_feedback" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Any additional feedback for the investor..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Approve & Create Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div id="rejectionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Proposal</h3>
            <form id="rejectionForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="rejection_feedback" class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason *</label>
                    <textarea name="admin_feedback" id="rejection_feedback" rows="3" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Please provide a reason for rejection..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Reject Proposal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Changes Requested Modal -->
<div id="changesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Request Changes</h3>
            <form id="changesForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="changes_feedback" class="block text-sm font-medium text-gray-700 mb-2">Changes Required *</label>
                    <textarea name="admin_feedback" id="changes_feedback" rows="3" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Please specify what changes are needed..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                        Request Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function approveProposal(proposalId) {
    document.getElementById('approvalForm').action = `/admin/pitch-events/proposals/${proposalId}/approve`;
    document.getElementById('approvalModal').classList.remove('hidden');
}

function rejectProposal(proposalId) {
    document.getElementById('rejectionForm').action = `/admin/pitch-events/proposals/${proposalId}/reject`;
    document.getElementById('rejectionModal').classList.remove('hidden');
}

function requestChanges(proposalId) {
    document.getElementById('changesForm').action = `/admin/pitch-events/proposals/${proposalId}/request-changes`;
    document.getElementById('changesModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('approvalModal').classList.add('hidden');
    document.getElementById('rejectionModal').classList.add('hidden');
    document.getElementById('changesModal').classList.add('hidden');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modals = ['approvalModal', 'rejectionModal', 'changesModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
}
</script>
@endsection 