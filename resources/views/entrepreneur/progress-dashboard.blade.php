@extends('layouts.entrepreneur')

@section('title', 'My Learning Progress')

@section('content')
<div class="container mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Learning Progress</h1>
        <p class="text-gray-600 mt-2">Track your progress across all training modules</p>
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

        <!-- Progress Overview -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Overall Progress</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-[#b81d8f]">{{ $stats['total'] }}</div>
                    <div class="text-sm text-gray-600">Total Modules</div>
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
                    <span class="text-sm font-medium text-gray-900">{{ $stats['overall_progress'] }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-[#b81d8f] h-3 rounded-full transition-all duration-300" style="width: {{ $stats['overall_progress'] }}%"></div>
                </div>
            </div>
        </div>

        <!-- Module Progress Cards -->
        @if(empty($moduleProgress))
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="bi bi-book text-6xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Modules Enrolled Yet</h3>
                <p class="text-gray-500 mb-6">You haven't enrolled in any training modules yet.</p>
                <a href="{{ route('entrepreneur.training-modules.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-[#b81d8f] text-white rounded-lg hover:bg-[#a01a7d] transition">
                    <i class="bi bi-search mr-2"></i>Browse Available Modules
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($moduleProgress as $progress)
                    @php
                        $module = $progress['module'];
                        $completion = $progress['completion'];
                        $bdsp = $progress['bdsp'];
                        $status = $progress['status'];
                    @endphp
                    
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-shadow">
                        <!-- Module Header -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-lg font-semibold text-gray-900 line-clamp-2 flex-1 mr-3">{{ $module->title }}</h3>
                                <div class="flex-shrink-0">
                                    @if($status === 'completed')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    @elseif($status === 'in_progress')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            In Progress
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Not Started
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <p class="text-gray-600 text-sm line-clamp-2 mb-3">{{ $module->description }}</p>
                            
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="bi bi-person mr-1"></i>
                                <span>{{ $bdsp->name }}</span>
                            </div>
                        </div>

                        <!-- Progress Section -->
                        <div class="p-6">
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-gray-700">Progress</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $completion->progress_percentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-[#b81d8f] h-2 rounded-full transition-all duration-300" 
                                         style="width: {{ $completion->progress_percentage }}%"></div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                <div>
                                    <span class="text-gray-500">Current Week:</span>
                                    <span class="font-medium text-gray-900">Week {{ $completion->current_week }} of {{ $module->duration_weeks }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Duration:</span>
                                    <span class="font-medium text-gray-900">{{ $module->total_hours }}h</span>
                                </div>
                            </div>

                            @if($completion->completion_notes)
                                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Notes:</span> {{ $completion->completion_notes }}
                                    </p>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ route('entrepreneur.progress.show', $module) }}" 
                                   class="flex-1 bg-[#b81d8f] hover:bg-[#a01a7d] text-white py-2 px-4 rounded-lg text-sm font-medium text-center transition">
                                    View Progress
                                </a>
                                
                                @if($status === 'not_started')
                                    <button type="button" 
                                            onclick="startModule({{ $module->id }})"
                                            class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition">
                                        Start Module
                                    </button>
                                @elseif($status === 'in_progress')
                                    <button type="button" 
                                            onclick="updateProgress({{ $module->id }})"
                                            class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition">
                                        Update Progress
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
                            <div class="flex justify-between items-center text-xs text-gray-500">
                                @if($completion->started_at)
                                    <span>Started {{ $completion->started_at->diffForHumans() }}</span>
                                @else
                                    <span>Not started yet</span>
                                @endif
                                
                                @if($completion->completed_at)
                                    <span>Completed {{ $completion->completed_at->diffForHumans() }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Progress Update Modal -->
<div id="progressModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Your Progress</h3>
            <form id="progressForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Week</label>
                    <input type="number" id="currentWeek" name="current_week" min="1" max="12" 
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

<script>
let currentModuleId = null;

function startModule(moduleId) {
    console.log('startModule called with moduleId:', moduleId);
    
    if (confirm('Start this training module?')) {
        console.log('User confirmed, making fetch request...');
        
        fetch(`/entrepreneur/progress/${moduleId}/start`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        })
        .then(response => {
            console.log('Response received:', response);
            return response.json();
        })
        .then(data => {
            console.log('Data received:', data);
            if (data.success) {
                console.log('Module started successfully, reloading page...');
                window.location.reload();
            } else {
                console.error('Error starting module:', data.error);
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Error starting module');
        });
    } else {
        console.log('User cancelled starting module');
    }
}

function updateProgress(moduleId) {
    currentModuleId = moduleId;
    document.getElementById('progressModal').classList.remove('hidden');
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
    
    fetch(`/entrepreneur/progress/${currentModuleId}/update`, {
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
