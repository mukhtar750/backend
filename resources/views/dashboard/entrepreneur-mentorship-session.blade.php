@extends('layouts.entrepreneur')
@section('title', 'Mentorship Session')
@section('content')
<div class="max-w-4xl mx-auto py-8">
    <!-- Session Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Mentorship Session #{{ $id }}</h1>
                <p class="text-gray-600 mt-1">Session with {{ $session->mentor->name ?? 'Your Mentor' }}</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-sm font-medium 
                    @if($session->status === 'scheduled') bg-blue-100 text-blue-800
                    @elseif($session->status === 'completed') bg-green-100 text-green-800
                    @elseif($session->status === 'cancelled') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($session->status ?? 'Scheduled') }}
                </span>
            </div>
        </div>
        
        <!-- Session Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="bi bi-calendar-event text-purple-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Date & Time</p>
                    <p class="font-medium">{{ $session->date_time ? $session->date_time->format('M d, Y g:i A') : 'TBD' }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="bi bi-clock text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Duration</p>
                    <p class="font-medium">{{ $session->duration ?? '60' }} minutes</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="bi bi-geo-alt text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Location</p>
                    <p class="font-medium">{{ $session->meeting_link ? 'Virtual Meeting' : ($session->location ?? 'TBD') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Content Tabs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button class="border-b-2 border-purple-500 py-4 px-1 text-sm font-medium text-purple-600" id="overview-tab">
                    Overview
                </button>
                <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700" id="agenda-tab">
                    Agenda
                </button>
                <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700" id="notes-tab">
                    Notes
                </button>
                <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700" id="actions-tab">
                    Action Items
                </button>
            </nav>
        </div>

        <div class="p-6">
            <!-- Overview Tab -->
            <div id="overview-content" class="tab-content">
                <div class="space-y-6">
                    <!-- Session Objectives -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Session Objectives</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700">{{ $session->topic ?? 'No specific objectives set for this session. Focus areas will be determined during the meeting.' }}</p>
                        </div>
                    </div>

                    <!-- Mentor Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Mentor Information</h3>
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                            <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center">
                                <i class="bi bi-person text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $session->mentor->name ?? 'Your Mentor' }}</p>
                                <p class="text-sm text-gray-600">{{ $session->mentor->specialty ?? 'Business Development' }}</p>
                                <p class="text-xs text-gray-500">{{ $session->mentor->organization ?? 'Professional Mentor' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Preparation Checklist -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Preparation Checklist</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                <span class="ml-3 text-sm text-gray-700">Review previous session notes</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                <span class="ml-3 text-sm text-gray-700">Prepare questions and challenges</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                <span class="ml-3 text-sm text-gray-700">Update progress on action items</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                <span class="ml-3 text-sm text-gray-700">Test meeting link/equipment</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agenda Tab -->
            <div id="agenda-content" class="tab-content hidden">
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Session Agenda</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-blue-600">1</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Check-in & Progress Review (15 min)</p>
                                <p class="text-sm text-gray-600">Review progress on previous action items and current challenges</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-green-600">2</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Main Discussion Topic (30 min)</p>
                                <p class="text-sm text-gray-600">Deep dive into current business challenges and strategic planning</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-purple-50 rounded-lg">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-purple-600">3</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Action Planning (10 min)</p>
                                <p class="text-sm text-gray-600">Define next steps and action items for the coming period</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-orange-50 rounded-lg">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-orange-600">4</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Wrap-up & Next Session (5 min)</p>
                                <p class="text-sm text-gray-600">Summarize key takeaways and schedule next session</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Tab -->
            <div id="notes-content" class="tab-content hidden">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Session Notes</h3>
                        <button class="text-purple-600 hover:text-purple-700 text-sm font-medium">Edit Notes</button>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 min-h-[200px]">
                        <p class="text-gray-600 italic">
                            {{ $session->notes ?? 'Session notes will appear here after the meeting. You can add your own notes during or after the session.' }}
                        </p>
                    </div>

                    <div class="text-sm text-gray-500">
                        <p>💡 Tip: Take notes during the session to track key insights and action items.</p>
                    </div>
                </div>
            </div>

            <!-- Action Items Tab -->
            <div id="actions-content" class="tab-content hidden">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Action Items</h3>
                        <button class="text-purple-600 hover:text-purple-700 text-sm font-medium">Add Action Item</button>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-lg">
                            <input type="checkbox" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Research market competitors</p>
                                <p class="text-sm text-gray-600">Due: {{ now()->addDays(7)->format('M d, Y') }}</p>
                            </div>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">In Progress</span>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-lg">
                            <input type="checkbox" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Update business plan financials</p>
                                <p class="text-sm text-gray-600">Due: {{ now()->addDays(14)->format('M d, Y') }}</p>
                            </div>
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Pending</span>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-lg">
                            <input type="checkbox" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500" checked>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 line-through">Schedule investor meetings</p>
                                <p class="text-sm text-gray-600">Completed: {{ now()->subDays(3)->format('M d, Y') }}</p>
                            </div>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Actions -->
    <div class="mt-6 flex gap-3">
        <button class="bg-purple-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-purple-700 transition">
            <i class="bi bi-camera-video mr-2"></i>Join Session
        </button>
        <button class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-200 transition">
            <i class="bi bi-calendar-plus mr-2"></i>Reschedule
        </button>
        <button class="bg-red-100 text-red-700 px-6 py-2 rounded-lg font-medium hover:bg-red-200 transition">
            <i class="bi bi-x-circle mr-2"></i>Cancel Session
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('[id$="-tab"]');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active state from all tabs
            tabs.forEach(t => {
                t.classList.remove('border-purple-500', 'text-purple-600');
                t.classList.add('border-transparent', 'text-gray-500');
            });

            // Hide all content
            contents.forEach(content => {
                content.classList.add('hidden');
            });

            // Activate clicked tab
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-purple-500', 'text-purple-600');

            // Show corresponding content
            const contentId = this.id.replace('-tab', '-content');
            document.getElementById(contentId).classList.remove('hidden');
        });
    });
});
</script>
@endsection 