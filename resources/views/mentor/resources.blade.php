@extends('layouts.mentor')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">My Resources</h1>
        <p class="text-gray-600">This is a placeholder for the mentor's resources page. You can add resource upload and download features here later.</p>
        <a href="{{ route('mentor.dashboard') }}" class="btn-primary text-white px-4 py-2 rounded-lg mt-6 inline-block">Back to Dashboard</a>
    </div>
@endsection 