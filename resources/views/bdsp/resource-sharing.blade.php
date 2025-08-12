@extends('layouts.bdsp')
@section('title', 'Share Resource')

@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Share Resource</h1>
                <p class="text-gray-600 mt-1">Share "{{ $resource->name }}" with your mentees</p>
            </div>
            <a href="{{ route('bdsp.resources.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                ← Back to Resources
            </a>
        </div>

        <!-- Resource Info -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="flex items-center gap-3">
                <i class="bi bi-file-earmark-text text-2xl text-blue-500"></i>
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $resource->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $resource->description }}</p>
                    <p class="text-xs text-gray-500">{{ strtoupper($resource->file_type) }} • {{ number_format($resource->file_size / 1024 / 1024, 1) }} MB</p>
                </div>
            </div>
        </div>

        <!-- Share Form -->
        <form action="{{ route('bdsp.resources.share', $resource) }}" method="POST" class="mb-8">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Mentees to Share With</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-64 overflow-y-auto border rounded-lg p-3">
                    @forelse($entrepreneurs as $entrepreneur)
                        <label class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" name="entrepreneur_ids[]" value="{{ $entrepreneur->id }}" 
                                   class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                                   @if($resource->isSharedWith($entrepreneur->id)) checked disabled @endif>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">{{ $entrepreneur->name }}</div>
                                <div class="text-sm text-gray-500">{{ $entrepreneur->business_name ?? 'No business name' }}</div>
                            </div>
                            @if($resource->isSharedWith($entrepreneur->id))
                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Already Shared</span>
                            @endif
                        </label>
                    @empty
                        <div class="col-span-2 text-center text-gray-500 py-4">
                            <i class="bi bi-people text-2xl mb-2"></i>
                            <p>No mentees found. You need to be paired with entrepreneurs first.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mb-6">
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message (Optional)</label>
                <textarea name="message" id="message" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none"
                          placeholder="Add a personal message for your mentees..."></textarea>
                <p class="text-xs text-gray-500 mt-1">This message will be shown to mentees when they see the shared resource.</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" 
                        class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium transition"
                        @if($entrepreneurs->isEmpty()) disabled @endif>
                    <i class="bi bi-share mr-2"></i>Share Resource
                </button>
                <a href="{{ route('bdsp.resources.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium transition">
                    Cancel
                </a>
            </div>
        </form>

        <!-- Current Shares -->
        @if($currentShares->count() > 0)
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Currently Shared With</h3>
                <div class="space-y-3">
                    @foreach($currentShares as $share)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="bi bi-person text-purple-600"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $share->sharedWith->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $share->sharedWith->business_name ?? 'No business name' }}</div>
                                    @if($share->message)
                                        <div class="text-xs text-gray-600 mt-1">"{{ $share->message }}"</div>
                                    @endif
                                    <div class="text-xs text-gray-400">Shared {{ $share->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <form action="{{ route('bdsp.resources.unshare', $resource) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="entrepreneur_id" value="{{ $share->shared_with }}">
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800 text-sm font-medium"
                                        onclick="return confirm('Remove sharing with {{ $share->sharedWith->name }}?')">
                                    Remove
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
