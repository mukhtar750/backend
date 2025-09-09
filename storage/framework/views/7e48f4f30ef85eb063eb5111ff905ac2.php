

<?php $__env->startSection('content'); ?>
    <!-- Your dashboard content will go here -->
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Dashboard Overview</h2>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Total Users</div>
                <div class="text-3xl font-bold text-gray-900"><?php echo e($totalUsers); ?></div>
                <div class="text-sm text-green-500">+12% from last month</div>
            </div>
            <div class="bg-purple-100 p-3 rounded-full">
                <i class="bi bi-people-fill text-purple-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Active Programs</div>
                <div class="text-3xl font-bold text-gray-900"><?php echo e($activePrograms); ?></div>
                <div class="text-sm text-green-500">+25% from last quarter</div>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="bi bi-book-fill text-blue-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Pitch Events</div>
                <div class="text-3xl font-bold text-gray-900"><?php echo e($pitchEvents); ?></div>
                <div class="text-sm text-gray-500">3 upcoming</div>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="bi bi-megaphone-fill text-green-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Success Rate</div>
                <div class="text-3xl font-bold text-gray-900"><?php echo e($successRate); ?>%</div>
                <div class="text-sm text-green-500">+5% improvement</div>
            </div>
            <div class="bg-orange-100 p-3 rounded-full">
                <i class="bi bi-graph-up text-orange-600 text-2xl"></i>
            </div>
        </div>
    </div>


    <!-- Quick Actions -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 mb-6">
        <a href="<?php echo e(route('admin.user-management')); ?>" class="bg-purple-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <i class="bi bi-people-fill text-purple-600 text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm text-gray-700">Approve Users</p>
            <p class="text-xs text-gray-500"><?php echo e($approvalCounts['users']); ?> pending</p>
        </a>
        <a href="<?php echo e(route('admin.resources')); ?>" class="bg-green-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <i class="bi bi-file-earmark-text-fill text-green-600 text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm text-gray-700">Resources</p>
            <p class="text-xs text-gray-500"><?php echo e($approvalCounts['resources']); ?> pending</p>
        </a>
        <a href="<?php echo e(route('admin.content_management')); ?>" class="bg-blue-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <i class="bi bi-file-text-fill text-blue-600 text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm text-gray-700">Content</p>
            <p class="text-xs text-gray-500"><?php echo e($approvalCounts['content']); ?> pending</p>
        </a>
        <a href="<?php echo e(route('admin.feedback')); ?>" class="bg-orange-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <i class="bi bi-chat-square-text-fill text-orange-600 text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm text-gray-700">Feedback</p>
            <p class="text-xs text-gray-500"><?php echo e($approvalCounts['feedback']); ?> pending</p>
        </a>
        <a href="<?php echo e(route('admin.training_programs.create')); ?>" class="bg-indigo-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <i class="bi bi-calendar-event-fill text-indigo-600 text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm text-gray-700">Schedule Event</p>
        </a>
        <a href="<?php echo e(route('admin.analytics')); ?>" class="bg-yellow-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <i class="bi bi-graph-up text-yellow-600 text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm text-gray-700">Analytics</p>
        </a>
        <a href="<?php echo e(route('admin.pitch-events.index')); ?>" class="bg-red-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <i class="bi bi-megaphone-fill text-red-600 text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm text-gray-700">Pitch Events</p>
        </a>
        <a href="<?php echo e(route('admin.proposals.index')); ?>" class="bg-pink-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <i class="bi bi-lightbulb-fill text-pink-600 text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm text-gray-700">Proposals</p>
            <?php
                $pendingProposals = \App\Models\PitchEventProposal::where('status', 'pending')->count();
            ?>
            <?php if($pendingProposals > 0): ?>
                <p class="text-xs text-pink-600 font-semibold"><?php echo e($pendingProposals); ?> pending</p>
            <?php else: ?>
                <p class="text-xs text-gray-500">No pending</p>
            <?php endif; ?>
        </a>
        <a href="<?php echo e(route('admin.messages')); ?>" class="bg-gray-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <i class="bi bi-chat-dots-fill text-gray-600 text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm text-gray-700">Messages</p>
        </a>
        <a href="<?php echo e(route('admin.training-modules.index')); ?>" class="bg-teal-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <i class="bi bi-book-fill text-teal-600 text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm text-gray-700">Training Modules</p>
            <p class="text-xs text-teal-600 font-semibold"><?php echo e($trainingModuleStats['total_modules']); ?> total</p>
        </a>
    </div>

    <!-- Main Panel -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                <a href="#" class="text-purple-600 text-sm font-medium hover:underline">View All</a>
            </div>
            <div class="space-y-4">
                <?php $__currentLoopData = [
                    ['msg' => 'New entrepreneur profile pending approval', 'by' => 'Amina Hassan', 'status' => 'pending', 'time' => '2 minutes ago'],
                    ['msg' => 'Business Plan Workshop completed', 'by' => 'Dr. Kemi Adebayo', 'status' => 'completed', 'time' => '1 hour ago'],
                    ['msg' => 'Pitch event scheduled for next week', 'by' => 'Grace Mwangi', 'status' => 'scheduled', 'time' => '3 hours ago'],
                    ['msg' => '5 new feedback submissions received', 'by' => 'Multiple Users', 'status' => 'new', 'time' => '1 day ago'],
                    ['msg' => 'New mentorship session completed', 'by' => 'Fatima Al-Rashid', 'status' => 'completed', 'time' => '2 days ago'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-start justify-between bg-gray-50 px-4 py-3 rounded-md hover:bg-gray-100 transition">
                        <div>
                            <p class="font-semibold text-sm text-gray-800"><?php echo e($item['msg']); ?></p>
                            <p class="text-xs text-gray-500">by <?php echo e($item['by']); ?> • <?php echo e($item['time']); ?></p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full
                            <?php if($item['status'] === 'pending'): ?> bg-yellow-100 text-yellow-800
                            <?php elseif($item['status'] === 'completed'): ?> bg-green-100 text-green-800
                            <?php elseif($item['status'] === 'scheduled'): ?> bg-blue-100 text-blue-800
                            <?php else: ?> bg-purple-100 text-purple-800
                            <?php endif; ?>">
                            <?php echo e(ucfirst($item['status'])); ?>

                        </span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Recent Mentorship Sessions -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Recent Sessions</h3>
                <a href="<?php echo e(route('admin.mentorship')); ?>" class="text-purple-600 text-sm font-medium hover:underline">View All</a>
            </div>
            <?php $__empty_1 = true; $__currentLoopData = $recentSessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $bdsp = $session->scheduled_by == $session->pairing->user_one_id ? $session->pairing->userOne : $session->pairing->userTwo;
                    $mentee = $session->scheduled_by == $session->pairing->user_one_id ? $session->pairing->userTwo : $session->pairing->userOne;
                ?>
                <div class="bg-gray-50 rounded-md p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-sm font-semibold text-gray-800"><?php echo e($session->topic ?? 'Mentoring Session'); ?></div>
                        <span class="text-xs px-2 py-1 rounded-full
                            <?php if($session->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                            <?php elseif($session->status === 'confirmed'): ?> bg-green-100 text-green-800
                            <?php else: ?> bg-gray-100 text-gray-800
                            <?php endif; ?>">
                            <?php echo e(ucfirst($session->status)); ?>

                        </span>
                    </div>
                    <div class="text-xs text-gray-500 mb-1">
                        <?php if($session->pairing && $session->pairing->userOne && $session->pairing->userTwo): ?>
                            <strong><?php echo e($session->pairing->userOne->name); ?></strong> → <strong><?php echo e($session->pairing->userTwo->name); ?></strong>
                        <?php else: ?>
                            <strong>N/A</strong> → <strong>N/A</strong>
                        <?php endif; ?>
                    </div>
                    <div class="text-xs text-gray-500 mb-2">
                        <?php echo e($session->date_time->format('M j, Y g:i A')); ?> • <?php echo e($session->duration); ?> min
                    </div>
                    <div class="text-xs text-gray-400"><?php echo e($session->created_at->diffForHumans()); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center text-gray-500 py-4">No recent sessions</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pending Approvals (Quick Access) -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pending Approvals</h3>
            <div class="flex items-center gap-2">
                <span class="text-xs bg-yellow-200 text-yellow-800 px-2 py-1 rounded-full"><?php echo e($totalPending); ?></span>
                <div class="text-xs text-gray-500">
                    <?php if($approvalCounts['users'] > 0): ?>
                        <span class="bg-blue-100 text-blue-800 px-1 rounded"><?php echo e($approvalCounts['users']); ?> Users</span>
                    <?php endif; ?>
                    <?php if($approvalCounts['resources'] > 0): ?>
                        <span class="bg-green-100 text-green-800 px-1 rounded"><?php echo e($approvalCounts['resources']); ?> Resources</span>
                    <?php endif; ?>
                    <?php if($approvalCounts['content'] > 0): ?>
                        <span class="bg-purple-100 text-purple-800 px-1 rounded"><?php echo e($approvalCounts['content']); ?> Content</span>
                    <?php endif; ?>
                    <?php if($approvalCounts['feedback'] > 0): ?>
                        <span class="bg-orange-100 text-orange-800 px-1 rounded"><?php echo e($approvalCounts['feedback']); ?> Feedback</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $pendingApprovals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $approval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-gray-50 rounded-md p-4 mb-4">
                <div class="flex justify-between items-center mb-1">
                    <div class="flex items-center gap-2">
                        <div class="font-semibold text-gray-800"><?php echo e($approval['title']); ?></div>
                        <!-- Type indicator -->
                        <span class="text-xs px-2 py-1 rounded-full
                            <?php if($approval['type'] === 'user'): ?> bg-blue-100 text-blue-800
                            <?php elseif($approval['type'] === 'resource'): ?> bg-green-100 text-green-800
                            <?php elseif($approval['type'] === 'content'): ?> bg-purple-100 text-purple-800
                            <?php elseif($approval['type'] === 'feedback'): ?> bg-orange-100 text-orange-800
                            <?php endif; ?>">
                            <?php echo e(ucfirst($approval['type'])); ?>

                        </span>
                    </div>
                    <div class="text-xs text-gray-400"><?php echo e($approval['time']); ?></div>
                </div>
                <div class="text-sm text-gray-500"><?php echo e($approval['subtitle']); ?></div>
                <div class="text-xs text-gray-400 mb-3"><?php echo e($approval['description']); ?></div>
                <div class="flex gap-2">
                    <?php if($approval['approve_route'] !== '#'): ?>
                        <form action="<?php echo e($approval['approve_route']); ?>" method="POST">
                            <?php echo csrf_field(); ?> <?php echo method_field($approval['approve_method']); ?>
                            <?php if($approval['type'] === 'feedback'): ?>
                                <input type="hidden" name="status" value="reviewed">
                            <?php endif; ?>
                            <button class="px-4 py-2 bg-green-500 text-white text-sm rounded hover:bg-green-600"><?php echo e($approval['approve_text']); ?></button>
                        </form>
                    <?php endif; ?>
                    <a href="<?php echo e($approval['review_route']); ?>" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300">Review</a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center text-gray-500 py-4">No pending approvals.</div>
        <?php endif; ?>
        <div class="mt-4 text-right">
            <a href="<?php echo e(route('admin.user-management')); ?>" class="text-purple-600 text-sm font-medium hover:underline">View All Pending Approvals</a>
        </div>
    </div>

    <!-- Pitch Events Management -->
    <div class="mt-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pitch Events Management</h3>
            <a href="<?php echo e(route('admin.pitch-events.create')); ?>" class="bg-[#b81d8f] text-white px-4 py-2 rounded-md flex items-center gap-2">
                <i class="bi bi-plus-lg"></i> Create Event
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $upcomingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <div class="font-bold text-gray-800"><?php echo e($event['title']); ?></div>
                            <div class="text-sm text-gray-500"><?php echo e($event['event_type'] ?? 'Pitch Event'); ?></div>
                        </div>
                        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded">upcoming</span>
                    </div>
                    <div class="text-sm text-gray-500 mb-2"><i class="bi bi-calendar-event"></i> <?php echo e($event['time']); ?></div>
                    <div class="text-sm text-gray-500 mb-2"><i class="bi bi-people"></i> <?php echo e($event['participants']); ?></div>
                    <div class="text-sm text-gray-500 mb-2">
                        <i class="bi bi-geo-alt"></i> <?php echo e($event['location']); ?>

                    </div>
                    <div class="mb-2">
                        <div class="text-xs text-gray-500 mb-1">Event Details</div>
                        <div class="text-xs text-gray-600">
                            <?php if(isset($event['id'])): ?>
                                <a href="<?php echo e(route('admin.pitch-events.edit', $event['id'])); ?>" class="text-blue-600 hover:underline">Edit Event</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button class="mt-2 w-full bg-gray-100 text-[#b81d8f] font-semibold py-2 rounded hover:bg-gray-200">
                        <?php if(isset($event['id'])): ?>
                            <a href="<?php echo e(route('admin.pitch-events.show', $event['id'])); ?>" class="block">View Details</a>
                        <?php else: ?>
                            View Details
                        <?php endif; ?>
                    </button>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-3 text-center py-8">
                    <div class="text-gray-400 mb-2">
                        <i class="bi bi-calendar-event text-3xl"></i>
                    </div>
                    <p class="text-gray-600">No upcoming pitch events at the moment.</p>
                    <p class="text-gray-500 text-sm mt-1">Create your first pitch event to get started.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Upcoming Training Events (Quick Access) -->
    <div class="mt-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Upcoming Training Events</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $upcomingTrainings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
                    <div>
                        <a href="<?php echo e(route('admin.training_programs.edit', $training->id)); ?>" class="font-semibold text-gray-800 hover:text-[#b81d8f]">
                            <?php echo e($training->title); ?>

                        </a>
                        <div class="text-sm text-gray-500"><?php echo e(\Carbon\Carbon::parse($training->date_time)->format('M d, Y H:i')); ?></div>
                        <div class="text-xs text-gray-400">by <?php echo e($training->facilitator ?? 'N/A'); ?></div>
                    </div>
                    <div class="text-right">
                        <div class="font-semibold text-purple-600"><?php echo e($training->participants_count ?? 0); ?></div>
                        <div class="text-sm text-gray-500">participants</div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div>No upcoming training events.</div>
            <?php endif; ?>
        </div>
        <div class="mt-4 text-right">
            <a href="<?php echo e(route('admin.training_programs')); ?>" class="btn btn-primary">View All Training Programs</a>
        </div>
    </div>

    <!-- Training Modules Overview -->
    <div class="mt-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Training Modules Overview</h3>
        
        <!-- Training Module Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <div class="text-2xl font-bold text-blue-600"><?php echo e($trainingModuleStats['total_modules']); ?></div>
                <div class="text-sm text-gray-600">Total Modules</div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <div class="text-2xl font-bold text-green-600"><?php echo e($trainingModuleStats['published_modules']); ?></div>
                <div class="text-sm text-gray-600">Published</div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <div class="text-2xl font-bold text-yellow-600"><?php echo e($trainingModuleStats['draft_modules']); ?></div>
                <div class="text-sm text-gray-600">Draft</div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <div class="text-2xl font-bold text-purple-600"><?php echo e($trainingModuleStats['total_entrepreneurs_enrolled']); ?></div>
                <div class="text-sm text-gray-600">Enrolled</div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow text-center">
                <div class="text-2xl font-bold text-indigo-600"><?php echo e($trainingModuleStats['active_modules']); ?></div>
                <div class="text-sm text-gray-600">Active</div>
            </div>
        </div>

        <!-- Recent Training Modules -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-semibold text-gray-800">Recent Training Modules</h4>
                    <a href="<?php echo e(route('admin.training-modules.index')); ?>" class="text-blue-600 text-sm font-medium hover:underline">View All</a>
                </div>
                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $recentTrainingModules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-semibold text-sm text-gray-800"><?php echo e($module->title); ?></div>
                                <div class="text-xs text-gray-500">by <?php echo e($module->bdsp->name ?? 'Unknown BDSP'); ?></div>
                                <div class="text-xs text-gray-400"><?php echo e($module->created_at->diffForHumans()); ?></div>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full
                                <?php if($module->status === 'published'): ?> bg-green-100 text-green-800
                                <?php elseif($module->status === 'draft'): ?> bg-yellow-100 text-yellow-800
                                <?php else: ?> bg-gray-100 text-gray-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($module->status)); ?>

                            </span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center text-gray-500 py-4">No training modules yet</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-semibold text-gray-800">BDSP Module Activity</h4>
                    <a href="<?php echo e(route('admin.training-modules.index')); ?>" class="text-blue-600 text-sm font-medium hover:underline">View All</a>
                </div>
                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $bdspModuleActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if($activity->bdsp): ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <div class="font-semibold text-sm text-gray-800"><?php echo e($activity->bdsp->name); ?></div>
                                    <div class="text-xs text-gray-500"><?php echo e($activity->module_count); ?> modules created</div>
                                </div>
                                <div class="text-lg font-bold text-blue-600"><?php echo e($activity->module_count); ?></div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center text-gray-500 py-4">No BDSP activity yet</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ABU-UMAR\Documents\GitHub\backend\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>