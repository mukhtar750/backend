@extends('layouts.mentor')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">My Mentees</h1>
        @if($mentees->count())
            <ul>
                @foreach($mentees as $mentee)
                    <li class="mb-4 border-b pb-2">
                        <div class="font-semibold">{{ $mentee->name }}</div>
                        <div class="text-gray-600 text-sm">{{ $mentee->email }}</div>
                        <a href="{{ route('mentor.mentees.show', $mentee->id) }}" class="text-indigo-900 hover:underline text-sm">View Profile</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600">You have no assigned mentees yet.</p>
        @endif
        <a href="{{ route('mentor.dashboard') }}" class="btn-primary text-white px-4 py-2 rounded-lg mt-6 inline-block">Back to Dashboard</a>
    </div>
@endsection 