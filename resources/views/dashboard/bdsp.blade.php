@extends('layouts.bdsp')

@section('title', 'BDSP Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Gradient Welcome Banner -->
    <div class="rounded-xl p-8 bg-gradient-to-r from-[#b81d8f] to-[#6c3483] text-white shadow-lg">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold mb-2">Good morning, {{ Auth::user()->name }}! 🌟</h2>
                <p class="text-base text-pink-100 max-w-xl">
                    You have {{ $upcomingSessions->count() }} session{{ $upcomingSessions->count() != 1 ? 's' : '' }} scheduled today and {{ $pairedMentees->count() }} mentee{{ $pairedMentees->count() != 1 ? 's' : '' }} under your guidance.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 mt-4 md:mt-0">
                <a href="{{ route('bdsp.schedule-session-page') }}" class="inline-block px-6 py-3 rounded-lg bg-white text-[#b81d8f] font-semibold text-sm shadow hover:bg-pink-50 transition">
                    Schedule Session
                </a>
                <a href="{{ route('bdsp.resources.index') }}" class="inline-block px-6 py-3 rounded-lg border border-white text-white font-semibold text-sm hover:bg-white hover:text-[#b81d8f] transition">
                    Upload Resource
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Active Mentees</div>
                <div class="text-3xl font-bold text-gray-900">{{ $stats['active_mentees'] ?? 0 }}</div>
                <div class="text-sm text-green-500">+25% from last month</div>
            </div>
            <div class="bg-pink-100 p-3 rounded-full">
                <i class="bi bi-person-fill text-[#b81d8f] text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Sessions This Month</div>
                <div class="text-3xl font-bold text-gray-900">{{ $stats['sessions_this_month'] ?? 0 }}</div>
                <div class="text-sm text-gray-400">28 completed</div>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="bi bi-calendar-event-fill text-blue-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Resources Uploaded</div>
                <div class="text-3xl font-bold text-gray-900">{{ $stats['resources_uploaded'] ?? 0 }}</div>
                <div class="text-sm text-green-500">+12% this quarter</div>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="bi bi-journal-arrow-up text-green-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Avg. Rating</div>
                <div class="text-3xl font-bold text-gray-900">{{ $stats['avg_rating'] ?? 4.8 }}</div>
                <div class="text-sm text-gray-400">From mentees</div>
            </div>
            <div class="bg-orange-100 p-3 rounded-full">
                <i class="bi bi-star-fill text-orange-400 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Mentees and Sessions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- My Mentees -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold">My Mentees</h3>
                <a href="{{ route('bdsp.mentees') }}" class="text-[#b81d8f] hover:text-[#6c3483] text-sm font-medium">View All</a>
            </div>
            <div class="space-y-4">
                @forelse($pairedMentees as $mentee)
                    @php
                        $initials = strtoupper(substr($mentee->name, 0, 2));
                        $colors = ['pink', 'blue', 'green', 'purple', 'orange', 'indigo'];
                        $color = $colors[array_rand($colors)];
                        $progress = rand(60, 95); // Random progress for demo
                        $modules = rand(4, 8);
                        $totalModules = 8;
                    @endphp
                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer group"
                         x-data="{ showActions: false }"
                         @click="showActions = !showActions">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-{{ $color }}-100 rounded-full flex items-center justify-center">
                                    <span class="text-{{ $color }}-600 font-bold text-xl">{{ $initials }}</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ $mentee->name }}</h4>
                                    <p class="text-gray-600">{{ $mentee->business_name ?? 'Entrepreneur' }}</p>
                                    <p class="text-sm text-gray-500">Joined {{ $mentee->created_at->format('Y-m-d') }}</p>
                                </div>
                            </div>
                            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-medium">on track</span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Overall Progress</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $progress }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-500 to-[#b81d8f] h-2 rounded-full" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-700 mb-1">Modules</div>
                                <div class="text-lg font-bold text-gray-900">{{ $modules }}/{{ $totalModules }}</div>
                                <div class="flex items-center text-sm text-gray-500 mt-1">
                                    <i class="bi bi-bullseye mr-1"></i>
                                    Focus: Financial Planning
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4 text-sm text-gray-500">
                            <div class="flex items-center">
                                <i class="bi bi-clock mr-1"></i>
                                Last session: {{ rand(1, 7) }} days ago
                            </div>
                            <div>
                                Next: Tomorrow 2:00 PM
                            </div>
                        </div>
                        
                        <!-- Hidden Actions Section -->
                        <div x-show="showActions" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="border-t pt-4 mt-4">
                            <div class="flex items-center space-x-3">
                                <button @click.stop="$dispatch('open-session-modal', { menteeId: {{ $mentee->id }}, menteeName: '{{ $mentee->name }}' })" 
                                        class="flex-1 bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#6c3483] transition">
                                    <i class="bi bi-calendar-plus mr-2"></i>
                                    Schedule Session
                                </button>
                                <button @click.stop="$dispatch('open-message-modal', { recipientId: {{ $mentee->id }}, recipientName: '{{ $mentee->name }}' })"
                                        class="p-2 text-gray-600 hover:text-gray-800 rounded-lg hover:bg-gray-100 transition" title="Send Message">
                                    <i class="bi bi-chat-dots text-lg"></i>
                                </button>
                                <button @click.stop class="p-2 text-gray-600 hover:text-gray-800 rounded-lg hover:bg-gray-100 transition" title="Send Email">
                                    <i class="bi bi-envelope text-lg"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Click hint -->
                        <div x-show="!showActions" class="text-center text-xs text-gray-400 mt-2">
                            <i class="bi bi-mouse mr-1"></i>
                            Click to view actions
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="bi bi-person text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">No mentees yet</h3>
                        <p class="text-gray-500 mb-6">You'll see your paired entrepreneurs here once admin pairs you.</p>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600">When you have mentees, you'll be able to:</p>
                            <ul class="text-sm text-gray-600 mt-2 space-y-1">
                                <li>• Schedule mentoring sessions</li>
                                <li>• Track their progress</li>
                                <li>• Send messages and resources</li>
                                <li>• Monitor their development</li>
                            </ul>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        <!-- Upcoming Sessions -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold">Upcoming Sessions</h3>
                <a href="{{ route('bdsp.schedule-session-page') }}" class="text-[#b81d8f] hover:text-[#6c3483] text-sm font-medium">View All</a>
            </div>
            <div class="space-y-4">
                @forelse($upcomingSessions as $session)
                    @php
                        $otherUser = $session->other_user;
                        $initials = strtoupper(substr($otherUser->name, 0, 2));
                        $colors = ['pink', 'blue', 'green', 'purple', 'orange', 'indigo'];
                        $color = $colors[array_rand($colors)];
                        $isScheduledByMe = $session->scheduled_by == auth()->id();
                    @endphp
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-{{ $color }}-100 rounded-full flex items-center justify-center">
                                <span class="text-{{ $color }}-600 font-bold text-sm">{{ $initials }}</span>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">{{ $otherUser->name }}</div>
                                <div class="text-sm text-gray-600">{{ $session->topic ?? 'Mentoring Session' }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $session->date_time->format('M j, Y g:i A') }} 
                                    ({{ $session->duration }} min)
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                @if($session->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($session->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($session->status) }}
                            </span>
                            @if($isScheduledByMe)
                                <span class="text-xs text-gray-500">Scheduled by you</span>
                            @else
                                <span class="text-xs text-gray-500">Scheduled by admin</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="bi bi-calendar-event text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No upcoming sessions</h3>
                        <p class="text-gray-500 mb-4">You don't have any sessions scheduled yet.</p>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600">Sessions can be scheduled by:</p>
                            <ul class="text-sm text-gray-600 mt-2 space-y-1">
                                <li>• You (for your mentees)</li>
                                <li>• Admin (for you and your mentees)</li>
                                <li>• Your mentees (with your approval)</li>
                            </ul>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Feedback -->
    <div class="mt-6">
        <h3 class="text-lg font-bold mb-4">Recent Feedback</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @php
                $receivedFeedback = \App\Models\Feedback::where('target_type', 'user')
                    ->where('target_id', auth()->id())
                    ->latest()
                    ->take(3)
                    ->get();
            @endphp
            @forelse($receivedFeedback as $feedback)
                @php
                    $fromUser = \App\Models\User::find($feedback->user_id);
                @endphp
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="font-semibold mb-2">{{ $fromUser ? $fromUser->name : 'User Deleted' }}</div>
                    <div class="text-yellow-400 mb-1">
                        @for($i = 0; $i < $feedback->rating; $i++)
                            ⭐
                        @endfor
                    </div>
                    <div class="text-sm text-gray-600">"{{ $feedback->comments }}"</div>
                    <div class="text-xs text-gray-400 mt-2">{{ $feedback->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-400">No feedback received yet.</div>
            @endforelse
        </div>
    </div>
</div>

<!-- Session Scheduling Modal -->
<div x-data="sessionModal()" x-show="isOpen" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-black bg-opacity-50 z-50"
     @click.away="closeModal()"
     style="display: none;">
    
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="relative inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Schedule Session</h3>
                <button @click="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <!-- Form -->
            <form @submit.prevent="scheduleSession()" class="space-y-4">
                <!-- Mentee -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mentee:</label>
                    <input type="text" x-model="menteeName" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50" readonly>
                    <input type="hidden" x-model="menteeId">
                </div>

                <!-- Session Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Session Date:</label>
                    <input type="date" x-model="sessionDate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:outline-none" required>
                </div>

                <!-- Session Time -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Session Time:</label>
                    <input type="time" x-model="sessionTime" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:outline-none" required>
                </div>

                <!-- Session Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Session Type:</label>
                    <select x-model="sessionType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:outline-none" required>
                        <option value="">Select type...</option>
                        <option value="1-on-1">1-on-1 Session</option>
                        <option value="group">Group Session</option>
                    </select>
                </div>

                <!-- Topic -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Topic:</label>
                    <input type="text" x-model="topic" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:outline-none" placeholder="e.g., Business Model Canvas, Financial Planning" required>
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes (optional):</label>
                    <textarea x-model="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b81d8f] focus:outline-none" placeholder="Additional details about the session..."></textarea>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 pt-4">
                    <button type="button" @click="closeModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Cancel
                    </button>
                    <button type="submit" :disabled="scheduling" class="bg-[#b81d8f] text-white px-4 py-2 rounded-lg shadow hover:bg-[#6c3483] transition disabled:opacity-50">
                        <span x-show="!scheduling">Schedule Session</span>
                        <span x-show="scheduling">Scheduling...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function sessionModal() {
    return {
        isOpen: false,
        menteeId: '',
        menteeName: '',
        sessionDate: '',
        sessionTime: '',
        sessionType: '',
        topic: '',
        notes: '',
        scheduling: false,
        init() {
            window.addEventListener('open-session-modal', (event) => {
                this.openModal(event.detail.menteeId, event.detail.menteeName);
            });
        },
        openModal(menteeId, menteeName) {
            this.menteeId = menteeId;
            this.menteeName = menteeName;
            this.isOpen = true;
        },
        closeModal() {
            this.isOpen = false;
            this.resetForm();
        },
        resetForm() {
            this.menteeId = '';
            this.menteeName = '';
            this.sessionDate = '';
            this.sessionTime = '';
            this.sessionType = '';
            this.topic = '';
            this.notes = '';
        },
        async scheduleSession() {
            if (!this.menteeId || !this.sessionDate || !this.sessionTime || !this.sessionType || !this.topic) {
                alert('Please fill in all required fields.');
                return;
            }
            this.scheduling = true;
            const formData = new FormData();
            formData.append('mentee_id', this.menteeId);
            formData.append('session_date', this.sessionDate);
            formData.append('session_time', this.sessionTime);
            formData.append('session_type', this.sessionType);
            formData.append('topic', this.topic);
            formData.append('notes', this.notes);
            try {
                const response = await fetch('/bdsp/schedule-session', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData
                });
                const data = await response.json();
                if (data.success) {
                    alert('Session scheduled successfully!');
                    this.closeModal();
                    window.location.reload();
                } else {
                    alert(data.error || 'Failed to schedule session.');
                }
            } catch (error) {
                console.error('Error scheduling session:', error);
                alert('Failed to schedule session. Please try again.');
            } finally {
                this.scheduling = false;
            }
        }
    }
}
</script>
@endsection 