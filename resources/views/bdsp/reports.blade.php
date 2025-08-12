@extends('layouts.bdsp')
@section('content')
<div class="max-w-6xl mx-auto mt-8">
    <div class="mb-8 flex items-center justify-between">
        <h2 class="text-3xl font-bold text-gray-900">Reports & Analytics</h2>
        <div class="flex gap-2">
            <input type="date" class="border rounded-lg px-3 py-2 text-sm" placeholder="Start date">
            <input type="date" class="border rounded-lg px-3 py-2 text-sm" placeholder="End date">
            <button class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2 rounded-lg flex items-center gap-2"><i class="bi bi-download"></i> Export PDF</button>
        </div>
    </div>
    <!-- Overview Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-purple-600">{{ $pairedMentees->count() }}</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-people"></i> Total Mentees</div>
        </div>
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-blue-500">{{ $sessionsCount }}</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-calendar-event"></i> Sessions</div>
        </div>
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-green-500">{{ $avgRating }}</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-star"></i> Avg. Rating</div>
        </div>
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-orange-500">{{ $resourcesCount }}</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-upload"></i> Resources Shared</div>
        </div>
    </div>
    <!-- Session Analytics (Placeholder Chart) -->
    <div class="bg-white rounded-xl border p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">Sessions Over Time</h3>
        <div class="h-40 flex items-center justify-center text-gray-400">[Chart Placeholder]</div>
    </div>
    <!-- Mentee Progress Table -->
    <div class="bg-white rounded-xl border p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">Mentee Progress</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-left font-semibold">Name</th>
                        <th class="px-4 py-2 text-left font-semibold">Company</th>
                        <th class="px-4 py-2 text-left font-semibold">Progress</th>
                        <th class="px-4 py-2 text-left font-semibold">Last Session</th>
                        <th class="px-4 py-2 text-left font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $bdsp = auth()->user();
                    @endphp
                    @forelse($pairedMentees as $mentee)
                        @php
                            $lastSession = \App\Models\MentorshipSession::where(function($q) use ($bdsp, $mentee) {
                                $q->where('scheduled_by', $bdsp->id)->where('scheduled_for', $mentee->id)
                                  ->orWhere('scheduled_by', $mentee->id)->where('scheduled_for', $bdsp->id);
                            })->where('status', 'completed')->latest()->first();
                            
                            // Calculate progress based on completed sessions vs total sessions
                            $totalSessions = \App\Models\MentorshipSession::where(function($q) use ($bdsp, $mentee) {
                                $q->where('scheduled_by', $bdsp->id)->where('scheduled_for', $mentee->id)
                                  ->orWhere('scheduled_by', $mentee->id)->where('scheduled_for', $bdsp->id);
                            })->count();
                            $completedSessions = \App\Models\MentorshipSession::where(function($q) use ($bdsp, $mentee) {
                                $q->where('scheduled_by', $bdsp->id)->where('scheduled_for', $mentee->id)
                                  ->orWhere('scheduled_by', $mentee->id)->where('scheduled_for', $bdsp->id);
                            })->where('status', 'completed')->count();
                            $progress = $totalSessions > 0 ? round(($completedSessions / $totalSessions) * 100) : 0;
                        @endphp
                        <tr>
                            <td class="px-4 py-2 font-medium">{{ $mentee->name }}</td>
                            <td class="px-4 py-2">{{ $mentee->startup->company_name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">
                                <div class="w-32 h-2 bg-gray-200 rounded-full">
                                    <div class="h-2 rounded-full bg-gradient-to-r from-blue-500 to-purple-400" style="width: {{ $progress }}%"></div>
                                </div> 
                                <span class="ml-2">{{ $progress }}%</span>
                            </td>
                            <td class="px-4 py-2">{{ $lastSession ? $lastSession->date_time->diffForHumans() : 'No sessions yet' }}</td>
                            <td class="px-4 py-2">
                                @if($progress >= 80)
                                    <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs">excellent</span>
                                @elseif($progress >= 60)
                                    <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs">on track</span>
                                @else
                                    <span class="bg-orange-100 text-orange-600 px-2 py-1 rounded-full text-xs">needs attention</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center text-gray-500">No mentees found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Feedback & Ratings -->
    <div class="bg-white rounded-xl border p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">Feedback & Ratings</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($recentFeedback as $feedback)
                <div class="bg-gray-50 rounded-lg p-4 border">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="font-semibold text-gray-900">{{ $feedback->user->name ?? 'User Deleted' }}</span>
                        <span class="flex items-center text-yellow-400 text-sm">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $feedback->rating)
                                    <i class="bi bi-star-fill"></i>
                                @else
                                    <i class="bi bi-star"></i>
                                @endif
                            @endfor
                        </span>
                        <span class="text-xs text-gray-500">{{ $feedback->rating }}/5</span>
                    </div>
                    <div class="italic text-gray-700 text-sm mb-1">"{{ $feedback->comments }}"</div>
                    <div class="text-xs text-gray-400">{{ $feedback->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500 py-8">No feedback received yet.</div>
            @endforelse
        </div>
    </div>
    <!-- Resource Engagement -->
    <div class="bg-white rounded-xl border p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">Resource Engagement</h3>
        @if($resources->count() > 0)
            <ul class="list-disc pl-6 text-gray-700">
                @foreach($resources as $resource)
                    <li>{{ $resource->title }} <span class="text-xs text-gray-400 ml-2">{{ $resource->downloads ?? 0 }} downloads</span></li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 text-center py-4">No resources uploaded yet.</p>
        @endif
    </div>
</div>
@endsection 