

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">My Assignments & Tasks</h1>
    <?php echo $__env->make('dashboard.entrepreneur-tasks', ['tasks' => $tasks], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.entrepreneur', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ABU-UMAR\Documents\GitHub\backend\resources\views/entrepreneur/tasks.blade.php ENDPATH**/ ?>