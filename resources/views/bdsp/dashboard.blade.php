@extends('layouts.bdsp')

@section('content')
    {{-- Welcome Banner --}}
    @include('bdsp.partials.welcome-banner')

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 my-6">
        @include('bdsp.partials.stats-cards')
    </div>

    {{-- My Mentees & Upcoming Sessions --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 my-6">
        @include('bdsp.partials.my-mentees')
        @include('bdsp.partials.upcoming-sessions')
    </div>

    {{-- Recent Feedback --}}
    @include('bdsp.partials.recent-feedback')

    {{-- Resource Uploads --}}
    @include('bdsp.partials.resource-uploads')

    {{-- Reports/Analytics --}}
    @include('bdsp.partials.reports-summary')
@endsection 