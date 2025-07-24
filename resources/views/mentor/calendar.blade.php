@extends('layouts.mentor')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">My Calendar</h1>
        @if($sessions->count())
            <ul>
                @foreach($sessions as $session)
                    <li class="mb-4 border-b pb-2">
                        <div class="font-semibold">
                            With: 
                            @php
                                $other = $session->scheduled_by == auth()->id() ? $session->scheduledFor : $session->scheduledBy;
                            @endphp
                            <img src="{{ $other->profile_photo_url ?? asset('images/avatar-placeholder.png') }}" alt="Participant" class="h-10 w-10 rounded-full object-cover mr-3">
                            {{ $other->name ?? 'N/A' }}
                        </div>
                        <div class="text-gray-600 text-sm">
                            {{ $session->date_time->format('D, M j, Y h:i A') }}<br>
                            Status: {{ ucfirst($session->status) }}
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600">You have no upcoming sessions.</p>
        @endif
        <a href="{{ route('mentor.dashboard') }}" class="btn-primary text-white px-4 py-2 rounded-lg mt-6 inline-block">Back to Dashboard</a>
    </div>
@endsection 