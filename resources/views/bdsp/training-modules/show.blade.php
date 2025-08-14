@extends('layouts.bdsp')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('bdsp.training-modules.index') }}" class="text-[#b81d8f] hover:text-[#a01a7d] flex items-center">
                <i class="bi bi-arrow-left mr-2"></i>Back to Modules
            </a>
            <div class="flex justify-between items-start mt-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $module->title }}</h1>
                    <p class="text-gray-600 mt-2">{{ $module->description }}</p>
                </div>
                <div class="flex space-x-3">
                    @if($module->status === 'draft')
                        <a href="{{ route('bdsp.training-modules.edit', $module) }}" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition">
                            <i class="bi bi-pencil mr-2"></i>Edit Module
                        </a>
                        <form action="{{ route('bdsp.training-modules.publish', $module) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium transition"
                                    onclick="return confirm('Publish this module? It will be visible to your mentees.')">
                                <i class="bi bi-check-circle mr-2"></i>Publish
                            </button>
                        </form>
                    @elseif($module->status === 'published')
                        <a href="{{ route('bdsp.training-modules.manage', $module) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition">
                            <i class="bi bi-people mr-2"></i>Manage Progress
                        </a>
                        <form action="{{ route('bdsp.training-modules.archive', $module) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition"
                                    onclick="return confirm('Archive this module? It will no longer be visible to mentees.')">
                                <i class="bi bi-archive mr-2"></i>Archive
                            </button>
                        </form>
                    @elseif($module->status === 'archived')
                        <button type="button" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition"
                                onclick="unarchiveModule({{ $module->id }})">
                            <i class="bi bi-arrow-clockwise mr-2"></i>Unarchive
                        </button>
                    @endif
                </div>
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
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-[#b81d8f]">{{ $module->duration_weeks }}</div>
                    <div class="text-sm text-gray-600">Weeks</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-[#b81d8f]">{{ $module->total_hours }}</div>
                    <div class="text-sm text-gray-600">Total Hours</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-[#b81d8f]">{{ $module->weeks->count() }}</div>
                    <div class="text-sm text-gray-600">Weekly Sessions</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-[#b81d8f]">{{ $module->progress->count() }}</div>
                    <div class="text-sm text-gray-600">Active Learners</div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($module->target_audience)
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Target Audience</h3>
                        <p class="text-gray-600">{{ $module->target_audience }}</p>
                    </div>
                @endif

                @if($module->prerequisites)
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Prerequisites</h3>
                        <p class="text-gray-600">{{ $module->prerequisites }}</p>
                    </div>
                @endif
            </div>

            @if($module->learning_objectives)
                <div class="mt-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Learning Objectives</h3>
                    <div class="text-gray-600 whitespace-pre-line">{{ $module->learning_objectives }}</div>
                </div>
            @endif
        </div>

        <!-- Weekly Breakdown -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Weekly Breakdown</h2>
            
            @if($module->weeks->isEmpty())
                <div class="text-center py-8 text-gray-500">
                    <i class="bi bi-calendar-week text-4xl mb-4"></i>
                    <p>No weeks have been added to this module yet.</p>
                    <a href="{{ route('bdsp.training-modules.edit', $module) }}" 
                       class="mt-4 inline-block bg-[#b81d8f] hover:bg-[#a01a7d] text-white px-4 py-2 rounded-lg">
                        Add Weeks
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($module->weeks as $week)
                        <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Week {{ $week->week_number }}: {{ $week->title }}</h3>
                                    <div class="text-sm text-gray-600 mt-1">{{ $week->hours_required }} hours required</div>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Week {{ $week->week_number }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-2">Topics Covered</h4>
                                    <p class="text-gray-600 text-sm">{{ $week->topics }}</p>
                                </div>

                                <div>
                                    <h4 class="font-medium text-gray-900 mb-2">Week Objectives</h4>
                                    <p class="text-gray-600 text-sm">{{ $week->week_objectives ?: 'No specific objectives set for this week.' }}</p>
                                </div>
                            </div>

                            @if($week->learning_materials)
                                <div class="mt-4">
                                    <h4 class="font-medium text-gray-900 mb-2">Learning Materials</h4>
                                    <p class="text-gray-600 text-sm">{{ $week->learning_materials }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Progress Section (for entrepreneurs) -->
        @if(Auth::user()->role === 'entrepreneur' && $progress)
            <div class="bg-white rounded-xl shadow-lg p-6 mt-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Your Progress</h2>
                
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Overall Progress</span>
                        <span class="text-sm font-medium text-gray-900">{{ $overallProgress }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-[#b81d8f] h-2 rounded-full" style="width: {{ $overallProgress }}%"></div>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($module->weeks as $week)
                        @php
                            $weekProgress = $progress->where('week_id', $week->id)->first();
                            $status = $weekProgress ? $weekProgress->status : 'not_started';
                            $percentage = $weekProgress ? $weekProgress->completion_percentage : 0;
                        @endphp
                        
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-medium text-gray-900">Week {{ $week->week_number }}: {{ $week->title }}</h4>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($status === 'completed') bg-green-100 text-green-800
                                    @elseif($status === 'in_progress') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Progress</span>
                                <span class="text-sm font-medium text-gray-900">{{ $percentage }}%</span>
                            </div>
                            
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                                <div class="bg-[#b81d8f] h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            
                            <a href="{{ route('entrepreneur.training-modules.progress', $module) }}" 
                               class="text-[#b81d8f] hover:text-[#a01a7d] text-sm font-medium">
                                Update Progress →
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="mt-8 flex justify-between items-center">
            <div class="flex space-x-4">
                @if($module->status === 'draft')
                    <a href="{{ route('bdsp.training-modules.edit', $module) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg font-medium transition">
                        <i class="bi bi-pencil mr-2"></i>Edit Module
                    </a>
                @endif
                
                @if($module->progress->count() === 0)
                    <form action="{{ route('bdsp.training-modules.destroy', $module) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-medium transition"
                                onclick="return confirm('Delete this module? This action cannot be undone.')">
                            <i class="bi bi-trash mr-2"></i>Delete Module
                        </button>
                    </form>
                @endif
            </div>
            
            <a href="{{ route('bdsp.training-modules.index') }}" 
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                Back to Modules
            </a>
        </div>
    </div>
</div>

<script>
function publishModule(moduleId) {
    if (confirm('Publish this module? It will be visible to your mentees.')) {
        fetch(`/bdsp/training-modules/${moduleId}/publish`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Error publishing module. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error publishing module. Please try again.');
        });
    }
}

function archiveModule(moduleId) {
    if (confirm('Archive this module? It will no longer be visible to mentees.')) {
        fetch(`/bdsp/training-modules/${moduleId}/archive`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Error archiving module. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error archiving module. Please try again.');
        });
    }
}

function unarchiveModule(moduleId) {
    if (confirm('Unarchive this module? It will be set back to draft status.')) {
        fetch(`/bdsp/training-modules/${moduleId}/unarchive`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Error unarchiving module. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error unarchiving module. Please try again.');
        });
    }
}
</script>
@endsection
