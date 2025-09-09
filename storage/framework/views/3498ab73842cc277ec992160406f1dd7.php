

<?php $__env->startSection('title', 'BDSP Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Gradient Welcome Banner -->
    <div class="rounded-xl p-8 bg-gradient-to-r from-[#b81d8f] to-[#6c3483] text-white shadow-lg">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold mb-2">Welcome back, <?php echo e(Auth::user()->name); ?>! 🌟</h2>
                <p class="text-base text-pink-100 max-w-xl">
                    You have <?php echo e($upcomingSessions->count()); ?> session<?php echo e($upcomingSessions->count() != 1 ? 's' : ''); ?> scheduled today and <?php echo e($pairedMentees->count()); ?> mentee<?php echo e($pairedMentees->count() != 1 ? 's' : ''); ?> under your guidance.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 mt-4 md:mt-0">
                <a href="<?php echo e(route('bdsp.schedule-session-page')); ?>" class="inline-block px-6 py-3 rounded-lg bg-white text-[#b81d8f] font-semibold text-sm shadow hover:bg-pink-50 transition">
                    Schedule Session
                </a>
                <a href="<?php echo e(route('bdsp.resources.index')); ?>" class="inline-block px-6 py-3 rounded-lg border border-white text-white font-semibold text-sm hover:bg-white hover:text-[#b81d8f] transition">
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
                <div class="text-3xl font-bold text-gray-900"><?php echo e($stats['active_mentees'] ?? 0); ?></div>
                <div class="text-sm text-green-500">+25% from last month</div>
            </div>
            <div class="bg-pink-100 p-3 rounded-full">
                <i class="bi bi-person-fill text-[#b81d8f] text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Sessions This Month</div>
                <div class="text-3xl font-bold text-gray-900"><?php echo e($stats['sessions_this_month'] ?? 0); ?></div>
                <div class="text-sm text-gray-400">28 completed</div>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="bi bi-calendar-event-fill text-blue-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Resources Uploaded</div>
                <div class="text-3xl font-bold text-gray-900"><?php echo e($stats['resources_uploaded'] ?? 0); ?></div>
                <div class="text-sm text-green-500">+12% this quarter</div>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="bi bi-journal-arrow-up text-green-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Avg. Rating</div>
                <div class="text-3xl font-bold text-gray-900"><?php echo e($stats['avg_rating'] ?? 4.8); ?></div>
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
                <a href="<?php echo e(route('bdsp.mentees')); ?>" class="text-[#b81d8f] hover:text-[#6c3483] text-sm font-medium">View All</a>
            </div>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $pairedMentees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $initials = strtoupper(substr($mentee->name, 0, 2));
                        $colors = ['pink', 'blue', 'green', 'purple', 'orange', 'indigo'];
                        $color = $colors[array_rand($colors)];
                        $progress = rand(60, 95); // Random progress for demo
                        $modules = rand(4, 8);
                        $totalModules = 8;
                    ?>
                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer group"
                         x-data="{ showActions: false }"
                         @click="showActions = !showActions">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-<?php echo e($color); ?>-100 rounded-full flex items-center justify-center">
                                    <span class="text-<?php echo e($color); ?>-600 font-bold text-xl"><?php echo e($initials); ?></span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900"><?php echo e($mentee->name); ?></h4>
                                    <p class="text-gray-600"><?php echo e($mentee->business_name ?? 'Entrepreneur'); ?></p>
                                    <p class="text-sm text-gray-500">Joined <?php echo e($mentee->created_at->format('Y-m-d')); ?></p>
                                </div>
                            </div>
                            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-medium">on track</span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Overall Progress</span>
                                    <span class="text-sm font-bold text-gray-900"><?php echo e($progress); ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-500 to-[#b81d8f] h-2 rounded-full" style="width: <?php echo e($progress); ?>%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-700 mb-1">Modules</div>
                                <div class="text-lg font-bold text-gray-900"><?php echo e($modules); ?>/<?php echo e($totalModules); ?></div>
                                <div class="flex items-center text-sm text-gray-500 mt-1">
                                    <i class="bi bi-bullseye mr-1"></i>
                                    Focus: Financial Planning
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4 text-sm text-gray-500">
                            <div class="flex items-center">
                                <i class="bi bi-clock mr-1"></i>
                                Last session: <?php echo e(rand(1, 7)); ?> days ago
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
                                <button @click.stop="$dispatch('open-session-modal', { menteeId: <?php echo e($mentee->id); ?>, menteeName: '<?php echo e($mentee->name); ?>' })" 
                                        class="flex-1 bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#6c3483] transition">
                                    <i class="bi bi-calendar-plus mr-2"></i>
                                    Schedule Session
                                </button>
                                <a href="<?php echo e(route('bdsp.messages', ['new_conversation_with' => $mentee->id])); ?>"
                                        class="p-2 text-gray-600 hover:text-gray-800 rounded-lg hover:bg-gray-100 transition" title="Send Message">
                                    <i class="bi bi-chat-dots text-lg"></i>
                                </a>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
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
                <?php endif; ?>
            </div>
        </div>
        <!-- Upcoming Sessions -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold">Upcoming Sessions</h3>
                <a href="<?php echo e(route('bdsp.schedule-session-page')); ?>" class="text-[#b81d8f] hover:text-[#6c3483] text-sm font-medium">View All</a>
            </div>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $upcomingSessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $otherUser = $session->other_user;
                        $initials = strtoupper(substr($otherUser->name, 0, 2));
                        $colors = ['pink', 'blue', 'green', 'purple', 'orange', 'indigo'];
                        $color = $colors[array_rand($colors)];
                        $isScheduledByMe = $session->scheduled_by == auth()->id();
                    ?>
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-<?php echo e($color); ?>-100 rounded-full flex items-center justify-center">
                                <span class="text-<?php echo e($color); ?>-600 font-bold text-sm"><?php echo e($initials); ?></span>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900"><?php echo e($otherUser->name); ?></div>
                                <div class="text-sm text-gray-600"><?php echo e($session->topic ?? 'Mentoring Session'); ?></div>
                                <div class="text-xs text-gray-500">
                                    <?php echo e($session->date_time->format('M j, Y g:i A')); ?> 
                                    (<?php echo e($session->duration); ?> min)
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                <?php if($session->status === 'confirmed'): ?> bg-green-100 text-green-800
                                <?php elseif($session->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                <?php echo e(ucfirst($session->status)); ?>

                            </span>
                            <?php if($isScheduledByMe): ?>
                                <span class="text-xs text-gray-500">Scheduled by you</span>
                            <?php else: ?>
                                <span class="text-xs text-gray-500">Scheduled by admin</span>
                            <?php endif; ?>
                        </div>
                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-2 mt-2">
                            <?php if($session->status === 'completed'): ?>
                                <button class="text-gray-400 font-semibold cursor-not-allowed text-xs" disabled>Completed</button>
                            <?php else: ?>
                                <button onclick="completeSession(<?php echo e($session->id); ?>)" 
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs font-medium">
                                    Complete
                                </button>
                                <button onclick="cancelSession(<?php echo e($session->id); ?>)" 
                                        class="text-red-500 hover:text-red-700 font-semibold text-xs">
                                    Cancel
                                </button>
                                <button onclick="openRescheduleModal(<?php echo e($session->id); ?>, '<?php echo e($session->date_time->format('Y-m-d\TH:i')); ?>', '<?php echo e($session->notes ?? ''); ?>')" 
                                        class="text-blue-500 hover:text-blue-700 font-semibold text-xs">
                                    Reschedule
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
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
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Feedback -->
    <div class="mt-6">
        <h3 class="text-lg font-bold mb-4">Recent Feedback</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php
                $receivedFeedback = \App\Models\Feedback::where('target_type', 'user')
                    ->where('target_id', auth()->id())
                    ->latest()
                    ->take(3)
                    ->get();
            ?>
            <?php $__empty_1 = true; $__currentLoopData = $receivedFeedback; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedback): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $fromUser = \App\Models\User::find($feedback->user_id);
                ?>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="font-semibold mb-2"><?php echo e($fromUser ? $fromUser->name : 'User Deleted'); ?></div>
                    <div class="text-yellow-400 mb-1">
                        <?php for($i = 0; $i < $feedback->rating; $i++): ?>
                            ⭐
                        <?php endfor; ?>
                    </div>
                    <div class="text-sm text-gray-600">"<?php echo e($feedback->comments); ?>"</div>
                    <div class="text-xs text-gray-400 mt-2"><?php echo e($feedback->created_at->diffForHumans()); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-3 text-center text-gray-400">No feedback received yet.</div>
            <?php endif; ?>
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

// Session Management Functions
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

function openRescheduleModal(sessionId, currentDateTime, currentNotes) {
    document.getElementById('sessionId').value = sessionId;
    document.getElementById('newDateTime').value = currentDateTime;
    document.getElementById('notes').value = currentNotes;
    document.getElementById('rescheduleModal').classList.remove('hidden');
}

function closeRescheduleModal() {
    document.getElementById('rescheduleModal').classList.add('hidden');
}

// Initialize reschedule form handler
document.addEventListener('DOMContentLoaded', function() {
    const rescheduleForm = document.getElementById('rescheduleForm');
    if (rescheduleForm) {
        rescheduleForm.addEventListener('submit', function(e) {
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
    }
});
</script>

<!-- Quick Resource Sharing Section -->
<div class="bg-white rounded-lg shadow p-6 mt-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-900">Quick Resource Sharing</h3>
        <a href="<?php echo e(route('bdsp.resources.index')); ?>" class="text-[#b81d8f] hover:text-[#6c3483] text-sm font-medium">Manage All Resources</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $recentResources ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="border rounded-lg p-4 hover:shadow-md transition">
                <div class="flex items-center gap-2 mb-2">
                    <i class="bi bi-file-earmark-text text-blue-500"></i>
                    <span class="font-medium text-sm"><?php echo e(Str::limit($resource->name, 30)); ?></span>
                </div>
                <div class="text-xs text-gray-500 mb-3"><?php echo e(Str::limit($resource->description, 50)); ?></div>
                <a href="<?php echo e(route('bdsp.resources.sharing', $resource)); ?>" 
                   class="inline-block bg-[#b81d8f] hover:bg-[#6c3483] text-white text-xs px-3 py-1 rounded transition">
                    Share with Mentees
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-3 text-center text-gray-500 py-4">
                <i class="bi bi-file-earmark-text text-2xl mb-2"></i>
                <p class="text-sm">No resources uploaded yet.</p>
                <a href="<?php echo e(route('bdsp.resources.index')); ?>" class="text-[#b81d8f] hover:underline text-sm">Upload your first resource</a>
            </div>
        <?php endif; ?>
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
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.bdsp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ABU-UMAR\Documents\GitHub\backend\resources\views/dashboard/bdsp.blade.php ENDPATH**/ ?>