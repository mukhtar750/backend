@extends('layouts.bdsp')
@section('content')
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
            @if(session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif
            @if($resources->isEmpty())
                <div class="text-center text-gray-400 py-8">No resources uploaded yet.</div>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Description</th>
                            <th class="px-4 py-2 text-left">File</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resources as $resource)
                        <tr>
                            <td class="px-4 py-2">{{ $resource->name }}</td>
                            <td class="px-4 py-2">{{ $resource->description }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ asset('storage/' . $resource->file_path) }}" target="_blank" class="text-purple-600 underline">Download</a>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('bdsp.resources.edit', $resource) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                                <form action="{{ route('bdsp.resources.destroy', $resource) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Are you sure you want to delete this resource?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection 