@extends('layouts.bdsp')
@section('content')

<!-- SUPER SIMPLE TEST -->
<div style="background: red; color: white; padding: 20px; margin: 20px; text-align: center;">
    <h1>TEST AREA</h1>
    <p>If you can see this red box, the view is working.</p>
    <a href="{{ route('bdsp.resources.sharing', 1) }}" style="background: green; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; margin: 10px;">SHARE BUTTON TEST</a>
</div>

<div class="max-w-4xl mx-auto mt-6">
    <div class="bg-white rounded-2xl shadow p-8">
        <h2 class="text-2xl md:text-3xl font-bold text-center mb-8">Resource Management</h2>
        <div class="bg-gray-50 rounded-xl p-6 mb-8 border">
            <h3 class="text-xl font-semibold mb-4">Upload New Resource</h3>
            <form action="{{ route('bdsp.resources.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Resource Name:</label>
                    <input type="text" name="name" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-400" placeholder="Enter resource name" required>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Description:</label>
                    <textarea name="description" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-400" rows="3" placeholder="Enter resource description"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Select File:</label>
                    <input type="file" name="file" class="block w-full text-purple-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100" required>
                </div>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-2 rounded-lg transition">Upload Resource</button>
            </form>
        </div>
        <div class="bg-gray-50 rounded-xl p-6 border">
            <h3 class="text-xl font-semibold mb-4">Uploaded Resources</h3>
            
            <!-- TEST BUTTON - This should be visible -->
            <div class="mb-4 p-4 bg-red-100 border border-red-400 rounded">
                <strong>TEST: This Share button should be visible:</strong>
                <a href="{{ route('bdsp.resources.sharing', 1) }}" class="ml-2 inline-block bg-green-500 text-white px-4 py-2 rounded font-bold">SHARE TEST</a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif
            @if($resources->isEmpty())
                <div class="text-center text-gray-400 py-8">No resources uploaded yet.</div>
            @else
                <!-- SIMPLE DIV-BASED LAYOUT -->
                <div class="space-y-4">
                    @foreach($resources as $resource)
                        <div class="border border-gray-200 rounded-lg p-4 bg-white">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                                <!-- Name -->
                                <div>
                                    <div class="font-medium text-gray-900">{{ $resource->name }}</div>
                                </div>
                                
                                <!-- Description -->
                                <div>
                                    <div class="text-sm text-gray-600">{{ $resource->description }}</div>
                                </div>
                                
                                <!-- Status -->
                                <div>
                                    @if($resource->is_approved)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @endif
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex space-x-2">
                                    <a href="{{ asset('storage/' . $resource->file_path) }}" target="_blank" class="text-purple-600 hover:text-purple-800 underline text-sm">Download</a>
                                    <a href="{{ route('bdsp.resources.edit', $resource) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                                    <a href="{{ route('bdsp.resources.sharing', $resource) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm font-bold">Share</a>
                                    <form action="{{ route('bdsp.resources.destroy', $resource) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this resource?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 