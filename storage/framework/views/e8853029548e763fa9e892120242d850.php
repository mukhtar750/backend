<div class="bg-white rounded-2xl shadow p-6 mb-6">
    <h3 class="text-lg font-bold mb-4">Upcoming Tasks</h3>
    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white rounded shadow p-4 mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <div class="font-semibold text-gray-900"><?php echo e($task->title); ?></div>
                <div class="text-xs text-gray-500">Due: <?php echo e($task->due_date->format('Y-m-d')); ?></div>
            </div>
            <?php $submission = $task->submissions()->where('user_id', auth()->id())->latest()->first(); ?>
            <div class="mt-2 md:mt-0 flex gap-2 items-center">
                <?php if(!$submission): ?>
                    <a href="#task-submit-<?php echo e($task->id); ?>" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">Submit</a>
                <?php else: ?>
                    <a href="<?php echo e(route('submissions.show', $submission)); ?>" class="text-green-700 font-semibold hover:underline text-xs">View Submission</a>
                    <span class="ml-2 px-2 py-1 rounded text-xs <?php echo e($submission->status === 'reviewed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>"><?php echo e(ucfirst($submission->status)); ?></span>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div> <?php /**PATH C:\Users\ABU-UMAR\Documents\GitHub\backend\resources\views/dashboard/partials/entrepreneur/upcoming-tasks.blade.php ENDPATH**/ ?>