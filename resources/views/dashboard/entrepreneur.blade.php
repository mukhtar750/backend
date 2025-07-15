@extends('layouts.entrepreneur')
@section('title', 'Entrepreneur Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    @include('dashboard.partials.entrepreneur.welcome-banner')
    @include('dashboard.partials.entrepreneur.program-journey')
    @include('dashboard.partials.entrepreneur.stats-cards')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            @include('dashboard.partials.entrepreneur.learning-progress')
        </div>
        <div>
            @include('dashboard.partials.entrepreneur.upcoming-tasks')
            @include('dashboard.partials.entrepreneur.mentorship', ['pairings' => $pairings])
        </div>
    </div>
    @include('dashboard.partials.entrepreneur.recent-achievements')
    @include('dashboard.partials.entrepreneur.learning-resources')
</div>
<div x-data="{ showFeedback: false }">
    <button @click="showFeedback = true" class="fixed bottom-8 right-8 z-50 bg-[#b81d8f] hover:bg-[#a259e6] text-white px-6 py-3 rounded-full shadow-lg flex items-center gap-2 font-semibold text-base">
        <i class="bi bi-chat-dots"></i> Submit Feedback
    </button>
    <!-- Feedback Modal (placeholder) -->
    <div x-show="showFeedback" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" style="display: none;">
        <div class="bg-white rounded-2xl p-8 w-full max-w-md shadow-xl relative">
            <button @click="showFeedback = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700"><i class="bi bi-x-lg"></i></button>
            <h3 class="text-xl font-bold mb-4">Submit Feedback</h3>
            <textarea class="w-full border rounded-lg p-3 mb-4" rows="4" placeholder="Your feedback..."></textarea>
            <button class="bg-[#b81d8f] hover:bg-[#a259e6] text-white px-6 py-2 rounded-lg font-semibold w-full">Send</button>
        </div>
    </div>
</div>
@endsection 