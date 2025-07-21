@extends('layouts.bdsp')
@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-1">Mentorship Management</h2>
            <p class="text-gray-500">Manage mentorship sessions and track progress</p>
        </div>
        <a href="{{ route('bdsp.schedule-session-page') }}" class="bg-purple-500 hover:bg-purple-600 text-white px-5 py-2 rounded-lg font-semibold text-sm flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Schedule Session
        </a>
    </div>
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-purple-600">{{ $totalSessions }}</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-people"></i> Total Sessions</div>
        </div>
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-blue-500">{{ $scheduledCount }}</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-calendar-event"></i> Scheduled</div>
        </div>
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-green-500">{{ $completedCount }}</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-check-circle"></i> Completed</div>
        </div>
        <div class="bg-white rounded-xl border p-4 flex flex-col items-center">
            <div class="text-2xl font-bold text-orange-500">{{ $avgRating }}</div>
            <div class="text-gray-500 text-sm flex items-center gap-2"><i class="bi bi-star"></i> Avg. Rating</div>
        </div>
    </div>
    <!-- Tabs & Session Cards -->
    <div x-data="{ tab: 'scheduled' }">
        <div class="mb-4 border-b">
            <nav class="flex gap-8">
                <button @click="tab = 'scheduled'" :class="tab === 'scheduled' ? 'border-b-2 border-purple-500 text-purple-600 font-semibold' : 'text-gray-500 hover:text-purple-600'" class="py-2 focus:outline-none">Scheduled ({{ $scheduledCount }})</button>
                <button @click="tab = 'completed'" :class="tab === 'completed' ? 'border-b-2 border-purple-500 text-purple-600 font-semibold' : 'text-gray-500 hover:text-purple-600'" class="py-2 focus:outline-none">Completed ({{ $completedCount }})</button>
                <button @click="tab = 'all'" :class="tab === 'all' ? 'border-b-2 border-purple-500 text-purple-600 font-semibold' : 'text-gray-500 hover:text-purple-600'" class="py-2 focus:outline-none">All ({{ $totalSessions }})</button>
            </nav>
        </div>
        <!-- Session Cards -->
        <div class="space-y-6">
            <!-- Scheduled Tab -->
            <template x-if="tab === 'scheduled'">
                <div>
                    @forelse($scheduledSessions as $session)
                        @php
                            $bdsp = $session->scheduled_by == auth()->id() ? $session->scheduledBy : $session->scheduledFor;
                            $mentee = $session->scheduled_by == auth()->id() ? $session->scheduledFor : $session->scheduledBy;
                        @endphp
                        <div class="bg-white rounded-xl border p-6 flex flex-col gap-4 shadow-sm relative mb-6">
                            <span class="absolute top-4 right-4 bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full">{{ ucfirst($session->status) }}</span>
                            <div class="flex items-center gap-4">
                                <img src="https://randomuser.me/api/portraits/men/{{ rand(1, 99) }}.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white" alt="{{ $bdsp->name }}">
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $bdsp->name }} <span class="text-xs text-gray-400 ml-1">BDSP</span></div>
                                    <div class="text-gray-500 text-sm">{{ $session->topic ?? 'Mentoring Session' }}</div>
                                </div>
                                <i class="bi {{ $session->meeting_link ? 'bi-camera-video' : 'bi-telephone' }} text-purple-500 text-xl ml-4"></i>
                                <img src="https://randomuser.me/api/portraits/women/{{ rand(1, 99) }}.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white ml-4" alt="{{ $mentee->name }}">
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $mentee->name }} <span class="text-xs text-gray-400 ml-1">Mentee</span></div>
                                </div>
                            </div>
                            <div class="flex items-center gap-6 text-gray-500 text-sm mt-2">
                                <div><i class="bi bi-calendar-event"></i> {{ $session->date_time->format('Y-m-d \a\t g:i A') }}</div>
                                <div><i class="bi bi-clock"></i> {{ $session->duration }} minutes</div>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Chat">
                                    <i class="bi bi-chat-dots text-lg text-gray-500"></i>
                                </button>
                                <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Message">
                                    <i class="bi bi-envelope text-lg text-gray-500"></i>
                                </button>
                            </div>
                            <div class="flex gap-3 mt-4">
                                @if($session->status === 'completed')
                                    <button class="text-gray-400 font-semibold cursor-not-allowed" disabled>Cancel</button>
                                    <button class="text-gray-400 font-semibold cursor-not-allowed" disabled>Reschedule</button>
                                    <button class="bg-green-500 text-white px-4 py-2 rounded-lg font-semibold ml-auto cursor-not-allowed" disabled>Completed</button>
                                @else
                                    <button onclick="cancelSession({{ $session->id }})" class="text-red-500 font-semibold hover:underline">Cancel</button>
                                    <button onclick="rescheduleSession({{ $session->id }})" class="text-blue-500 font-semibold hover:underline">Reschedule</button>
                                    @if($session->meeting_link)
                                        <a href="{{ $session->meeting_link }}" target="_blank" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold ml-auto">Join Session</a>
                                    @else
                                        <button onclick="completeSession({{ $session->id }})" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold ml-auto">Complete Session</button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-xl border p-8 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="bi bi-calendar-event text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No scheduled sessions</h3>
                            <p class="text-gray-500 mb-4">You don't have any scheduled sessions at the moment.</p>
                            <a href="{{ route('bdsp.schedule-session-page') }}" class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-2 rounded-lg font-semibold">
                                Schedule a Session
                            </a>
                        </div>
                    @endforelse
                </div>
            </template>
            <!-- Completed Tab -->
            <template x-if="tab === 'completed'">
                <div>
                    @forelse($completedSessions as $session)
                        @php
                            $bdsp = $session->scheduled_by == auth()->id() ? $session->scheduledBy : $session->scheduledFor;
                            $mentee = $session->scheduled_by == auth()->id() ? $session->scheduledFor : $session->scheduledBy;
                        @endphp
                        <div class="bg-white rounded-xl border p-6 flex flex-col gap-4 shadow-sm relative">
                            <span class="absolute top-4 right-4 bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full">Completed</span>
                            <div class="flex items-center gap-4">
                                <img src="https://randomuser.me/api/portraits/men/{{ rand(1, 99) }}.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white" alt="{{ $bdsp->name }}">
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $bdsp->name }} <span class="text-xs text-gray-400 ml-1">BDSP</span></div>
                                    <div class="text-gray-500 text-sm">{{ $session->topic ?? 'Mentoring Session' }}</div>
                                </div>
                                <i class="bi {{ $session->meeting_link ? 'bi-camera-video' : 'bi-telephone' }} text-purple-500 text-xl ml-4"></i>
                                <img src="https://randomuser.me/api/portraits/women/{{ rand(1, 99) }}.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white ml-4" alt="{{ $mentee->name }}">
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $mentee->name }} <span class="text-xs text-gray-400 ml-1">Mentee</span></div>
                                </div>
                            </div>
                            <div class="flex items-center gap-6 text-gray-500 text-sm mt-2">
                                <div><i class="bi bi-calendar-event"></i> {{ $session->date_time->format('Y-m-d \a\t g:i A') }}</div>
                                <div><i class="bi bi-clock"></i> {{ $session->duration }} minutes</div>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Chat">
                                    <i class="bi bi-chat-dots text-lg text-gray-500"></i>
                                </button>
                                <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Message">
                                    <i class="bi bi-envelope text-lg text-gray-500"></i>
                                </button>
                            </div>
                            <div class="flex gap-3 mt-4">
                                <button class="text-gray-400 font-semibold cursor-not-allowed" disabled>Cancel</button>
                                <button class="text-gray-400 font-semibold cursor-not-allowed" disabled>Reschedule</button>
                                <button class="bg-green-500 text-white px-4 py-2 rounded-lg font-semibold ml-auto cursor-not-allowed" disabled>Completed</button>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-xl border p-8 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="bi bi-check-circle text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No completed sessions</h3>
                            <p class="text-gray-500">You haven't completed any sessions yet.</p>
                        </div>
                    @endforelse
                </div>
            </template>
            <!-- All Tab -->
            <template x-if="tab === 'all'">
                <div>
                    @forelse($allSessions as $session)
                        @php
                            $bdsp = $session->scheduled_by == auth()->id() ? $session->scheduledBy : $session->scheduledFor;
                            $mentee = $session->scheduled_by == auth()->id() ? $session->scheduledFor : $session->scheduledBy;
                        @endphp
                        <div class="bg-white rounded-xl border p-6 flex flex-col gap-4 shadow-sm relative mb-6">
                            <span class="absolute top-4 right-4 text-xs px-3 py-1 rounded-full
                                @if($session->status === 'completed') bg-green-100 text-green-600
                                @elseif($session->status === 'pending') bg-blue-100 text-blue-600
                                @else bg-gray-100 text-gray-600 @endif">
                                {{ ucfirst($session->status) }}
                            </span>
                            <div class="flex items-center gap-4">
                                <img src="https://randomuser.me/api/portraits/men/{{ rand(1, 99) }}.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white" alt="{{ $bdsp->name }}">
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $bdsp->name }} <span class="text-xs text-gray-400 ml-1">BDSP</span></div>
                                    <div class="text-gray-500 text-sm">{{ $session->topic ?? 'Mentoring Session' }}</div>
                                </div>
                                <i class="bi {{ $session->meeting_link ? 'bi-camera-video' : 'bi-telephone' }} text-purple-500 text-xl ml-4"></i>
                                <img src="https://randomuser.me/api/portraits/women/{{ rand(1, 99) }}.jpg" class="h-12 w-12 rounded-full object-cover border-2 border-white ml-4" alt="{{ $mentee->name }}">
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $mentee->name }} <span class="text-xs text-gray-400 ml-1">Mentee</span></div>
                                </div>
                            </div>
                            <div class="flex items-center gap-6 text-gray-500 text-sm mt-2">
                                <div><i class="bi bi-calendar-event"></i> {{ $session->date_time->format('Y-m-d \a\t g:i A') }}</div>
                                <div><i class="bi bi-clock"></i> {{ $session->duration }} minutes</div>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Chat">
                                    <i class="bi bi-chat-dots text-lg text-gray-500"></i>
                                </button>
                                <button class="p-2 rounded-lg border border-gray-200 hover:bg-gray-100" title="Message">
                                    <i class="bi bi-envelope text-lg text-gray-500"></i>
                                </button>
                            </div>
                            <div class="flex gap-3 mt-4">
                                @if($session->status === 'completed')
                                    <button class="text-gray-400 font-semibold cursor-not-allowed" disabled>Cancel</button>
                                    <button class="text-gray-400 font-semibold cursor-not-allowed" disabled>Reschedule</button>
                                    <button class="bg-green-500 text-white px-4 py-2 rounded-lg font-semibold ml-auto cursor-not-allowed" disabled>Completed</button>
                                @else
                                    <button onclick="cancelSession({{ $session->id }})" class="text-red-500 font-semibold hover:underline">Cancel</button>
                                    <button onclick="rescheduleSession({{ $session->id }})" class="text-blue-500 font-semibold hover:underline">Reschedule</button>
                                    @if($session->meeting_link)
                                        <a href="{{ $session->meeting_link }}" target="_blank" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold ml-auto">Join Session</a>
                                    @else
                                        <button onclick="completeSession({{ $session->id }})" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold ml-auto">Complete Session</button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-xl border p-8 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="bi bi-calendar-event text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No sessions found</h3>
                            <p class="text-gray-500 mb-4">You don't have any sessions yet.</p>
                            <a href="{{ route('bdsp.schedule-session-page') }}" class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-2 rounded-lg font-semibold">
                                Schedule Your First Session
                            </a>
                        </div>
                    @endforelse
                </div>
            </template>
        </div>
    </div>
</div>

<script>
function cancelSession(sessionId) {
    if (confirm('Are you sure you want to cancel this session?')) {
        fetch(`/bdsp/sessions/${sessionId}/cancel`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Session cancelled successfully!');
                window.location.reload();
            } else {
                alert(data.error || 'Failed to cancel session.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to cancel session. Please try again.');
        });
    }
}

function completeSession(sessionId) {
    if (confirm('Are you sure you want to mark this session as completed?')) {
        fetch(`/bdsp/sessions/${sessionId}/complete`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Session marked as completed!');
                window.location.reload();
            } else {
                alert(data.error || 'Failed to complete session.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to complete session. Please try again.');
        });
    }
}

function rescheduleSession(sessionId) {
    // For now, redirect to schedule session page
    // In the future, this could open a modal with the session details pre-filled
    window.location.href = '{{ route("bdsp.schedule-session-page") }}';
}
</script>
@endsection 