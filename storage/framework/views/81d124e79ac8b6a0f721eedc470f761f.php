

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto mt-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Assigned Tasks</h1>
        <a href="<?php echo e(route('tasks.create')); ?>" class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-purple-700 transition">+ Assign New Task</a>
    </div>
    <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <div class="flex justify-between items-center mb-2">
                <div>
                    <h2 class="font-bold text-lg"><?php echo e($task->title); ?></h2>
                    <div class="text-xs text-gray-500">Due: <?php echo e($task->due_date->format('Y-m-d')); ?></div>
                </div>
                <span class="px-2 py-1 rounded text-xs <?php echo e($task->getStatusClass()); ?>"><?php echo e($task->getStatusLabel()); ?></span>
            </div>
            <div class="mb-2 text-gray-700"><?php echo e($task->description); ?></div>
            <div class="text-xs text-gray-500">Assigned to: <?php echo e($task->assignee->name); ?></div>
            <?php if($task->submissions->count()): ?>
                <div class="mt-4">
                    <h3 class="font-semibold mb-2">Submissions</h3>
                    <?php $__currentLoopData = $task->submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-2 flex items-center gap-2">
                            <a href="<?php echo e(route('submissions.show', $submission)); ?>" class="text-blue-600 hover:underline">
                                View Submission by <?php echo e($submission->user->name); ?>

                            </a>
                            <span class="ml-2 px-2 py-1 rounded text-xs <?php echo e($submission->status === 'reviewed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                <?php echo e(ucfirst($submission->status)); ?>

                            </span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="bg-white rounded-xl shadow p-6 text-center text-gray-400">
            <i class="bi bi-inbox" style="font-size:2rem;"></i>
            <div class="mt-2">No tasks assigned yet.</div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.bdsp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ABU-UMAR\Documents\GitHub\backend\resources\views/bdsp/tasks.blade.php ENDPATH**/ ?>