@extends('layouts.bdsp')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('bdsp.training-modules.show', $module) }}" class="text-[#b81d8f] hover:text-[#a01a7d] flex items-center">
                <i class="bi bi-arrow-left mr-2"></i>Back to Module
            </a>
            <div class="mt-4">
                <h1 class="text-3xl font-bold text-gray-900">{{ $module->title }} - Management</h1>
                <p class="text-gray-600 mt-2">Track and manage individual entrepreneur progress</p>
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

        <!-- Module Overview -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Module Overview</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-[#b81d8f]">{{ $stats['total'] }}</div>
                    <div class="text-sm text-gray-600">Total Enrolled</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</div>
                    <div class="text-sm text-gray-600">Completed</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['in_progress'] }}</div>
                    <div class="text-sm text-gray-600">In Progress</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-600">{{ $stats['not_started'] }}</div>
                    <div class="text-sm text-gray-600">Not Started</div>
                </div>
            </div>

            <div class="mt-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Overall Completion Rate</span>
                    <span class="text-sm font-medium text-gray-900">{{ $stats['completion_rate'] }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-[#b81d8f] h-2 rounded-full" style="width: {{ $stats['completion_rate'] }}%"></div>
                </div>
            </div>
        </div>

        <!-- Entrepreneur Progress Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Entrepreneur Progress</h2>
                <p class="text-gray-600 text-sm mt-1">Manage individual progress for each entrepreneur</p>
            </div>

            @if(empty($entrepreneurProgress))
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i class="bi bi-people text-6xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No Entrepreneurs Enrolled</h3>
                    <p class="text-gray-500">Entrepreneurs will appear here once they start this module.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Entrepreneur
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Current Week
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Progress
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Last Activity
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($entrepreneurProgress as $progress)
                                @php
                                    $entrepreneur = $progress['entrepreneur'];
                                    $completion = $progress['completion'];
                                    $lastActivity = $progress['lastActivity'];
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-[#b81d8f] flex items-center justify-center text-white font-semibold">
                                                    {{ substr($entrepreneur->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $entrepreneur->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $entrepreneur->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($completion->status === 'completed')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Completed
                                            </span>
                                        @elseif($completion->status === 'in_progress')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                In Progress
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Not Started
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Week {{ $completion->current_week }} of {{ $module->duration_weeks }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-3">
                                                <div class="bg-[#b81d8f] h-2 rounded-full" style="width: {{ $completion->progress_percentage }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-900">{{ $completion->progress_percentage }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $lastActivity ? $lastActivity->diffForHumans() : 'Never' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @if($completion->status === 'completed')
                                                <button type="button" 
                                                        onclick="reopenModule({{ $module->id }}, {{ $entrepreneur->id }})"
                                                        class="text-blue-600 hover:text-blue-900 font-medium">
                                                    Reopen
                                                </button>
                                            @else
                                                <button type="button" 
                                                        onclick="markCompleted({{ $module->id }}, {{ $entrepreneur->id }})"
                                                        class="text-green-600 hover:text-green-900 font-medium">
                                                    Mark Complete
                                                </button>
                                            @endif
                                            
                                            <button type="button" 
                                                    onclick="viewProgress({{ $module->id }}, {{ $entrepreneur->id }})"
                                                    class="text-[#b81d8f] hover:text-[#a01a7d] font-medium">
                                                View Details
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Progress Update Modal -->
<div id="progressModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Progress</h3>
            <form id="progressForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Week</label>
                    <input type="number" id="currentWeek" name="current_week" min="1" max="{{ $module->duration_weeks }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Progress Percentage</label>
                    <input type="number" id="progressPercentage" name="progress_percentage" min="0" max="100" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                    <textarea id="progressNotes" name="notes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeProgressModal()" 
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#b81d8f] text-white rounded-lg hover:bg-[#a01a7d]">
                        Update Progress
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentEntrepreneurId = null;
let currentModuleId = null;

function markCompleted(moduleId, entrepreneurId) {
    if (confirm('Mark this module as completed for this entrepreneur?')) {
        fetch(`/bdsp/training-modules/${moduleId}/entrepreneurs/${entrepreneurId}/complete`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                notes: prompt('Add completion notes (optional):')
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating completion status');
        });
    }
}

function reopenModule(moduleId, entrepreneurId) {
    if (confirm('Reopen this module for this entrepreneur?')) {
        fetch(`/bdsp/training-modules/${moduleId}/entrepreneurs/${entrepreneurId}/reopen`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error reopening module');
        });
    }
}

function viewProgress(moduleId, entrepreneurId) {
    currentModuleId = moduleId;
    currentEntrepreneurId = entrepreneurId;
    
    fetch(`/bdsp/training-modules/${moduleId}/entrepreneurs/${entrepreneurId}/progress`)
        .then(response => response.json())
        .then(data => {
            if (data.completion) {
                document.getElementById('currentWeek').value = data.completion.current_week;
                document.getElementById('progressPercentage').value = data.completion.progress_percentage;
                document.getElementById('progressNotes').value = data.completion.completion_notes || '';
                document.getElementById('progressModal').classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading progress details');
        });
}

function closeProgressModal() {
    document.getElementById('progressModal').classList.add('hidden');
}

document.getElementById('progressForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        current_week: document.getElementById('currentWeek').value,
        progress_percentage: document.getElementById('progressPercentage').value,
        notes: document.getElementById('progressNotes').value
    };
    
    fetch(`/bdsp/training-modules/${currentModuleId}/entrepreneurs/${currentEntrepreneurId}/progress`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeProgressModal();
            window.location.reload();
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating progress');
    });
});
</script>
@endsection
