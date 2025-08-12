@extends('layouts.bdsp')

@section('content')
<div class="max-w-6xl mx-auto mt-8">
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500">Total Mentees</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $pairedMentees->count() }}</div>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="bi bi-people-fill text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500">Total Sessions</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $totalSessions }}</div>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="bi bi-calendar-event-fill text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500">Scheduled</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $scheduledCount }}</div>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="bi bi-clock-fill text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500">Completed</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $completedCount }}</div>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="bi bi-check-circle-fill text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Mentees List -->
    <div class="bg-white rounded-xl border p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">My Mentees</h2>
            <a href="{{ route('bdsp.schedule-session-page') }}" class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-2 rounded-lg font-semibold">
                Schedule Session
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($pairedMentees as $mentee)
                <div class="bg-gray-50 rounded-lg p-6 border">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-person-fill text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $mentee->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $mentee->startup->company_name ?? 'No company' }}</p>
                        </div>
                    </div>
                    
                    @php
                        $menteeSessions = $allSessions->where('other_user.id', $mentee->id);
                        $menteeCompletedSessions = $menteeSessions->where('status', 'completed');
                        $menteeScheduledSessions = $menteeSessions->where('status', 'pending')->where('date_time', '>=', now());
                    @endphp
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Total Sessions:</span>
                            <span class="font-medium">{{ $menteeSessions->count() }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Completed:</span>
                            <span class="font-medium text-green-600">{{ $menteeCompletedSessions->count() }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Scheduled:</span>
                            <span class="font-medium text-blue-600">{{ $menteeScheduledSessions->count() }}</span>
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <button class="flex-1 bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            View Details
                        </button>
                        <button class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Message
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-gray-50 rounded-lg p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-people text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No mentees found</h3>
                    <p class="text-gray-500">You haven't been paired with any entrepreneurs yet.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Sessions List -->
    <div class="bg-white rounded-xl border p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">All Sessions</h2>
            <div class="flex gap-2">
                <button onclick="filterSessions('all')" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">All</button>
                <button onclick="filterSessions('scheduled')" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Scheduled</button>
                <button onclick="filterSessions('completed')" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Completed</button>
            </div>
        </div>
        
        <div class="space-y-4">
            @forelse($allSessions as $session)
                <div class="border rounded-lg p-6 session-item" data-status="{{ $session->status }}">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="bi bi-person-fill text-purple-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $session->other_user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $session->topic }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($session->status === 'completed')
                                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-medium">Completed</span>
                            @elseif($session->status === 'pending' && $session->date_time > now())
                                <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-medium">Scheduled</span>
                            @elseif($session->status === 'cancelled')
                                <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-medium">Cancelled</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-medium">{{ ucfirst($session->status) }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="bi bi-calendar-event"></i>
                            <span>{{ $session->date_time->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="bi bi-clock"></i>
                            <span>{{ $session->date_time->format('g:i A') }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="bi bi-clock-history"></i>
                            <span>{{ $session->duration }} minutes</span>
                        </div>
                    </div>
                    
                    @if($session->notes)
                        <div class="bg-gray-50 rounded-lg p-3 mb-4">
                            <p class="text-sm text-gray-700">{{ $session->notes }}</p>
                        </div>
                    @endif
                    
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
                            <button onclick="openRescheduleModal({{ $session->id }}, '{{ $session->date_time->format('Y-m-d\TH:i') }}', '{{ $session->notes }}')" class="text-blue-500 font-semibold hover:underline">Reschedule</button>
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
    </div>
</div>

<!-- Reschedule Modal -->
<div id="rescheduleModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Reschedule Session</h3>
                <button onclick="closeRescheduleModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="bi bi-x text-xl"></i>
                </button>
            </div>
            
            <form id="rescheduleForm">
                <input type="hidden" id="sessionId" name="session_id">
                
                <div class="mb-4">
                    <label for="newDateTime" class="block text-sm font-medium text-gray-700 mb-2">New Date & Time</label>
                    <input type="datetime-local" id="newDateTime" name="new_date_time" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>
                
                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                    <textarea id="notes" name="notes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none"></textarea>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="closeRescheduleModal()" 
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600">
                        Reschedule
                    </button>
                </div>
            </form>
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

function openRescheduleModal(sessionId, currentDateTime, currentNotes) {
    document.getElementById('sessionId').value = sessionId;
    document.getElementById('newDateTime').value = currentDateTime;
    document.getElementById('notes').value = currentNotes;
    document.getElementById('rescheduleModal').classList.remove('hidden');
}

function closeRescheduleModal() {
    document.getElementById('rescheduleModal').classList.add('hidden');
}

document.getElementById('rescheduleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const sessionId = document.getElementById('sessionId').value;
    const newDateTime = document.getElementById('newDateTime').value;
    const notes = document.getElementById('notes').value;
    
    fetch(`/bdsp/sessions/${sessionId}/reschedule`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            new_date_time: newDateTime,
            notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Session rescheduled successfully!');
            closeRescheduleModal();
            window.location.reload();
        } else {
            alert(data.error || 'Failed to reschedule session.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to reschedule session. Please try again.');
    });
});

function filterSessions(status) {
    const sessions = document.querySelectorAll('.session-item');
    sessions.forEach(session => {
        if (status === 'all' || session.dataset.status === status) {
            session.style.display = 'block';
        } else {
            session.style.display = 'none';
        }
    });
}
</script>
@endsection 