@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, {{ Auth::user()->name }} (Mentee)</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Your Mentor</h2>
            <p class="text-2xl font-bold text-[#b81d8f]">Not assigned</p>
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