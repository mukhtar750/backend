@extends('layouts.entrepreneur')

@section('title', $module->title)

@section('content')
<div class="container mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('entrepreneur.training-modules.index') }}" class="text-[#b81d8f] hover:text-[#a01a7d] flex items-center">
            <i class="bi bi-arrow-left mr-2"></i>Back to Modules
        </a>
        <div class="mt-4">
            <h1 class="text-3xl font-bold text-gray-900">{{ $module->title }}</h1>
            <p class="text-gray-600 mt-2">Created by {{ $module->bdsp->name }}</p>
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
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Description</h3>
                    <p class="text-gray-600">{{ $module->description }}</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Details</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Duration:</span>
                            <span class="font-medium">{{ $module->duration_weeks }} weeks</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Hours:</span>
                            <span class="font-medium">{{ $module->total_hours }} hours</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium">{{ ucfirst($module->status) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($module->target_audience)
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Target Audience</h3>
                <p class="text-gray-600">{{ $module->target_audience }}</p>
            </div>
            @endif

            @if($module->prerequisites)
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Prerequisites</h3>
                <p class="text-gray-600">{{ $module->prerequisites }}</p>
            </div>
            @endif

            @if($module->learning_objectives)
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Learning Objectives</h3>
                <div class="text-gray-600 whitespace-pre-line">{{ $module->learning_objectives }}</div>
            </div>
            @endif
        </div>

        <!-- Progress Section -->
        @if($progress && (is_object($progress) && !is_null($progress->progress_percentage)))
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Your Progress</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-[#b81d8f]">{{ $progress->progress_percentage }}%</div>
                    <div class="text-sm text-gray-600">Overall Progress</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">Week {{ $progress->current_week }}</div>
                    <div class="text-sm text-gray-600">Current Week</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ ucfirst($progress->status) }}</div>
                    <div class="text-sm text-gray-600">Status</div>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Progress Bar</span>
                    <span class="text-sm font-medium text-gray-900">{{ $progress->progress_percentage }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-[#b81d8f] h-3 rounded-full transition-all duration-300" style="width: {{ $progress->progress_percentage }}%"></div>
                </div>
            </div>

            @if($progress->completion_notes)
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-medium text-gray-900 mb-2">Notes from BDSP:</h4>
                <p class="text-gray-600">{{ $progress->completion_notes }}</p>
            </div>
            @endif
        </div>
        @endif

        <!-- Weekly Breakdown -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Weekly Breakdown</h2>
                <p class="text-gray-600 text-sm mt-1">{{ $module->weeks->count() }} weeks of structured learning</p>
            </div>

            <div class="divide-y divide-gray-200">
                @foreach($module->weeks as $week)
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Week {{ $week->week_number }}: {{ $week->title }}</h3>
                            
                            @if($week->topics)
                            <div class="mb-3">
                                <h4 class="text-sm font-medium text-gray-700 mb-1">Topics Covered:</h4>
                                <p class="text-gray-600 text-sm">{{ $week->topics }}</p>
                            </div>
                            @endif

                            @if($week->week_objectives)
                            <div class="mb-3">
                                <h4 class="text-sm font-medium text-gray-700 mb-1">Week Objectives:</h4>
                                <p class="text-gray-600 text-sm">{{ $week->week_objectives }}</p>
                            </div>
                            @endif

                            @if($week->learning_materials)
                            <div class="mb-3">
                                <h4 class="text-sm font-medium text-gray-700 mb-1">Learning Materials:</h4>
                                <p class="text-gray-600 text-sm">{{ $week->learning_materials }}</p>
                            </div>
                            @endif

                            <div class="text-sm text-gray-500">
                                <i class="bi bi-clock mr-1"></i>{{ $week->hours_required }} hours required
                            </div>
                        </div>

                        <div class="ml-4">
                            @if($progress && is_object($progress) && $progress->current_week > $week->week_number)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Completed
                                </span>
                            @elseif($progress && is_object($progress) && $progress->current_week == $week->week_number)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Current Week
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Upcoming
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-center space-x-4">
            @if(!$progress || !is_object($progress) || $progress->status === 'not_started')
                <button type="button" 
                        onclick="startModule({{ $module->id }})"
                        class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-medium transition">
                    <i class="bi bi-play mr-2"></i>Start Learning
                </button>
            @elseif($progress->status === 'in_progress')
                <a href="{{ route('entrepreneur.progress.dashboard') }}" 
                   class="bg-[#b81d8f] hover:bg-[#a01a7d] text-white px-6 py-3 rounded-lg font-medium transition">
                    <i class="bi bi-graph-up mr-2"></i>Continue Learning
                </a>
            @elseif($progress->status === 'completed')
                <div class="text-center">
                    <div class="text-green-600 text-lg font-medium mb-2">
                        <i class="bi bi-check-circle mr-2"></i>Module Completed!
                    </div>
                    <p class="text-gray-600">Congratulations on completing this module!</p>
                </div>
            @endif
        </div>

<script>
function startModule(moduleId) {
    console.log('Starting module:', moduleId);
    
    if (confirm('Start this training module?')) {
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        console.log('CSRF Token:', csrfToken);
        
        fetch(`/entrepreneur/progress/${moduleId}/start`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                alert('Module started successfully!');
                window.location.reload();
            } else {
                alert('Error: ' + (data.error || 'Unknown error occurred'));
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Error starting module: ' + error.message);
        });
    }
}
</script>
@endsection
