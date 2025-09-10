@extends('layouts.bdsp')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Assigned Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-purple-700 transition">+ Assign New Task</a>
    </div>
    @forelse($tasks as $task)
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <div class="flex justify-between items-center mb-2">
                <div>
                    <h2 class="font-bold text-lg">{{ $task->title }}</h2>
                    <div class="text-xs text-gray-500">Due: {{ $task->due_date->format('Y-m-d') }}</div>
                </div>
                <span class="px-2 py-1 rounded text-xs {{ $task->getStatusClass() }}">{{ $task->getStatusLabel() }}</span>
            </div>
            <div class="mb-2 text-gray-700">{{ $task->description }}</div>
            <div class="text-xs text-gray-500">Assigned to: {{ $task->assignee->name ?? 'N/A' }}</div>
            @if($task->submissions->count())
                <div class="mt-4">
                    <h3 class="font-semibold mb-2">Submissions</h3>
                    @foreach($task->submissions as $submission)
                        <div class="mb-2 flex items-center gap-2">
                            <a href="{{ route('submissions.show', $submission) }}" class="text-blue-600 hover:underline">
                                View Submission by {{ $submission->user->name }}
                            </a>
                            <span class="ml-2 px-2 py-1 rounded text-xs {{ $submission->status === 'reviewed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($submission->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @empty
        <div class="bg-white rounded-xl shadow p-6 text-center text-gray-400">
            <i class="bi bi-inbox" style="font-size:2rem;"></i>
            <div class="mt-2">No tasks assigned yet.</div>
        </div>
    @endforelse
</div>
@endsection