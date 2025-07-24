@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Post a New Idea</h1>
    <form action="{{ route('ideas.store') }}" method="POST" class="bg-white rounded-xl shadow p-6">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Title</label>
            <input type="text" name="title" class="form-input w-full rounded-md" value="{{ old('title') }}" required>
            @error('title')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Description</label>
            <textarea name="description" class="form-input w-full rounded-md" rows="5" required>{{ old('description') }}</textarea>
            @error('description')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('ideas.index') }}" class="px-4 py-2 rounded-lg font-semibold border border-gray-300 text-gray-700 hover:bg-gray-100">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded-lg font-semibold bg-purple-600 text-white hover:bg-purple-700">Post Idea</button>
        </div>
    </form>
</div>
@endsection 