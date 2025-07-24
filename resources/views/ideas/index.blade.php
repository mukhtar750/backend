@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Ideas Bank</h1>
        <a href="{{ route('ideas.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-purple-700 transition">+ Post New Idea</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($ideas as $idea)
            <div class="block bg-white rounded-xl shadow p-5 hover:shadow-lg transition">
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-1 rounded">{{ ucfirst($idea->status) }}</span>
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
                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($idea->description, 80) }}</p>
                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                        <span>By {{ $idea->user->name ?? 'Unknown' }}</span>
                    </div>
                    <div class="flex items-center gap-4 text-xs text-gray-500">
                        <span><i class="bi bi-arrow-up"></i> {{ $idea->upvotes }}</span>
                        <span><i class="bi bi-arrow-down"></i> {{ $idea->downvotes }}</span>
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