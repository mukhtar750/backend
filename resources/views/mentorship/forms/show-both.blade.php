@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">{{ $form->title }}</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <h2 class="text-xl font-semibold mb-2">Mentor's Agreement</h2>
            @if($mentorSubmission)
                @include('mentorship.forms.partials.submission', ['submission' => $mentorSubmission])
            @else
                <p class="text-gray-500">Mentor has not filled this agreement yet.</p>
            @endif
        </div>
        <div>
            <h2 class="text-xl font-semibold mb-2">Mentee's Agreement</h2>
            @if($menteeSubmission)
                @include('mentorship.forms.partials.submission', ['submission' => $menteeSubmission])
            @else
                <p class="text-gray-500">Mentee has not filled this agreement yet.</p>
            @endif
        </div>
    </div>
    <div class="flex justify-end mt-8">
        <a href="{{ route('mentorship.forms.dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Back to Dashboard</a>
    </div>
</div>
@endsection 