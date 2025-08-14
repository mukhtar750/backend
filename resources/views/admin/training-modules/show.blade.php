@extends('admin.layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $module->title }}</h1>
            <p class="text-gray-600 mt-2">Module Details & Enrollment Management</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.training-modules.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                <i class="bi bi-arrow-left mr-2"></i>Back to Modules
            </a>
            @if($module->status === 'draft')
                <form method="POST" action="{{ route('admin.training-modules.approve', $module) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        <i class="bi bi-check-circle mr-2"></i>Approve & Publish
                    </button>
                </form>
            @endif
            @if($module->status === 'published')
                <form method="POST" action="{{ route('admin.training-modules.archive', $module) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition">
                        <i class="bi bi-archive mr-2"></i>Archive
                    </button>
                </form>
            @endif
            @if($module->status === 'archived')
                <form method="POST" action="{{ route('admin.training-modules.unarchive', $module) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="bi bi-arrow-clockwise mr-2"></i>Unarchive
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Module Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Main Module Details -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Module Information</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <p class="text-sm text-gray-900">{{ $module->title }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <p class="text-sm text-gray-900">{{ $module->description }}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Duration</label>
                        <p class="text-sm text-gray-900">{{ $module->duration_weeks }} weeks ({{ $module->total_hours }} hours)</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            @if($module->status === 'published') bg-green-100 text-green-800
                            @elseif($module->status === 'draft') bg-yellow-100 text-yellow-800
                            @elseif($module->status === 'archived') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($module->status) }}
                        </span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Target Audience</label>
                    <p class="text-sm text-gray-900">{{ $module->target_audience }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Prerequisites</label>
                    <p class="text-sm text-gray-900">{{ $module->prerequisites }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Learning Objectives</label>
                    <div class="text-sm text-gray-900 whitespace-pre-line">{{ $module->learning_objectives }}</div>
                </div>
            </div>
        </div>

        <!-- Module Statistics -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Enrollment Statistics</h3>
            
            <div class="space-y-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-3xl font-bold text-blue-600">{{ $enrollmentStats['total_enrolled'] }}</div>
                    <div class="text-sm text-gray-600">Total Enrolled</div>
                </div>
                
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-3xl font-bold text-green-600">{{ $enrollmentStats['completed'] }}</div>
                    <div class="text-sm text-gray-600">Completed</div>
                </div>
                
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <div class="text-3xl font-bold text-yellow-600">{{ $enrollmentStats['in_progress'] }}</div>
                    <div class="text-sm text-gray-600">In Progress</div>
                </div>
                
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <div class="text-3xl font-bold text-purple-600">{{ number_format($enrollmentStats['avg_progress'], 1) }}%</div>
                    <div class="text-sm text-gray-600">Average Progress</div>
                </div>
            </div>
        </div>
    </div>

    <!-- BDSP Information -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">BDSP Creator</h2>
        
        @if($module->bdsp)
            <div class="flex items-center space-x-4">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="bi bi-person-fill text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $module->bdsp->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $module->bdsp->email }}</p>
                    <p class="text-xs text-gray-500">Created {{ $module->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @else
            <p class="text-gray-500">No BDSP information available</p>
        @endif
    </div>

    <!-- Weekly Breakdown -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Weekly Breakdown</h2>
        
        @if($module->weeks->count() > 0)
            <div class="space-y-4">
                @foreach($module->weeks as $week)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold text-gray-900">Week {{ $week->week_number }}</h4>
                                <p class="text-sm text-gray-600">{{ $week->title }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $week->description }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-sm text-gray-500">{{ $week->duration_hours }} hours</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No weekly breakdown available</p>
        @endif
    </div>

    <!-- Recent Enrollments -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Enrollments</h2>
        
        @if($recentEnrollments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entrepreneur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Week</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrolled</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentEnrollments as $enrollment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $enrollment->entrepreneur->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $enrollment->entrepreneur->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($enrollment->status === 'completed') bg-green-100 text-green-800
                                        @elseif($enrollment->status === 'in_progress') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $enrollment->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $enrollment->progress_percentage }}%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Week {{ $enrollment->current_week }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $enrollment->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No enrollments yet</p>
        @endif
    </div>
</div>
@endsection
