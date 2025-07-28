@extends('admin.layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Pitch Event Proposals</h1>
            <p class="text-gray-600 mt-2">Review and manage investor pitch event proposals</p>
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

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="bi bi-clock text-yellow-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500">Pending Review</div>
                    <div class="text-2xl font-semibold text-gray-900">{{ $counts['pending'] }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="bi bi-check-circle text-green-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500">Approved</div>
                    <div class="text-2xl font-semibold text-gray-900">{{ $counts['approved'] }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="bi bi-pencil-square text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500">Changes Requested</div>
                    <div class="text-2xl font-semibold text-gray-900">{{ $counts['requested_changes'] }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="bi bi-x-circle text-red-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500">Rejected</div>
                    <div class="text-2xl font-semibold text-gray-900">{{ $counts['rejected'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="requested_changes" {{ request('status') == 'requested_changes' ? 'selected' : '' }}>Changes Requested</option>
                </select>
            </div>

            <div>
                <label for="event_type" class="block text-sm font-medium text-gray-700 mb-2">Event Type</label>
                <select name="event_type" id="event_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">All Types</option>
                    <option value="pitch_competition" {{ request('event_type') == 'pitch_competition' ? 'selected' : '' }}>Pitch Competition</option>
                    <option value="networking" {{ request('event_type') == 'networking' ? 'selected' : '' }}>Networking Event</option>
                    <option value="demo_day" {{ request('event_type') == 'demo_day' ? 'selected' : '' }}>Demo Day</option>
                    <option value="workshop" {{ request('event_type') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                </select>
            </div>

            <div>
                <label for="target_sector" class="block text-sm font-medium text-gray-700 mb-2">Target Sector</label>
                <input type="text" name="target_sector" id="target_sector" value="{{ request('target_sector') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                       placeholder="e.g., FinTech">
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition duration-200">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Proposals Table -->
    @if($proposals->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Proposal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Investor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Event Type
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Target Sector
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Submitted
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($proposals as $proposal)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $proposal->title }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ Str::limit($proposal->description, 60) }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $proposal->investor->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $proposal->investor->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">
                                        {{ $proposal->getEventTypeLabel() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">
                                        {{ $proposal->target_sector ?: 'Any' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $proposal->getStatusBadgeClass() }}">
                                        {{ ucfirst(str_replace('_', ' ', $proposal->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $proposal->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.proposals.show', $proposal) }}" 
                                           class="text-purple-600 hover:text-purple-900">
                                            Review
                                        </a>
                                        
                                        @if($proposal->isPending())
                                            <button onclick="approveProposal({{ $proposal->id }})" 
                                                    class="text-green-600 hover:text-green-900">
                                                Approve
                                            </button>
                                            <button onclick="rejectProposal({{ $proposal->id }})" 
                                                    class="text-red-600 hover:text-red-900">
                                                Reject
                                            </button>
                                            <button onclick="requestChanges({{ $proposal->id }})" 
                                                    class="text-yellow-600 hover:text-yellow-900">
                                                Request Changes
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $proposals->links() }}
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <div class="mx-auto h-12 w-12 text-gray-400">
                <i class="fas fa-inbox text-4xl"></i>
            </div>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No proposals found</h3>
            <p class="mt-1 text-sm text-gray-500">
                No proposals match your current filters.
            </p>
        </div>
    @endif
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
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
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
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
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
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
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