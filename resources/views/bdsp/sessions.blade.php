@extends('layouts.bdsp')
@section('content')
<div class="max-w-3xl mx-auto mt-8">
    <div class="bg-white rounded-2xl shadow p-8 mb-8">
        <h2 class="text-2xl font-bold mb-6">Schedule New Session</h2>
        <form>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Session Title:</label>
                <input type="text" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400" placeholder="Enter session title">
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Session Link:</label>
                <input type="text" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400" placeholder="Enter session link">
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Time:</label>
                <input type="time" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-6">
                <label class="block font-semibold mb-1">Day:</label>
                <input type="date" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400" placeholder="dd/mm/yyyy">
            </div>
            <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition">Schedule Session</button>
        </form>
    </div>
    <div>
        <h3 class="text-xl font-semibold mb-4">Scheduled Sessions</h3>
        <div class="bg-white rounded-xl p-6 border text-center text-gray-400">No sessions scheduled yet.</div>
    </div>
</div>
@endsection 