@extends('layouts.mentor')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow">
        <img src="{{ $mentee->profile_photo_url ?? asset('images/avatar-placeholder.png') }}" alt="Mentee" class="h-20 w-20 rounded-full object-cover mb-4">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">{{ $mentee->name }}</h1>
        <p class="mb-2 text-gray-600">Email: {{ $mentee->email }}</p>
        <p class="mb-2 text-gray-600">Role: {{ $mentee->role }}</p>
        <a href="{{ route('mentor.dashboard') }}" class="btn-primary text-white px-4 py-2 rounded-lg">Back to Dashboard</a>
    </div>
@endsection 