@extends('layouts.bdsp')
@section('content')
<div class="max-w-4xl mx-auto mt-6">
    <div class="bg-white rounded-2xl shadow p-8">
        <h2 class="text-2xl md:text-3xl font-bold text-center mb-8">Resource Management</h2>
        <div class="bg-gray-50 rounded-xl p-6 mb-8 border">
            <h3 class="text-xl font-semibold mb-4">Upload New Resource</h3>
            <form>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Resource Name:</label>
                    <input type="text" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-400" placeholder="Enter resource name">
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Description:</label>
                    <textarea class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-400" rows="3" placeholder="Enter resource description"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Select File:</label>
                    <input type="file" class="block w-full text-purple-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                </div>
                <button type="button" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-2 rounded-lg transition">Upload Resource</button>
            </form>
        </div>
        <div class="bg-gray-50 rounded-xl p-6 border">
            <h3 class="text-xl font-semibold mb-4">Uploaded Resources</h3>
            <div class="text-center text-gray-400 py-8">No resources uploaded yet.</div>
        </div>
    </div>
</div>
@endsection 