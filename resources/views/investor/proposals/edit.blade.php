@extends('layouts.investor')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Proposal</h1>
            <p class="text-gray-600 mt-2">Update your pitch event proposal</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('investor.proposals.update', $proposal) }}" method="POST" class="bg-white rounded-lg shadow-lg p-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Basic Information -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Basic Information</h3>
                    
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Event Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $proposal->title) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Event Description *</label>
                        <textarea name="description" id="description" rows="4" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $proposal->description) }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Describe the event, its purpose, and what participants can expect.</p>
                    </div>

                    <div>
                        <label for="event_type" class="block text-sm font-medium text-gray-700 mb-2">Event Type *</label>
                        <select name="event_type" id="event_type" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Event Type</option>
                            <option value="pitch_competition" {{ old('event_type', $proposal->event_type) == 'pitch_competition' ? 'selected' : '' }}>Pitch Competition</option>
                            <option value="networking" {{ old('event_type', $proposal->event_type) == 'networking' ? 'selected' : '' }}>Networking Event</option>
                            <option value="demo_day" {{ old('event_type', $proposal->event_type) == 'demo_day' ? 'selected' : '' }}>Demo Day</option>
                            <option value="workshop" {{ old('event_type', $proposal->event_type) == 'workshop' ? 'selected' : '' }}>Workshop</option>
                        </select>
                    </div>

                    <div>
                        <label for="target_sector" class="block text-sm font-medium text-gray-700 mb-2">Target Sector</label>
                        <input type="text" name="target_sector" id="target_sector" value="{{ old('target_sector', $proposal->target_sector) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., FinTech, HealthTech, EdTech">
                    </div>

                    <div>
                        <label for="target_stage" class="block text-sm font-medium text-gray-700 mb-2">Target Funding Stage</label>
                        <select name="target_stage" id="target_stage"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Any Stage</option>
                            <option value="seed" {{ old('target_stage', $proposal->target_stage) == 'seed' ? 'selected' : '' }}>Seed Stage</option>
                            <option value="series_a" {{ old('target_stage', $proposal->target_stage) == 'series_a' ? 'selected' : '' }}>Series A</option>
                            <option value="series_b" {{ old('target_stage', $proposal->target_stage) == 'series_b' ? 'selected' : '' }}>Series B</option>
                            <option value="series_c" {{ old('target_stage', $proposal->target_stage) == 'series_c' ? 'selected' : '' }}>Series C</option>
                            <option value="growth" {{ old('target_stage', $proposal->target_stage) == 'growth' ? 'selected' : '' }}>Growth Stage</option>
                        </select>
                    </div>
                </div>

                <!-- Event Details -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Event Details</h3>
                    
                    <div>
                        <label for="target_criteria" class="block text-sm font-medium text-gray-700 mb-2">Target Criteria</label>
                        <textarea name="target_criteria" id="target_criteria" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Specific criteria for participating startups...">{{ old('target_criteria', $proposal->target_criteria) }}</textarea>
                    </div>

                    <div>
                        <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-2">Maximum Participants</label>
                        <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants', $proposal->max_participants) }}" min="1" max="1000"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="min_funding_needed" class="block text-sm font-medium text-gray-700 mb-2">Min Funding Needed ($)</label>
                            <input type="number" name="min_funding_needed" id="min_funding_needed" value="{{ old('min_funding_needed', $proposal->min_funding_needed) }}" min="0" step="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="max_funding_needed" class="block text-sm font-medium text-gray-700 mb-2">Max Funding Needed ($)</label>
                            <input type="number" name="max_funding_needed" id="max_funding_needed" value="{{ old('max_funding_needed', $proposal->max_funding_needed) }}" min="0" step="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="expected_outcomes" class="block text-sm font-medium text-gray-700 mb-2">Expected Outcomes *</label>
                        <textarea name="expected_outcomes" id="expected_outcomes" rows="3" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="What do you expect to achieve with this event?">{{ old('expected_outcomes', $proposal->expected_outcomes) }}</textarea>
                    </div>

                    <div>
                        <label for="success_metrics" class="block text-sm font-medium text-gray-700 mb-2">Success Metrics</label>
                        <textarea name="success_metrics" id="success_metrics" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="How will you measure the success of this event?">{{ old('success_metrics', $proposal->success_metrics) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Event Format & Logistics -->
            <div class="mt-8 space-y-6">
                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Event Format & Logistics</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label for="proposed_format" class="block text-sm font-medium text-gray-700 mb-2">Proposed Format</label>
                            <textarea name="proposed_format" id="proposed_format" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Detailed description of the event format, agenda, and structure...">{{ old('proposed_format', $proposal->proposed_format) }}</textarea>
                        </div>

                        <div>
                            <label for="supporting_rationale" class="block text-sm font-medium text-gray-700 mb-2">Supporting Rationale</label>
                            <textarea name="supporting_rationale" id="supporting_rationale" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Why is this event needed? What market gap does it address?">{{ old('supporting_rationale', $proposal->supporting_rationale) }}</textarea>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="proposed_date" class="block text-sm font-medium text-gray-700 mb-2">Proposed Date</label>
                                <input type="date" name="proposed_date" id="proposed_date" value="{{ old('proposed_date', $proposal->proposed_date ? $proposal->proposed_date->format('Y-m-d') : '') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="proposed_time" class="block text-sm font-medium text-gray-700 mb-2">Proposed Time</label>
                                <input type="time" name="proposed_time" id="proposed_time" value="{{ old('proposed_time', $proposal->proposed_time ? $proposal->proposed_time->format('H:i') : '') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div>
                            <label for="proposed_duration" class="block text-sm font-medium text-gray-700 mb-2">Duration (minutes)</label>
                            <input type="number" name="proposed_duration" id="proposed_duration" value="{{ old('proposed_duration', $proposal->proposed_duration) }}" min="30" max="480"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="proposed_location" class="block text-sm font-medium text-gray-700 mb-2">Proposed Location</label>
                            <input type="text" name="proposed_location" id="proposed_location" value="{{ old('proposed_location', $proposal->proposed_location) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Physical location or 'Virtual'">
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_virtual" id="is_virtual" value="1" {{ old('is_virtual', $proposal->is_virtual) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_virtual" class="ml-2 block text-sm text-gray-900">Virtual Event</label>
                        </div>

                        <div id="virtual_platform_div" class="{{ old('is_virtual', $proposal->is_virtual) ? '' : 'hidden' }}">
                            <label for="virtual_platform" class="block text-sm font-medium text-gray-700 mb-2">Virtual Platform</label>
                            <input type="text" name="virtual_platform" id="virtual_platform" value="{{ old('virtual_platform', $proposal->virtual_platform) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="e.g., Zoom, Google Meet, Microsoft Teams">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="additional_requirements" class="block text-sm font-medium text-gray-700 mb-2">Additional Requirements</label>
                    <textarea name="additional_requirements" id="additional_requirements" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Any additional requirements, special needs, or considerations...">{{ old('additional_requirements', $proposal->additional_requirements) }}</textarea>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('investor.proposals.show', $proposal) }}" 
                   class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                    Update Proposal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isVirtualCheckbox = document.getElementById('is_virtual');
    const virtualPlatformDiv = document.getElementById('virtual_platform_div');
    
    isVirtualCheckbox.addEventListener('change', function() {
        if (this.checked) {
            virtualPlatformDiv.classList.remove('hidden');
        } else {
            virtualPlatformDiv.classList.add('hidden');
        }
    });
});
</script>
@endsection 