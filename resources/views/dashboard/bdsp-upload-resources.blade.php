@extends('layouts.bdsp')
@section('title', 'Upload Resources')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <h1 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-8">Resource Management</h1>
    <div class="bg-white rounded-xl shadow p-8 mb-8">
        <h2 class="text-xl font-semibold mb-6">Upload New Resource</h2>
        <form action="{{ route('bdsp.resources.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Resource Name:</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" placeholder="Enter resource name" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Description:</label>
                <textarea name="description" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" rows="3" placeholder="Enter resource description"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Select File:</label>
                <input type="file" name="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#b81d8f] file:text-white hover:file:bg-[#a01a7d]" required>
            </div>
            <button type="submit" class="bg-[#b81d8f] text-white px-6 py-2 rounded-lg font-semibold shadow hover:bg-[#a01a7d] transition">Upload Resource</button>
        </form>
    </div>
    <div class="bg-white rounded-xl shadow p-8">
        <h2 class="text-xl font-semibold mb-4">Uploaded Resources</h2>
        @if($resources->isEmpty())
            <div class="text-gray-500 text-center py-8">No resources uploaded yet.</div>
        @else
            <ul>
                @foreach($resources as $resource)
                    <li class="border-b py-4">
                        <div class="font-medium">{{ $resource->name }}</div>
                        <div class="text-sm text-gray-600">{{ $resource->description }}</div>
                        <div class="text-sm">Status: {{ $resource->is_approved ? 'Approved' : 'Pending' }}</div>
                        <a href="{{ Storage::url($resource->file_path) }}" class="text-[#b81d8f] hover:underline">Download</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection