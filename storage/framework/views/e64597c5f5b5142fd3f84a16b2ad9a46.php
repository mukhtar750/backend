<div class="rounded-2xl p-8 bg-gradient-to-r from-[#7b2ff2] to-[#f357a8] text-white shadow-lg mb-6">
    <div class="flex flex-col gap-6">
        <div>
            <h2 class="text-3xl md:text-4xl font-bold mb-2">Welcome back, <?php echo e($name ?? Auth::user()->name ?? 'Entrepreneur'); ?>! <span class="inline-block">👋</span></h2>
            <p class="text-base text-pink-100 max-w-xl">You're making excellent progress in your investment readiness journey.</p>
        </div>
        <div class="flex flex-col md:flex-row gap-4 w-full mt-4">
            <div class="flex-1 min-w-[180px] rounded-xl px-6 py-5 border border-white/30 bg-white/20 backdrop-blur-md shadow-sm flex flex-col items-start justify-center">
                <span class="text-xs text-white/80 mb-1">Next Milestone</span>
                <span class="font-semibold text-lg text-white"><?php echo e($milestone ?? 'Pitch Deck Completion'); ?></span>
            </div>
            <div class="flex-1 min-w-[180px] rounded-xl px-6 py-5 border border-white/30 bg-white/20 backdrop-blur-md shadow-sm flex flex-col items-start justify-center">
                <span class="text-xs text-white/80 mb-1">Days Left</span>
                <span class="font-semibold text-lg text-white"><?php echo e($daysLeft ?? '14 days'); ?></span>
            </div>
            <div class="flex-1 min-w-[180px] rounded-xl px-6 py-5 border border-white/30 bg-white/20 backdrop-blur-md shadow-sm flex flex-col items-start justify-center">
                <span class="text-xs text-white/80 mb-1">Total Points</span>
                <span class="font-semibold text-lg text-white"><?php echo e($points ?? '1,250 pts'); ?></span>
            </div>
            <div class="flex-1 min-w-[180px] flex flex-col items-center justify-center mt-4 md:mt-0">
                <div class="flex flex-wrap gap-3">
                    <a href="<?php echo e(route('entrepreneur.training-modules.index')); ?>" 
                       class="inline-flex items-center px-4 py-2 bg-[#b81d8f] text-white rounded-lg hover:bg-[#a01a7d] transition">
                        <i class="bi bi-book mr-2"></i>Training Modules
                    </a>
                    <a href="<?php echo e(route('entrepreneur.progress.dashboard')); ?>" 
                       class="inline-flex items-center px-4 py-2 bg-white text-[#b81d8f] border border-[#b81d8f] rounded-lg hover:bg-[#b81d8f] hover:text-white transition">
                        <i class="bi bi-graph-up mr-2"></i>My Progress
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> <?php /**PATH C:\Users\ABU-UMAR\Documents\GitHub\backend\resources\views/dashboard/partials/entrepreneur/welcome-banner.blade.php ENDPATH**/ ?>