@extends('layouts.' . (auth()->check() ? auth()->user()->role : 'app'))

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Assign New Task</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold mb-2">Assign To</label>
            <div class="space-y-2 max-h-60 overflow-y-auto p-2 border rounded">
                @foreach($pairedUsers as $user)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="assignees[]" value="{{ $user->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span>{{ $user->name }} <span class="text-gray-500 text-sm">(@displayRole($user->role))</span></span>
                    </label>
                @endforeach
            </div>
            @error('assignees')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Title</label>
            <input type="text" name="title" class="form-input w-full rounded" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Description</label>
            <textarea name="description" class="form-input w-full rounded" rows="3" required></textarea>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Due Date</label>
            <input type="date" name="due_date" class="form-input w-full rounded" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Priority</label>
            <select name="priority" class="form-input w-full rounded" required>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
                <option value="high">High</option>
            </select>
        </div>
        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700">Assign Task</button>
    </form>
</div>
@endsection