@extends('admin.layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Training Modules Analytics</h1>
            <p class="text-gray-600 mt-2">Comprehensive insights into training module performance</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.training-modules.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                <i class="bi bi-arrow-left mr-2"></i>Back to Modules
            </a>
            <a href="{{ route('admin.training-modules.export') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                <i class="bi bi-download mr-2"></i>Export Data
            </a>
        </div>
    </div>

    <!-- Overall Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-3xl font-bold text-blue-600">{{ $overallStats['total_modules'] }}</div>
            <div class="text-sm text-gray-600">Total Modules</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-3xl font-bold text-green-600">{{ $overallStats['published_modules'] }}</div>
            <div class="text-sm text-gray-600">Published</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-3xl font-bold text-purple-600">{{ $overallStats['total_enrollments'] }}</div>
            <div class="text-sm text-gray-600">Total Enrollments</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-3xl font-bold text-indigo-600">{{ $overallStats['active_learners'] }}</div>
            <div class="text-sm text-gray-600">Active Learners</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-3xl font-bold text-orange-600">{{ number_format($overallStats['completion_rate'], 1) }}%</div>
            <div class="text-sm text-gray-600">Completion Rate</div>
        </div>
    </div>

    <!-- Charts and Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- BDSP Performance -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Top BDSP Performers</h3>
            
            @if($bdspPerformance->count() > 0)
                <div class="space-y-4">
                    @foreach($bdspPerformance as $performance)
                        @if($performance->bdsp)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <div class="font-semibold text-sm text-gray-800">{{ $performance->bdsp->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $performance->module_count }} modules • {{ number_format($performance->avg_duration, 1) }} weeks avg</div>
                                </div>
                                <div class="text-lg font-bold text-blue-600">{{ $performance->module_count }}</div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No BDSP performance data available</p>
            @endif
        </div>

        <!-- Popular Modules -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Most Popular Modules</h3>
            
            @if($popularModules->count() > 0)
                <div class="space-y-4">
                    @foreach($popularModules as $module)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-semibold text-sm text-gray-800">{{ $module->title }}</div>
                                <div class="text-xs text-gray-500">by {{ $module->bdsp->name ?? 'Unknown' }}</div>
                            </div>
                            <div class="text-lg font-bold text-green-600">{{ $module->completions_count }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No module popularity data available</p>
            @endif
        </div>
    </div>

    <!-- Monthly Trends -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Module Creation Trends</h3>
        
        @if($monthlyTrends->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modules Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visual</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($monthlyTrends as $trend)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $trend->month)->format('M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $trend->count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-32 bg-gray-200 rounded-full h-2">
                                        @php
                                            $maxCount = $monthlyTrends->max('count');
                                            $percentage = $maxCount > 0 ? ($trend->count / $maxCount) * 100 : 0;
                                        @endphp
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No trend data available</p>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.training-modules.index') }}" class="bg-blue-50 p-4 rounded-lg text-center hover:bg-blue-100 transition">
                <i class="bi bi-list-ul text-blue-600 text-2xl mb-2 block"></i>
                <p class="font-semibold text-sm text-gray-700">View All Modules</p>
            </a>
            
            <a href="{{ route('admin.training-modules.export') }}" class="bg-green-50 p-4 rounded-lg text-center hover:bg-green-100 transition">
                <i class="bi bi-download text-green-600 text-2xl mb-2 block"></i>
                <p class="font-semibold text-sm text-gray-700">Export Data</p>
            </a>
            
            <a href="{{ route('admin.dashboard') }}" class="bg-purple-50 p-4 rounded-lg text-center hover:bg-purple-100 transition">
                <i class="bi bi-speedometer2 text-purple-600 text-2xl mb-2 block"></i>
                <p class="font-semibold text-sm text-gray-700">Back to Dashboard</p>
            </a>
        </div>
    </div>
</div>
@endsection
