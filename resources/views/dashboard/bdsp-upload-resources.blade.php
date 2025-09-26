@extends('layouts.bdsp')
@section('title', 'Upload Resources')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <h1 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-8">Resource Management</h1>
    
    <!-- Info message about approval process -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    <strong>Note:</strong> Resources must be approved by an administrator before they can be shared with mentees. 
                    You can still edit and manage unapproved resources while waiting for approval.
                </p>
            </div>
        </div>
    </div>
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
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($resources as $resource)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $resource->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $resource->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($resource->is_approved)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">✓ Approved</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">⏳ Pending Approval</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="{{ route('bdsp.resources.download', $resource) }}" class="text-[#b81d8f] hover:underline">Download</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('bdsp.resources.edit', $resource) }}" class="text-blue-600 hover:text-blue-900 font-medium">Edit</a>
                                    
                                    @if($resource->is_approved)
                                        <a href="{{ route('bdsp.resources.sharing', $resource) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm font-bold">Share</a>
                                    @else
                                        <span class="bg-gray-300 text-gray-500 px-3 py-1 rounded text-sm font-bold cursor-not-allowed" title="Resource needs approval before sharing">Share</span>
                                    @endif
                                    
                                    <form action="{{ route('bdsp.resources.destroy', $resource) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this resource?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection