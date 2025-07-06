@extends('layouts.bdsp')
@section('title', 'Schedule Session')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8">Schedule New Session</h1>
    <div class="bg-white rounded-xl shadow p-8 mb-8">
        <form>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Session Title:</label>
                <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" placeholder="Enter session title">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Session Link:</label>
                <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" placeholder="Enter session link">
            </div>
            <div class="mb-4 flex flex-col md:flex-row md:space-x-4">
                <div class="flex-1 mb-4 md:mb-0">
                    <label class="block text-gray-700 font-medium mb-2">Time:</label>
                    <input type="time" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]">
                </div>
                <div class="flex-1">
                    <label class="block text-gray-700 font-medium mb-2">Day:</label>
                    <input type="date" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]">
                </div>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold shadow hover:bg-blue-700 transition">Schedule Session</button>
        </form>
    </div>
    <div class="bg-white rounded-xl shadow p-8">
        <h2 class="text-xl font-semibold mb-4">Scheduled Sessions</h2>
        <div class="text-gray-500 text-center py-8">No sessions scheduled yet.</div>
    </div>
</div>
@endsection 