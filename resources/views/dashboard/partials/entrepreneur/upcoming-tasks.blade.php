<div class="bg-white rounded-2xl shadow p-6 mb-6">
    <h3 class="text-lg font-bold mb-4">Upcoming Tasks</h3>
    @foreach($tasks as $task)
        <div class="bg-white rounded shadow p-4 mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <div class="font-semibold text-gray-900">{{ $task->title }}</div>
                <div class="text-xs text-gray-500">Due: {{ $task->due_date->format('Y-m-d') }}</div>
            </div>
            @php $submission = $task->submissions()->where('user_id', auth()->id())->latest()->first(); @endphp
            <div class="mt-2 md:mt-0 flex gap-2 items-center">
                @if(!$submission)
                    <a href="#task-submit-{{ $task->id }}" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">Submit</a>
                @else
                    <a href="{{ route('submissions.show', $submission) }}" class="text-green-700 font-semibold hover:underline text-xs">View Submission</a>
                    <span class="ml-2 px-2 py-1 rounded text-xs {{ $submission->status === 'reviewed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($submission->status) }}</span>
                @endif
            </div>
        </div>
    @endforeach
</div> 