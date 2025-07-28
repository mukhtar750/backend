@extends('layouts.investor')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Pitch Event Proposals</h1>
            <p class="text-gray-600 mt-2">Manage and track your pitch event proposals</p>
        </div>
        <a href="{{ route('investor.proposals.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200">
            <i class="fas fa-plus mr-2"></i>New Proposal
        </a>
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
                                        <a href="{{ route('investor.proposals.show', $proposal) }}" 
                                           class="text-blue-600 hover:text-blue-900">
                                            View
                                        </a>
                                        
                                        @if($proposal->canBeReviewed())
                                            <a href="{{ route('investor.proposals.edit', $proposal) }}" 
                                               class="text-green-600 hover:text-green-900">
                                                Edit
                                            </a>
                                        @endif
                                        
                                        @if($proposal->isPending())
                                            <form action="{{ route('investor.proposals.destroy', $proposal) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this proposal?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Delete
                                                </button>
                                            </form>
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
                <i class="fas fa-lightbulb text-4xl"></i>
            </div>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No proposals yet</h3>
            <p class="mt-1 text-sm text-gray-500">
                Get started by creating your first pitch event proposal.
            </p>
            <div class="mt-6">
                <a href="{{ route('investor.proposals.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>
                    Create Your First Proposal
                </a>
            </div>
        </div>
    @endif

    <!-- Proposal Statistics -->
    @if($proposals->count() > 0)
        <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Pending</div>
                        <div class="text-2xl font-semibold text-gray-900">
                            {{ $proposals->where('status', 'pending')->count() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Approved</div>
                        <div class="text-2xl font-semibold text-gray-900">
                            {{ $proposals->where('status', 'approved')->count() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-edit text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Changes Requested</div>
                        <div class="text-2xl font-semibold text-gray-900">
                            {{ $proposals->where('status', 'requested_changes')->count() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-times text-red-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">Rejected</div>
                        <div class="text-2xl font-semibold text-gray-900">
                            {{ $proposals->where('status', 'rejected')->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection 