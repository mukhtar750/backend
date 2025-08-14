@extends('layouts.entrepreneur')

@section('title', 'Module Progress - ' . $module->title)

@section('content')
<div class="container mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('entrepreneur.progress.dashboard') }}" class="text-[#b81d8f] hover:text-[#a01a7d] flex items-center">
            <i class="bi bi-arrow-left mr-2"></i>Back to Progress Dashboard
        </a>
        <div class="mt-4">
            <h1 class="text-3xl font-bold text-gray-900">{{ $module->title }}</h1>
            <p class="text-gray-600 mt-2">Progress Tracking</p>
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
                            <span class="text-gray-600">Created by:</span>
                            <span class="font-medium">{{ $module->bdsp->name ?? 'Unknown BDSP' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Section -->
        @if($progress)
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Your Progress</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-[#b81d8f]">{{ $overallProgress }}%</div>
                    <div class="text-sm text-gray-600">Overall Progress</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">Week {{ $progress->current_week ?? 1 }}</div>
                    <div class="text-sm text-gray-600">Current Week</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ ucfirst($progress->status ?? 'not_started') }}</div>
                    <div class="text-sm text-gray-600">Status</div>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Progress Bar</span>
                    <span class="text-sm font-medium text-gray-900">{{ $overallProgress }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-[#b81d8f] h-3 rounded-full transition-all duration-300" style="width: {{ $overallProgress }}%"></div>
                </div>
            </div>

            @if($progress->started_at)
            <div class="text-sm text-gray-600">
                <i class="bi bi-calendar mr-2"></i>Started: {{ $progress->started_at->format('M d, Y') }}
            </div>
            @endif

            @if($progress->completed_at)
            <div class="text-sm text-gray-600 mt-2">
                <i class="bi bi-check-circle mr-2"></i>Completed: {{ $progress->completed_at->format('M d, Y') }}
            </div>
            @endif
        </div>
        @else
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="text-center">
                <div class="text-gray-400 mb-4">
                    <i class="bi bi-book text-6xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Not Enrolled Yet</h3>
                <p class="text-gray-500 mb-6">You haven't started this module yet.</p>
                <a href="{{ route('entrepreneur.training-modules.show', $module->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-[#b81d8f] text-white rounded-lg hover:bg-[#a01a7d] transition">
                    <i class="bi bi-play mr-2"></i>Start Learning
                </a>
            </div>
        </div>
        @endif

        <!-- Weekly Breakdown -->
        @if($module->weeks && $module->weeks->count() > 0)
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Weekly Breakdown</h2>
            
            <div class="space-y-4">
                @foreach($module->weeks as $week)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Week {{ $week->week_number }}</h3>
                            <p class="text-gray-600 mb-3">{{ $week->title }}</p>
                            
                            @if($week->description)
                            <p class="text-gray-600 text-sm mb-3">{{ $week->description }}</p>
                            @endif

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
                            @if($progress && $progress->current_week > $week->week_number)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Completed
                                </span>
                            @elseif($progress && $progress->current_week == $week->week_number)
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
        @endif

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-center space-x-4">
            @if(!$progress || $progress->status === 'not_started')
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
