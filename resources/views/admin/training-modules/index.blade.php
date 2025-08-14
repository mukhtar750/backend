@extends('admin.layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Training Modules Management</h1>
            <p class="text-gray-600 mt-2">Manage and monitor all training modules across the platform</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.training-modules.analytics') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="bi bi-graph-up mr-2"></i>Analytics
            </a>
            <a href="{{ route('admin.training-modules.export') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                <i class="bi bi-download mr-2"></i>Export Data
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-3xl font-bold text-blue-600">{{ $stats['total_modules'] }}</div>
            <div class="text-sm text-gray-600">Total Modules</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-3xl font-bold text-green-600">{{ $stats['published_modules'] }}</div>
            <div class="text-sm text-gray-600">Published</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-3xl font-bold text-yellow-600">{{ $stats['draft_modules'] }}</div>
            <div class="text-sm text-gray-600">Draft</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-3xl font-bold text-purple-600">{{ $stats['total_enrollments'] }}</div>
            <div class="text-sm text-gray-600">Total Enrollments</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <div class="text-3xl font-bold text-indigo-600">{{ $stats['active_learners'] }}</div>
            <div class="text-sm text-gray-600">Active Learners</div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <form method="GET" action="{{ route('admin.training-modules.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#b81d8f]"
                       placeholder="Search modules...">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#b81d8f]">
                    <option value="">All Statuses</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">BDSP</label>
                <select name="bdsp" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#b81d8f]">
                    <option value="">All BDSPs</option>
                    @foreach($bdspUsers as $bdsp)
                        <option value="{{ $bdsp->id }}" {{ request('bdsp') == $bdsp->id ? 'selected' : '' }}>
                            {{ $bdsp->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-[#b81d8f] text-white px-4 py-2 rounded-md hover:bg-[#a01a7d] transition">
                    <i class="bi bi-search mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Modules Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Training Modules</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Module</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BDSP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrollments</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($modules as $module)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $module->title }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($module->description, 60) }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $module->bdsp->name ?? 'Unknown' }}</div>
                                <div class="text-sm text-gray-500">{{ $module->bdsp->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @if($module->status === 'published') bg-green-100 text-green-800
                                    @elseif($module->status === 'draft') bg-yellow-100 text-yellow-800
                                    @elseif($module->status === 'archived') bg-gray-100 text-gray-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($module->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $module->duration_weeks }} weeks
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $module->completions()->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $module->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.training-modules.show', $module) }}" 
                                       class="text-blue-600 hover:text-blue-900">View</a>
                                    
                                    @if($module->status === 'draft')
                                        <form method="POST" action="{{ route('admin.training-modules.approve', $module) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                                        </form>
                                    @endif
                                    
                                    @if($module->status === 'published')
                                        <form method="POST" action="{{ route('admin.training-modules.archive', $module) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-900">Archive</button>
                                        </form>
                                    @endif
                                    
                                    @if($module->status === 'archived')
                                        <form method="POST" action="{{ route('admin.training-modules.unarchive', $module) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-blue-600 hover:text-blue-900">Unarchive</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No training modules found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($modules->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $modules->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
