@extends('layouts.entrepreneur')
@section('title', 'Pitch Preparation')
@section('content')
<div class="max-w-5xl mx-auto mt-10 space-y-12">
    <!-- Header -->
    <div>
        <h2 class="text-3xl font-bold text-gray-900">Pitch Preparation</h2>
        <p class="text-gray-500 mt-1">Access resources, practice your pitch, and explore the Idea Bank to find or share innovative business ideas.</p>
    </div>
    <!-- Learning Resources (same as dashboard) -->
    <div>
        <h3 class="text-xl font-semibold mb-4">Learning Resources</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($learningResources as $resource)
                <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="bi bi-file-earmark-text text-[#b81d8f] text-xl"></i>
                        <span class="font-semibold">{{ $resource->name }}</span>
                    </div>
                    <div class="text-sm text-gray-500 mb-2">{{ $resource->description }}</div>
                    <div class="text-xs text-gray-400 mb-1">Uploaded by: {{ optional($resource->bdsp)->name ?? 'You' }}</div>
                    <div class="text-xs text-gray-400 mb-2">{{ strtoupper($resource->file_type) }} • {{ number_format($resource->file_size / 1024, 1) }} KB</div>
                    <a href="{{ asset('storage/' . $resource->file_path) }}" target="_blank" class="mt-auto bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-[#a01a7d] transition">Download</a>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow p-5 flex flex-col col-span-3">
                    <div class="font-semibold mb-2">No learning resources available yet.</div>
                </div>
            @endforelse
        </div>
    </div>
    <!-- Pitching Resources -->
    <div>
        <h3 class="text-xl font-semibold mb-4">Pitching Resources</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($pitchResources as $resource)
                <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="bi {{ $resource->type === 'video' ? 'bi-play-circle' : 'bi-file-earmark-text' }} text-[#b81d8f] text-xl"></i>
                        <span class="font-semibold">{{ $resource->title }}</span>
                    </div>
                    <div class="text-sm text-gray-500 mb-4">{{ $resource->description }}</div>
                    @if($resource->file_path)
                        <a href="{{ asset('storage/' . $resource->file_path) }}" target="_blank" class="mt-auto bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-[#a01a7d] transition">
                            {{ $resource->type === 'video' ? 'Watch Video' : 'Download' }}
                        </a>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-xl shadow p-5 flex flex-col col-span-3">
                    <div class="font-semibold mb-2">No pitching resources available yet.</div>
                </div>
            @endforelse
        </div>
    </div>
    <!-- Practice Your Pitch -->
    <div>
        <h3 class="text-xl font-semibold mb-4">Practice Your Pitch</h3>
        <div class="bg-white rounded-xl shadow p-6 flex flex-col md:flex-row md:items-center gap-6">
            <div class="flex-1">
                <div class="text-gray-700 mb-2">Record a practice pitch or submit your pitch deck for feedback from mentors or peers.</div>
                <div class="flex gap-3 mb-2">
                    <a href="{{ route('practice-pitches.index') }}" class="bg-[#b81d8f] text-white px-5 py-2 rounded-lg font-semibold hover:bg-[#a01a7d] transition">Record Pitch</a>
                    <a href="{{ route('practice-pitches.index') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Request Feedback</a>
                </div>
                <div class="text-xs text-gray-400">You can view your previous practice pitches and feedback below.</div>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold mb-2">Previous Practice Pitches</h4>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-sm text-gray-700"><i class="bi bi-mic text-[#b81d8f]"></i> Pitch 1 - Feedback Pending</li>
                    <li class="flex items-center gap-2 text-sm text-gray-700"><i class="bi bi-mic text-[#b81d8f]"></i> Pitch 2 - Reviewed</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Idea Bank -->
    <div>
        <h3 class="text-xl font-semibold mb-4">Idea Bank</h3>
        <div class="mb-4 flex flex-col md:flex-row md:items-center gap-4">
            <form class="flex-1 flex gap-2" action="{{ route('ideas.store') }}" method="POST">
                @csrf
                <input type="text" name="title" class="flex-1 border border-gray-300 rounded-lg p-2 focus:ring-[#b81d8f] focus:border-[#b81d8f]" placeholder="Share a new idea..." required>
                <button type="submit" class="bg-[#b81d8f] text-white px-5 py-2 rounded-lg font-semibold hover:bg-[#a01a7d] transition">Submit Idea</button>
            </form>
            <div class="flex gap-2">
                <input type="text" class="border border-gray-300 rounded-lg p-2 focus:ring-[#b81d8f] focus:border-[#b81d8f]" placeholder="Search ideas..." disabled>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @php
                $user = auth()->user();
                $ideas = \App\Models\Idea::with(['pitches' => function($q) use ($user) { $q->where('user_id', $user->id); }])
                    ->where('status', 'approved')->latest()->take(6)->get();
            @endphp
            @forelse($ideas as $idea)
                <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                    <div class="flex items-center gap-2 mb-2"><i class="bi bi-lightbulb text-yellow-400 text-xl"></i> <span class="font-semibold">{{ $idea->title }}</span></div>
                    <div class="text-sm text-gray-500 mb-2">{{ Str::limit($idea->description, 80) }}</div>
                    <div class="flex flex-wrap gap-2 mb-3">
                        @foreach(explode(',', $idea->tags ?? '') as $tag)
                            @if(trim($tag))
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">{{ trim($tag) }}</span>
                            @endif
                        @endforeach
                    </div>
                    <div class="flex gap-2 mt-auto">
                        @php $userPitch = $idea->pitches->first(); @endphp
                        @if($user->role === 'entrepreneur' && !$userPitch)
                            <form action="{{ route('ideas.pitches.store', $idea) }}" method="POST">
                                @csrf
                                <input type="hidden" name="content" value="I'd like to pitch this idea!">
                                <button type="submit" class="bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#a01a7d] transition">Pitch This Idea</button>
                            </form>
                        @elseif($userPitch)
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $userPitch->status === 'approved' ? 'bg-green-100 text-green-800' : ($userPitch->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($userPitch->status) }}
                            </span>
                        @endif
                        <form action="{{ route('ideas.votes.store', $idea) }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="up">
                            <button type="submit" class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 font-medium hover:bg-gray-100 transition"><i class="bi bi-hand-thumbs-up"></i> Like ({{ $idea->upvotes }})</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow p-5 flex flex-col col-span-2">
                    <div class="font-semibold mb-2">No ideas available yet.</div>
                </div>
            @endforelse
        </div>
        <div class="mt-4 text-right">
            <a href="{{ route('ideas.index') }}" class="text-[#b81d8f] font-semibold hover:underline">View All Ideas</a>
        </div>
    </div>
    <!-- Recommendations -->
    <div>
        <h3 class="text-xl font-semibold mb-4">Recommended for You</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($recommendedEvents as $event)
                @include('partials.pitch_event_card', ['event' => $event])
            @empty
                <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                    <div class="font-semibold mb-2">No upcoming pitch events at the moment.</div>
                </div>
            @endforelse
            <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                <div class="font-semibold mb-2">Mentor Recommendation: Grace Mwangi</div>
                <div class="text-sm text-gray-500 mb-4">Based on your interests in finance, we recommend connecting with Grace for pitch feedback.</div>
                <a href="#" class="mt-auto bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-[#a01a7d] transition">Connect</a>
            </div>
        </div>
        <div class="mt-4 text-right">
            <a href="{{ route('entrepreneur.pitch') }}" class="btn btn-primary">View All Pitch Events</a>
        </div>
    </div>
</div>
@endsection 