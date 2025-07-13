@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-end mb-4">
        <a href="{{ route('messages.index') }}" class="bg-[#b81d8f] text-white px-5 py-2 rounded-lg shadow hover:bg-[#a01a7d] transition flex items-center gap-2">
            <i class="bi bi-chat-dots"></i> Messages
        </a>
    </div>
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, {{ Auth::user()->name }} (Mentor)</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Your Mentees</h2>
            <p class="text-2xl font-bold text-[#b81d8f]">0</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Upcoming Sessions</h2>
            <p class="text-2xl font-bold text-[#b81d8f]">0</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Profile Status</h2>
            <p class="text-2xl font-bold text-[#b81d8f]">Active</p>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Activity</h2>
        <ul class="list-disc pl-6 text-gray-600">
            <li>No recent activity yet.</li>
        </ul>
    </div>
</div>
@endsection 