@extends('layouts.' . auth()->user()->role)

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Task Submission</h1>
    <div class="mb-4">
        <strong>Task:</strong> {{ $submission->task->title }}<br>
        <strong>Submitted by:</strong> {{ $submission->user->name }}<br>
        <strong>Submitted at:</strong> {{ $submission->submitted_at ? $submission->submitted_at->format('Y-m-d H:i') : 'N/A' }}
    </div>
    @if($submission->file_path)
        <div class="mb-4">
            <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="text-blue-600 hover:underline">Download Submission File</a>
        </div>
    @endif
    @if($submission->notes)
        <div class="mb-4">
            <strong>Notes:</strong>
            <div class="bg-gray-100 rounded p-3 mt-1">{{ $submission->notes }}</div>
        </div>
    @endif
    <div class="mb-4">
        <strong>Status:</strong> <span class="px-2 py-1 rounded text-xs {{ $submission->status === 'reviewed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($submission->status) }}</span>
    </div>
    @if($submission->status === 'reviewed')
        <div class="mb-4">
            <strong>Grade:</strong> {{ $submission->grade ?? 'N/A' }}<br>
            <strong>Feedback:</strong>
            <div class="bg-gray-50 rounded p-3 mt-1">{{ $submission->feedback ?? 'No feedback.' }}</div>
        </div>
    @endif
    @if(auth()->id() === $submission->task->assigner_id && $submission->status !== 'reviewed')
        <form action="{{ route('submissions.review', $submission) }}" method="POST" class="mt-6 bg-gray-50 p-4 rounded">
            @csrf
            <h2 class="text-lg font-semibold mb-2">Review & Grade</h2>
            <div class="mb-3">
                <label class="block font-semibold mb-1">Grade</label>
                <input type="text" name="grade" class="form-input w-full rounded" value="{{ old('grade', $submission->grade) }}" placeholder="e.g. A, B+, 90%">
            </div>
            <div class="mb-3">
                <label class="block font-semibold mb-1">Feedback</label>
                <textarea name="feedback" class="form-input w-full rounded" rows="3" placeholder="Feedback for the submission">{{ old('feedback', $submission->feedback) }}</textarea>
            </div>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Submit Review</button>
        </form>
    @endif
</div>
@endsection 