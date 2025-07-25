<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Ideas Bank (Admin)</h1>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach(\App\Models\Idea::withCount('comments')->with('user')->latest()->get() as $idea)
        <div class="bg-white rounded-xl shadow p-5 flex flex-col">
            <div class="flex items-center gap-2 mb-2">
                <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-1 rounded">{{ ucfirst($idea->status) }}</span>
            </div>
            <h3 class="font-bold text-lg mb-1">{{ $idea->title }}</h3>
            <p class="text-gray-600 text-sm mb-2">{{ Str::limit($idea->description, 80) }}</p>
            <div class="flex items-center gap-2 mb-2">
                <span class="text-xs text-gray-700">{{ $idea->user->name ?? 'Unknown' }}</span>
                <span class="text-xs text-gray-400">{{ $idea->created_at->format('Y-m-d') }}</span>
            </div>
            <div class="flex items-center gap-4 text-xs text-gray-500 mb-2">
                <span><i class="bi bi-arrow-up"></i> {{ $idea->upvotes }}</span>
                <span><i class="bi bi-arrow-down"></i> {{ $idea->downvotes }}</span>
                <span><i class="bi bi-chat"></i> {{ $idea->comments_count }}</span>
            </div>
            <div class="flex gap-2 mt-2">
                <a href="{{ route('ideas.show', $idea) }}" class="px-3 py-1 bg-blue-100 text-blue-800 rounded text-xs">View</a>
                @if($idea->status !== 'approved')
                    <form action="{{ route('admin.ideas.approve', $idea) }}" method="POST" class="inline-block">
                        @csrf
                        <button class="px-3 py-1 bg-green-100 text-green-800 rounded text-xs">Approve</button>
                    </form>
                @endif
                @if($idea->status !== 'rejected')
                    <form action="{{ route('admin.ideas.reject', $idea) }}" method="POST" class="inline-block">
                        @csrf
                        <button class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Reject</button>
                    </form>
                @endif
                <form action="{{ route('ideas.destroy', $idea) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this idea?');">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-1 bg-red-100 text-red-800 rounded text-xs">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
</div> 