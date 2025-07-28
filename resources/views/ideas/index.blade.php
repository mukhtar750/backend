@php
    $role = auth()->check() ? auth()->user()->role : null;
    $layout = match($role) {
        'mentor' => 'layouts.mentor',
        'entrepreneur' => 'layouts.entrepreneur',
        'mentee' => 'layouts.mentee',
        'investor' => 'layouts.investor',
        'bdsp' => 'layouts.bdsp',
        default => 'layouts.app',
    };
@endphp
@extends($layout)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Ideas Bank</h1>
        <a href="{{ route('ideas.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-purple-700 transition">+ Post New Idea</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($ideas as $idea)
            <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-1 rounded">{{ ucfirst(str_replace('_', ' ', $idea->status)) }}</span>
                    @if($idea->urgency_level)
                        <span class="bg-{{ $idea->urgency_level === 'high' ? 'red' : ($idea->urgency_level === 'medium' ? 'yellow' : 'green') }}-100 text-{{ $idea->urgency_level === 'high' ? 'red' : ($idea->urgency_level === 'medium' ? 'yellow' : 'green') }}-800 text-xs font-semibold px-2 py-1 rounded">{{ ucfirst($idea->urgency_level) }}</span>
                    @endif
                    @if(auth()->check() && auth()->user()->isAdmin())
                        @if($idea->status !== 'approved')
                            <form action="{{ route('admin.ideas.approve', $idea) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                <button class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Approve</button>
                            </form>
                        @endif
                        @if($idea->status !== 'rejected')
                            <form action="{{ route('admin.ideas.reject', $idea) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                <button class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Reject</button>
                            </form>
                        @endif
                        <form action="{{ route('ideas.destroy', $idea) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Delete this idea?');">
                            @csrf
                            @method('DELETE')
                            <button class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Delete</button>
                        </form>
                    @endif
                </div>
                <a href="{{ route('ideas.show', $idea) }}">
                    <h2 class="font-bold text-lg mb-1 text-gray-900">{{ $idea->title }}</h2>
                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($idea->problem_statement ?? $idea->description, 80) }}</p>
                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                        <span>By {{ $idea->user->name ?? 'Unknown' }}</span>
                    </div>
                    <div class="flex items-center gap-4 text-xs text-gray-500">
                        @if(auth()->check())
                            @php
                                $userVote = $idea->votes()->where('user_id', auth()->id())->first();
                            @endphp
                            <div class="flex items-center gap-1">
                                <form action="{{ route('ideas.votes.store', $idea) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="type" value="up">
                                    <button type="submit" class="flex items-center gap-1 px-1 py-1 rounded text-xs {{ $userVote && $userVote->type === 'up' ? 'bg-green-100 text-green-800' : 'hover:bg-gray-100' }}">
                                        <i class="bi bi-arrow-up"></i> {{ $idea->upvotes }}
                                    </button>
                                </form>
                                
                                <form action="{{ route('ideas.votes.store', $idea) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="type" value="down">
                                    <button type="submit" class="flex items-center gap-1 px-1 py-1 rounded text-xs {{ $userVote && $userVote->type === 'down' ? 'bg-red-100 text-red-800' : 'hover:bg-gray-100' }}">
                                        <i class="bi bi-arrow-down"></i> {{ $idea->downvotes }}
                                    </button>
                                </form>
                            </div>
                        @else
                            <span><i class="bi bi-arrow-up"></i> {{ $idea->upvotes }}</span>
                            <span><i class="bi bi-arrow-down"></i> {{ $idea->downvotes }}</span>
                        @endif
                        <span><i class="bi bi-hand-thumbs-up"></i> {{ $idea->interest_count }}</span>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-span-3 text-center text-gray-400 py-12">
                <i class="bi bi-inbox" style="font-size:2rem;"></i>
                <div class="mt-2">No ideas posted yet.</div>
            </div>
        @endforelse
    </div>
    <div class="mt-8">{{ $ideas->links() }}</div>
</div>
@endsection 