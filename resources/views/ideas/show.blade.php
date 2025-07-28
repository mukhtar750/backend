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
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex items-center gap-2 mb-4">
            <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-1 rounded">{{ ucfirst(str_replace('_', ' ', $idea->status)) }}</span>
            @if($idea->urgency_level)
                <span class="bg-{{ $idea->urgency_level === 'high' ? 'red' : ($idea->urgency_level === 'medium' ? 'yellow' : 'green') }}-100 text-{{ $idea->urgency_level === 'high' ? 'red' : ($idea->urgency_level === 'medium' ? 'yellow' : 'green') }}-800 text-xs font-semibold px-2 py-1 rounded">{{ ucfirst($idea->urgency_level) }} Urgency</span>
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
            @endif
            @if(auth()->id() === $idea->user_id || (auth()->user() && auth()->user()->isAdmin()))
                <form action="{{ route('ideas.destroy', $idea) }}" method="POST" class="inline-block ml-auto" onsubmit="return confirm('Delete this idea?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs">Delete</button>
                </form>
            @endif
        </div>
        
        <h1 class="text-2xl font-bold mb-4 text-gray-900">{{ $idea->title }}</h1>
        
        <!-- Enhanced Idea Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="font-semibold text-gray-800 mb-2">Problem Statement</h3>
                <p class="text-gray-700 mb-4">{{ $idea->problem_statement }}</p>
                
                @if($idea->proposed_solution)
                    <h3 class="font-semibold text-gray-800 mb-2">Proposed Solution</h3>
                    <p class="text-gray-700 mb-4">{{ $idea->proposed_solution }}</p>
                @endif
                
                @if($idea->target_beneficiaries)
                    <h3 class="font-semibold text-gray-800 mb-2">Target Beneficiaries</h3>
                    <p class="text-gray-700 mb-4">{{ $idea->target_beneficiaries }}</p>
                @endif
            </div>
            
            <div>
                @if($idea->sector)
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-800 mb-1">Sector</h3>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">{{ $idea->sector }}</span>
                    </div>
                @endif
                
                @if($idea->related_sdgs)
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-800 mb-1">Related SDGs</h3>
                        <div class="flex flex-wrap gap-1">
                            @php
                                $sdgs = is_string($idea->related_sdgs) ? json_decode($idea->related_sdgs, true) : $idea->related_sdgs;
                            @endphp
                            @if(is_array($sdgs))
                                @foreach($sdgs as $sdg)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">SDG {{ $sdg }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif
                
                @if($idea->tags)
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-800 mb-1">Tags</h3>
                        <div class="flex flex-wrap gap-1">
                            @foreach(explode(',', $idea->tags) as $tag)
                                @if(trim($tag))
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">{{ trim($tag) }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
            <span>By {{ $idea->user->name ?? 'Unknown' }}</span>
            <span>{{ $idea->created_at->format('M d, Y') }}</span>
            
            <!-- Voting Section -->
            @if(auth()->check())
                @php
                    $userVote = $idea->votes()->where('user_id', auth()->id())->first();
                @endphp
                <div class="flex items-center gap-2">
                    <form action="{{ route('ideas.votes.store', $idea) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="type" value="up">
                        <button type="submit" class="flex items-center gap-1 px-2 py-1 rounded text-xs {{ $userVote && $userVote->type === 'up' ? 'bg-green-100 text-green-800' : 'hover:bg-gray-100' }}">
                            <i class="bi bi-arrow-up"></i> {{ $idea->upvotes }}
                        </button>
                    </form>
                    
                    <form action="{{ route('ideas.votes.store', $idea) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="type" value="down">
                        <button type="submit" class="flex items-center gap-1 px-2 py-1 rounded text-xs {{ $userVote && $userVote->type === 'down' ? 'bg-red-100 text-red-800' : 'hover:bg-gray-100' }}">
                            <i class="bi bi-arrow-down"></i> {{ $idea->downvotes }}
                        </button>
                    </form>
                </div>
            @else
                <span><i class="bi bi-arrow-up"></i> {{ $idea->upvotes }}</span>
                <span><i class="bi bi-arrow-down"></i> {{ $idea->downvotes }}</span>
            @endif
            
            <span><i class="bi bi-hand-thumbs-up"></i> {{ $idea->interest_count }} interested</span>
        </div>
        
        <!-- Interest Button -->
        @if(auth()->check() && auth()->user()->id !== $idea->user_id)
            @php
                $userInterest = $idea->interests()->where('user_id', auth()->id())->first();
            @endphp
            
            @if(!$userInterest)
                <form action="{{ route('ideas.interests.store', $idea) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-2">
                        <textarea name="message" class="form-input w-full rounded-md" rows="3" placeholder="Why are you interested in developing this idea? (Optional)"></textarea>
                    </div>
                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-yellow-600">
                        <i class="bi bi-hand-thumbs-up mr-2"></i>I Want to Develop This
                    </button>
                </form>
            @else
                <div class="mb-4 p-3 bg-yellow-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span class="text-yellow-800 font-semibold">
                            <i class="bi bi-hand-thumbs-up mr-2"></i>You've expressed interest
                        </span>
                        <form action="{{ route('ideas.interests.destroy', $idea) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-yellow-600 hover:text-yellow-800 text-sm">Remove Interest</button>
                        </form>
                    </div>
                    @if($userInterest->message)
                        <p class="text-yellow-700 text-sm mt-1">{{ $userInterest->message }}</p>
                    @endif
                </div>
            @endif
        @endif
    </div>

    <!-- Comments Section -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-lg font-bold mb-4">Comments</h2>
        @if(auth()->check())
            <form action="{{ route('ideas.comments.store', $idea) }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="commentable_type" value="App\Models\Idea">
                <input type="hidden" name="commentable_id" value="{{ $idea->id }}">
                <textarea name="content" class="form-input w-full rounded-md mb-2" rows="3" placeholder="Add a comment..." required></textarea>
                @error('content')<div class="text-red-600 text-xs mb-2">{{ $message }}</div>@enderror
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 rounded-lg font-semibold bg-purple-600 text-white hover:bg-purple-700">Post Comment</button>
                </div>
            </form>
        @endif
        
        @foreach($idea->comments as $comment)
            <div class="border-b border-gray-200 py-3 last:border-b-0">
                <div class="flex items-center gap-2 mb-1">
                    <span class="font-semibold text-sm">{{ $comment->user->name }}</span>
                    <span class="text-xs text-gray-500">{{ $comment->created_at->format('M d, Y g:i A') }}</span>
                </div>
                <p class="text-gray-700">{{ $comment->content }}</p>
            </div>
        @endforeach
    </div>

    <!-- Pitches Section -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-lg font-bold mb-4">Pitches</h2>
        @php
            $user = auth()->user();
            $userPitch = $user && $user->role === 'entrepreneur' ? $idea->pitches->where('user_id', $user->id)->first() : null;
            $canPitch = $user && $user->role === 'entrepreneur' && !$userPitch;
            $visiblePitches = $user && $user->isAdmin() ? $idea->pitches : ($userPitch ? collect([$userPitch]) : $idea->pitches->where('status', 'approved'));
        @endphp
        @if($canPitch)
            <form action="{{ route('ideas.pitches.store', $idea) }}" method="POST" class="mb-6">
                @csrf
                <textarea name="content" class="form-input w-full rounded-md mb-2" rows="3" placeholder="Pitch your solution or business plan..." required></textarea>
                @error('content')<div class="text-red-600 text-xs mb-2">{{ $message }}</div>@enderror
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 rounded-lg font-semibold bg-yellow-500 text-white hover:bg-yellow-600">Submit Pitch</button>
                </div>
            </form>
        @elseif($userPitch)
            <div class="mb-4 p-4 bg-yellow-50 rounded">
                <div class="flex items-center gap-2 mb-1">
                    <span class="font-semibold">Your Pitch</span>
                    <span class="text-xs px-2 py-1 rounded {{ $userPitch->status === 'approved' ? 'bg-green-100 text-green-800' : ($userPitch->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($userPitch->status) }}
                    </span>
                </div>
                <div>{{ $userPitch->content }}</div>
            </div>
        @endif
        
        @foreach($visiblePitches as $pitch)
            @if($pitch !== $userPitch)
                <div class="border-b border-gray-200 py-3 last:border-b-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-semibold text-sm">{{ $pitch->user->name }}</span>
                        <span class="text-xs px-2 py-1 rounded {{ $pitch->status === 'approved' ? 'bg-green-100 text-green-800' : ($pitch->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($pitch->status) }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $pitch->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="text-gray-700">{{ $pitch->content }}</div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection 