@extends('layouts.investor')
@section('title', 'Pitch Events')
@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2"><i class="bi bi-calendar-event text-[#b81d8f]"></i> Pitch Events</h2>
    <!-- Optional: Add search/filter UI here if you want to implement it later -->
</div>
<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            @include('partials.pitch_event_card', ['event' => $event])
        @empty
            <div class="flex flex-col items-center justify-center py-16">
                <i class="bi bi-emoji-frown text-5xl text-gray-300 mb-4"></i>
                <div class="text-lg text-gray-500 mb-2">No events found.</div>
                <div class="text-sm text-gray-400">Try adjusting your search or filters.</div>
            </div>
        @endforelse
    </div>
    <div class="mt-6">
        {{ $events->links() }}
    </div>
</div>
@endsection 