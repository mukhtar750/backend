@extends('layouts.entrepreneur')

@section('title', 'Assignments & Tasks')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Assignments & Tasks</h1>
        <div class="flex space-x-3">
            <div class="relative">
                <button id="filterDropdown" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 transition flex items-center">
                    <i class="bi bi-funnel-fill mr-2"></i> Filter
                    <i class="bi bi-chevron-down ml-2"></i>
                </button>
                <!-- Filter Dropdown -->
                <div id="filterMenu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg z-10 border border-gray-200">
                    <div class="p-3">
                        <h3 class="font-medium text-gray-700 mb-2">Status</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-[#b81d8f] rounded">
                                <span class="ml-2 text-gray-700">Pending</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-[#b81d8f] rounded">
                                <span class="ml-2 text-gray-700">In Progress</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-[#b81d8f] rounded">
                                <span class="ml-2 text-gray-700">Completed</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-[#b81d8f] rounded">
                                <span class="ml-2 text-gray-700">Overdue</span>
                            </label>
                        </div>
                        
                        <h3 class="font-medium text-gray-700 mt-4 mb-2">Priority</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-[#b81d8f] rounded">
                                <span class="ml-2 text-gray-700">High</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-[#b81d8f] rounded">
                                <span class="ml-2 text-gray-700">Medium</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-[#b81d8f] rounded">
                                <span class="ml-2 text-gray-700">Low</span>
                            </label>
                        </div>
                        
                        <div class="mt-4 flex justify-end">
                            <button class="bg-[#b81d8f] text-white px-3 py-1 rounded-lg text-sm">Apply Filters</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative">
                <button id="sortDropdown" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 transition flex items-center">
                    <i class="bi bi-sort-down mr-2"></i> Sort
                    <i class="bi bi-chevron-down ml-2"></i>
                </button>
                <!-- Sort Dropdown -->
                <div id="sortMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10 border border-gray-200">
                    <div class="py-1">
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Due Date (Earliest)</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Due Date (Latest)</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Priority (High-Low)</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Priority (Low-High)</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Recently Added</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Task Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-blue-500 font-medium">Total Tasks</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalTasks ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 p-2 rounded-full">
                    <i class="bi bi-list-check text-blue-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-green-500 font-medium">Completed</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $completedTasks ?? 0 }}</p>
                </div>
                <div class="bg-green-100 p-2 rounded-full">
                    <i class="bi bi-check-circle text-green-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-yellow-500 font-medium">In Progress</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $inProgressTasks ?? 0 }}</p>
                </div>
                <div class="bg-yellow-100 p-2 rounded-full">
                    <i class="bi bi-hourglass-split text-yellow-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-red-500 font-medium">Overdue</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $overdueTasks ?? 0 }}</p>
                </div>
                <div class="bg-red-100 p-2 rounded-full">
                    <i class="bi bi-exclamation-circle text-red-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tasks List -->
    <div class="space-y-4">
        @foreach($tasks as $task)
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <h2 class="font-bold text-lg">{{ $task->title }}</h2>
                        <div class="text-xs text-gray-500">Due: {{ $task->due_date->format('Y-m-d') }}</div>
                    </div>
                    <span class="px-2 py-1 rounded text-xs {{ $task->getStatusClass() }}">{{ $task->getStatusLabel() }}</span>
                </div>
                <div class="mb-2 text-gray-700">{{ $task->description }}</div>
                @php $submission = $task->submissions()->where('user_id', auth()->id())->latest()->first(); @endphp
                @if(!$submission)
                    <form action="{{ route('tasks.submissions.store', $task) }}" method="POST" enctype="multipart/form-data" class="mt-4 bg-gray-50 p-4 rounded">
                        @csrf
                        <div class="mb-3">
                            <label class="block font-semibold mb-1">Upload File</label>
                            <input type="file" name="file" class="form-input w-full rounded">
                        </div>
                        <div class="mb-3">
                            <label class="block font-semibold mb-1">Notes</label>
                            <textarea name="notes" class="form-input w-full rounded" rows="2" placeholder="Add any notes..."></textarea>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit Assignment</button>
                    </form>
                @else
                    <div class="mt-4">
                        <a href="{{ route('submissions.show', $submission) }}" class="text-green-700 font-semibold hover:underline">View Submission</a>
                        <span class="ml-2 px-2 py-1 rounded text-xs {{ $submission->status === 'reviewed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($submission->status) }}</span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="mt-6 flex justify-between items-center">
        <p class="text-sm text-gray-600">Showing {{ $tasks->count() }} of {{ $totalTasks ?? 0 }} tasks</p>
        <div class="flex space-x-1">
            <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-50 disabled:opacity-50" disabled>
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="px-3 py-1 border border-gray-300 rounded-md bg-[#b81d8f] text-white">
                1
            </button>
            <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-50">
                2
            </button>
            <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-50">
                3
            </button>
            <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-50">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<!-- JavaScript for dropdowns -->
<script>
    // Filter dropdown
    const filterDropdown = document.getElementById('filterDropdown');
    const filterMenu = document.getElementById('filterMenu');
    
    filterDropdown.addEventListener('click', function() {
        filterMenu.classList.toggle('hidden');
        sortMenu.classList.add('hidden'); // Close other dropdown
    });
    
    // Sort dropdown
    const sortDropdown = document.getElementById('sortDropdown');
    const sortMenu = document.getElementById('sortMenu');
    
    sortDropdown.addEventListener('click', function() {
        sortMenu.classList.toggle('hidden');
        filterMenu.classList.add('hidden'); // Close other dropdown
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!filterDropdown.contains(event.target) && !filterMenu.contains(event.target)) {
            filterMenu.classList.add('hidden');
        }
        
        if (!sortDropdown.contains(event.target) && !sortMenu.contains(event.target)) {
            sortMenu.classList.add('hidden');
        }
    });
</script>
@endsection