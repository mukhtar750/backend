@extends('layouts.bdsp')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('bdsp.training-modules.show', $module) }}" class="text-[#b81d8f] hover:text-[#a01a7d] flex items-center">
                <i class="bi bi-arrow-left mr-2"></i>Back to Module
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-4">Edit Training Module</h1>
            <p class="text-gray-600 mt-2">Update your training module information and weekly breakdown</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('bdsp.training-modules.update', $module) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Module Overview -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Module Overview</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Module Title *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $module->title) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration_weeks" class="block text-sm font-medium text-gray-700 mb-2">Duration (Weeks) *</label>
                        <input type="number" id="duration_weeks" name="duration_weeks" value="{{ old('duration_weeks', $module->duration_weeks) }}" 
                               min="1" max="52" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                        @error('duration_weeks')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="total_hours" class="block text-sm font-medium text-gray-700 mb-2">Total Hours *</label>
                        <input type="number" id="total_hours" name="total_hours" value="{{ old('total_hours', $module->total_hours) }}" 
                               min="1" max="1000" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                        @error('total_hours')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="target_audience" class="block text-sm font-medium text-gray-700 mb-2">Target Audience</label>
                        <input type="text" id="target_audience" name="target_audience" value="{{ old('target_audience', $module->target_audience) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                        @error('target_audience')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                    <textarea id="description" name="description" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">{{ old('description', $module->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="prerequisites" class="block text-sm font-medium text-gray-700 mb-2">Prerequisites</label>
                    <textarea id="prerequisites" name="prerequisites" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">{{ old('prerequisites', $module->prerequisites) }}</textarea>
                    @error('prerequisites')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="learning_objectives" class="block text-sm font-medium text-gray-700 mb-2">Learning Objectives</label>
                    <textarea id="learning_objectives" name="learning_objectives" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">{{ old('learning_objectives', $module->learning_objectives) }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">List the key learning outcomes for this module</p>
                    @error('learning_objectives')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Weekly Breakdown -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Weekly Breakdown</h2>
                    <button type="button" onclick="addWeek()" 
                            class="bg-[#b81d8f] hover:bg-[#a01a7d] text-white px-4 py-2 rounded-lg font-medium transition">
                        <i class="bi bi-plus mr-2"></i>Add Week
                    </button>
                </div>

                <div id="weeks-container" class="space-y-6">
                    @foreach($module->weeks as $index => $week)
                        <div class="week-item border border-gray-200 rounded-lg p-6 bg-gray-50" data-week-index="{{ $index }}">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Week {{ $index + 1 }}</h3>
                                <button type="button" onclick="removeWeek(this)" 
                                        class="text-red-500 hover:text-red-700 font-medium">
                                    <i class="bi bi-trash mr-1"></i>Remove
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="weeks[{{ $index }}][title]" class="block text-sm font-medium text-gray-700 mb-2">Week Title *</label>
                                    <input type="text" name="weeks[{{ $index }}][title]" value="{{ $week->title }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                                </div>

                                <div>
                                    <label for="weeks[{{ $index }}][hours_required]" class="block text-sm font-medium text-gray-700 mb-2">Hours Required *</label>
                                    <input type="number" name="weeks[{{ $index }}][hours_required]" value="{{ $week->hours_required }}" 
                                           min="1" max="168" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="weeks[{{ $index }}][topics]" class="block text-sm font-medium text-gray-700 mb-2">Topics Covered *</label>
                                <textarea name="weeks[{{ $index }}][topics]" rows="3" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">{{ $week->topics }}</textarea>
                            </div>

                            <div class="mt-4">
                                <label for="weeks[{{ $index }}][week_objectives]" class="block text-sm font-medium text-gray-700 mb-2">Week Objectives</label>
                                <textarea name="weeks[{{ $index }}][week_objectives]" rows="2"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">{{ $week->week_objectives }}</textarea>
                            </div>

                            <div class="mt-4">
                                <label for="weeks[{{ $index }}][learning_materials]" class="block text-sm font-medium text-gray-700 mb-2">Learning Materials</label>
                                <textarea name="weeks[{{ $index }}][learning_materials]" rows="2"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">{{ $week->learning_materials }}</textarea>
                            </div>

                            <!-- Hidden fields for week data -->
                            <input type="hidden" name="weeks[{{ $index }}][week_number]" value="{{ $index + 1 }}">
                            <input type="hidden" name="weeks[{{ $index }}][order]" value="{{ $index }}">
                        </div>
                    @endforeach
                </div>

                @error('weeks')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center">
                <a href="{{ route('bdsp.training-modules.show', $module) }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                    Cancel
                </a>
                
                <button type="submit" 
                        class="bg-[#b81d8f] hover:bg-[#a01a7d] text-white px-6 py-3 rounded-lg font-medium transition">
                    <i class="bi bi-check-circle mr-2"></i>Update Module
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let weekCounter = {{ $module->weeks->count() }};

function addWeek() {
    const container = document.getElementById('weeks-container');
    const weekIndex = weekCounter;
    
    const weekHtml = `
        <div class="week-item border border-gray-200 rounded-lg p-6 bg-gray-50" data-week-index="${weekIndex}">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Week ${weekIndex + 1}</h3>
                <button type="button" onclick="removeWeek(this)" 
                        class="text-red-500 hover:text-red-700 font-medium">
                    <i class="bi bi-trash mr-1"></i>Remove
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="weeks[${weekIndex}][title]" class="block text-sm font-medium text-gray-700 mb-2">Week Title *</label>
                    <input type="text" name="weeks[${weekIndex}][title]" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                </div>

                <div>
                    <label for="weeks[${weekIndex}][hours_required]" class="block text-sm font-medium text-gray-700 mb-2">Hours Required *</label>
                    <input type="number" name="weeks[${weekIndex}][hours_required]" 
                           min="1" max="168" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                </div>
            </div>

            <div class="mt-4">
                <label for="weeks[${weekIndex}][topics]" class="block text-sm font-medium text-gray-700 mb-2">Topics Covered *</label>
                <textarea name="weeks[${weekIndex}][topics]" rows="3" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"></textarea>
            </div>

            <div class="mt-4">
                <label for="weeks[${weekIndex}][week_objectives]" class="block text-sm font-medium text-gray-700 mb-2">Week Objectives</label>
                <textarea name="weeks[${weekIndex}][week_objectives]" rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"></textarea>
            </div>

            <div class="mt-4">
                <label for="weeks[${weekIndex}][learning_materials]" class="block text-sm font-medium text-gray-700 mb-2">Learning Materials</label>
                <textarea name="weeks[${weekIndex}][learning_materials]" rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"></textarea>
            </div>

            <!-- Hidden fields for week data -->
            <input type="hidden" name="weeks[${weekIndex}][week_number]" value="${weekIndex + 1}">
            <input type="hidden" name="weeks[${weekIndex}][order]" value="${weekIndex}">
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', weekHtml);
    weekCounter++;
    
    // Update duration weeks field
    document.getElementById('duration_weeks').value = weekCounter;
}

function removeWeek(button) {
    const weekItem = button.closest('.week-item');
    weekItem.remove();
    weekCounter--;
    
    // Update duration weeks field
    document.getElementById('duration_weeks').value = weekCounter;
    
    // Reorder remaining weeks
    const remainingWeeks = document.querySelectorAll('.week-item');
    remainingWeeks.forEach((week, index) => {
        const weekNumber = week.querySelector('h3');
        weekNumber.textContent = `Week ${index + 1}`;
        
        // Update hidden fields
        const weekNumberInput = week.querySelector('input[name*="[week_number]"]');
        const orderInput = week.querySelector('input[name*="[order]"]');
        if (weekNumberInput) weekNumberInput.value = index + 1;
        if (orderInput) orderInput.value = index;
    });
}
</script>
@endsection
