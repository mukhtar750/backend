@extends('layouts.' . auth()->user()->role)

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Assign New Task</h1>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold mb-1">Assign To</label>
            <select name="assignee_id" class="form-input w-full rounded" required>
                <option value="">Select user...</option>
                @foreach($pairedUsers as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                @endforeach
            </select>
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