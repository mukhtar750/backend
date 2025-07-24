@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-xl shadow p-6 mb-6">
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
            @endif
            @if(auth()->id() === $idea->user_id || (auth()->user() && auth()->user()->isAdmin()))
                <form action="{{ route('ideas.destroy', $idea) }}" method="POST" class="inline-block ml-auto" onsubmit="return confirm('Delete this idea?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs">Delete</button>
                </form>
            @endif
        </div>
        <h1 class="text-2xl font-bold mb-2 text-gray-900">{{ $idea->title }}</h1>
        <p class="text-gray-700 mb-4">{{ $idea->description }}</p>
        <div class="flex items-center gap-4 text-xs text-gray-500 mb-2">
            <span>By {{ $idea->user->name ?? 'Unknown' }}</span>
            <span>{{ $idea->created_at->diffForHumans() }}</span>
        </div>
        <div class="flex items-center gap-4 mt-2">
            <form action="{{ route('ideas.votes.store', $idea) }}" method="POST" class="inline-block">
                @csrf
                <input type="hidden" name="type" value="up">
                <button type="submit" class="text-green-600 hover:text-green-800"><i class="bi bi-arrow-up"></i> Upvote ({{ $idea->upvotes }})</button>
            </form>
            <form action="{{ route('ideas.votes.store', $idea) }}" method="POST" class="inline-block">
                @csrf
                <input type="hidden" name="type" value="down">
                <button type="submit" class="text-red-600 hover:text-red-800"><i class="bi bi-arrow-down"></i> Downvote ({{ $idea->downvotes }})</button>
            </form>
        </div>
        @if(auth()->user() && auth()->user()->role === 'entrepreneur')
            <div class="mt-4">
                <a href="#" class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-yellow-600 transition">Pitch This Idea</a>
            </div>
        @endif
    </div>
    @if($idea->status === 'approved' || (auth()->check() && (auth()->user()->isAdmin() || auth()->id() === $idea->user_id)))
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-lg font-bold mb-4">Comments</h2>
        @foreach($idea->comments as $comment)
            <div class="mb-4 border-b pb-2">
                <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <span>{{ $comment->user->name ?? 'Unknown' }}</span>
                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                    @if(auth()->id() === $comment->user_id || (auth()->check() && auth()->user()->isAdmin()))
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline-block ml-auto" onsubmit="return confirm('Delete this comment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs">Delete</button>
                        </form>
                    @endif
                </div>
                <div class="text-gray-800">{{ $comment->content }}</div>
            </div>
        @endforeach
        <form action="{{ route('ideas.comments.store', $idea) }}" method="POST" class="mt-6">
            @csrf
            <textarea name="content" class="form-input w-full rounded-md mb-2" rows="3" placeholder="Add a comment..." required></textarea>
            @error('content')<div class="text-red-600 text-xs mb-2">{{ $message }}</div>@enderror
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 rounded-lg font-semibold bg-purple-600 text-white hover:bg-purple-700">Post Comment</button>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection 