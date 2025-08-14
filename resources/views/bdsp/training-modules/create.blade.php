@extends('layouts.bdsp')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('bdsp.training-modules.index') }}" class="text-[#b81d8f] hover:text-[#a01a7d] flex items-center">
                <i class="bi bi-arrow-left mr-2"></i>Back to Modules
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-4">Create New Training Module</h1>
            <p class="text-gray-600 mt-2">Design a structured learning experience for your mentees</p>
        </div>

        <form action="{{ route('bdsp.training-modules.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Basic Module Information -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Module Overview</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Module Title *</label>
                        <input type="text" id="title" name="title" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"
                               placeholder="e.g., Financial Planning Fundamentals">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration_weeks" class="block text-sm font-medium text-gray-700 mb-2">Duration (Weeks) *</label>
                        <input type="number" id="duration_weeks" name="duration_weeks" min="1" max="52" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"
                               placeholder="e.g., 8">
                        @error('duration_weeks')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="total_hours" class="block text-sm font-medium text-gray-700 mb-2">Total Hours *</label>
                        <input type="number" id="total_hours" name="total_hours" min="1" max="1000" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"
                               placeholder="e.g., 24">
                        @error('total_hours')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="target_audience" class="block text-sm font-medium text-gray-700 mb-2">Target Audience</label>
                        <input type="text" id="target_audience" name="target_audience"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"
                               placeholder="e.g., Early-stage entrepreneurs">
                        @error('target_audience')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Module Description *</label>
                    <textarea id="description" name="description" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"
                              placeholder="Describe what this module covers and what mentees will learn..."></textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="prerequisites" class="block text-sm font-medium text-gray-700 mb-2">Prerequisites</label>
                        <textarea id="prerequisites" name="prerequisites" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"
                                  placeholder="What should mentees know before starting this module?"></textarea>
                        @error('prerequisites')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="learning_objectives" class="block text-sm font-medium text-gray-700 mb-2">Learning Objectives</label>
                        <textarea id="learning_objectives" name="learning_objectives" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"
                                  placeholder="What will mentees be able to do after completing this module?"></textarea>
                        @error('learning_objectives')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Weekly Breakdown -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Weekly Breakdown</h2>
                    <button type="button" id="addWeekBtn" 
                            class="bg-[#b81d8f] hover:bg-[#a01a7d] text-white px-4 py-2 rounded-lg font-medium transition">
                        <i class="bi bi-plus-circle mr-2"></i>Add Week
                    </button>
                </div>

                <div id="weeksContainer" class="space-y-6">
                    <!-- Weeks will be added here dynamically -->
                </div>

                @error('weeks')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('bdsp.training-modules.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-[#b81d8f] hover:bg-[#a01a7d] text-white px-8 py-3 rounded-lg font-semibold shadow-lg transition">
                    Create Module
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Week Template -->
<template id="weekTemplate">
    <div class="week-item border border-gray-200 rounded-lg p-6 bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Week <span class="week-number"></span></h3>
            <button type="button" class="remove-week text-red-500 hover:text-red-700 transition">
                <i class="bi bi-trash"></i>
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Week Title *</label>
                <input type="text" name="weeks[INDEX][title]" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"
                       placeholder="e.g., Introduction to Financial Planning">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hours Required *</label>
                <input type="number" name="weeks[INDEX][hours_required]" min="1" max="168" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"
                       placeholder="e.g., 3">
            </div>
        </div>
        
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Topics Covered *</label>
            <textarea name="weeks[INDEX][topics]" rows="3" required
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"
                      placeholder="List the main topics and concepts covered in this week..."></textarea>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Learning Materials</label>
                <textarea name="weeks[INDEX][learning_materials]" rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"
                          placeholder="Books, articles, videos, etc."></textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Week Objectives</label>
                <textarea name="weeks[INDEX][week_objectives]" rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"
                          placeholder="Specific goals for this week"></textarea>
            </div>
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const weeksContainer = document.getElementById('weeksContainer');
    const addWeekBtn = document.getElementById('addWeekBtn');
    const weekTemplate = document.getElementById('weekTemplate');
    let weekIndex = 0;

    function addWeek() {
        const weekHtml = weekTemplate.innerHTML.replace(/INDEX/g, weekIndex);
        const weekDiv = document.createElement('div');
        weekDiv.innerHTML = weekHtml;
        weekDiv.querySelector('.week-number').textContent = weekIndex + 1;
        
        // Add remove functionality
        weekDiv.querySelector('.remove-week').addEventListener('click', function() {
            weekDiv.remove();
            updateWeekNumbers();
        });
        
        weeksContainer.appendChild(weekDiv);
        weekIndex++;
    }

    function updateWeekNumbers() {
        const weekItems = weeksContainer.querySelectorAll('.week-item');
        weekItems.forEach((item, index) => {
            item.querySelector('.week-number').textContent = index + 1;
            // Update the name attributes
            item.querySelectorAll('input, textarea').forEach(input => {
                input.name = input.name.replace(/weeks\[\d+\]/, `weeks[${index}]`);
            });
        });
        weekIndex = weekItems.length;
    }

    addWeekBtn.addEventListener('click', addWeek);
    
    // Add first week by default
    addWeek();
});
</script>
@endsection
