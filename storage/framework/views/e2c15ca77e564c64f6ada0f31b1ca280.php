<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'BDSP Dashboard'); ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="<?php echo e(asset('images/logo.jpg')); ?>">
    <link rel="shortcut icon" type="image/jpeg" href="<?php echo e(asset('images/logo.jpg')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/logo.jpg')); ?>">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-[#6c3483] text-white flex flex-col">
            <div class="p-4 text-xl md:text-2xl font-bold border-b border-[#512e5f] whitespace-nowrap overflow-hidden text-ellipsis" title="Venture Ready Portal">
                VR Portal
            </div>
            <div class="p-4 text-sm border-b border-[#a01a7d] tracking-wide">
                BDSP Panel
            </div>
            <nav class="flex-1 px-4 space-y-2 mt-4">
                <?php $route = Route::currentRouteName(); ?>
                <a href="<?php echo e(route('bdsp.dashboard')); ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 <?php echo e($route == 'bdsp.dashboard' ? 'bg-white text-purple-800 font-semibold shadow-sm' : ''); ?>">
                    <i class="bi bi-grid-fill"></i> Dashboard
                </a>
                <a href="<?php echo e(route('bdsp.mentees')); ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 <?php echo e($route == 'bdsp.mentees' ? 'bg-white text-purple-800 font-semibold shadow-sm' : ''); ?>">
                    <i class="bi bi-person-lines-fill"></i> My Mentees
                </a>
                <a href="<?php echo e(route('bdsp.resources.index')); ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 <?php echo e($route == 'bdsp.resources.index' ? 'bg-white text-purple-800 font-semibold shadow-sm' : ''); ?>">
                    <i class="bi bi-upload"></i> Upload Resources
                </a>
                <a href="<?php echo e(route('bdsp.training-modules.index')); ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 <?php echo e(request()->routeIs('bdsp.training-modules.*') ? 'bg-white text-purple-800 font-semibold shadow-sm' : ''); ?>">
                    <i class="bi bi-book"></i> Training Modules
                </a>
                <a href="<?php echo e(route('bdsp.schedule-session-page')); ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 <?php echo e($route == 'bdsp.schedule-session-page' ? 'bg-white text-purple-800 font-semibold shadow-sm' : ''); ?>">
                    <i class="bi bi-calendar-event"></i> Sessions
                </a>
                <a href="<?php echo e(route('bdsp.reports')); ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 <?php echo e($route == 'bdsp.reports' ? 'bg-white text-purple-800 font-semibold shadow-sm' : ''); ?>">
                    <i class="bi bi-file-earmark-text"></i> Reports
                </a>
                <a href="<?php echo e(route('bdsp.messages')); ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 <?php echo e($route == 'bdsp.messages' ? 'bg-white text-purple-800 font-semibold shadow-sm' : ''); ?>">
                    <i class="bi bi-chat-dots"></i> Messages
                </a>
                <a href="<?php echo e(route('bdsp.feedback')); ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 <?php echo e($route == 'bdsp.feedback' ? 'bg-white text-purple-800 font-semibold shadow-sm' : ''); ?>">
                    <i class="bi bi-chat-left-text"></i> Feedback
                </a>
                <a href="<?php echo e(route('bdsp.practice-pitches.index')); ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 <?php echo e($route == 'bdsp.practice-pitches.index' ? 'bg-white text-purple-800 font-semibold shadow-sm' : ''); ?>">
    <i class="bi bi-mic-fill"></i> Practice Pitches
</a>
                <a href="<?php echo e(route('bdsp.tasks.index')); ?>" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition-all duration-300 <?php echo e(request()->routeIs('bdsp.tasks.*') ? 'bg-white text-[#6c3483] font-semibold shadow-sm' : 'hover:bg-purple-700'); ?>">
                    <i class="fas fa-tasks mr-3"></i>
                    <span>Tasks</span>
                </a>
                <a href="<?php echo e(route('ideas.index')); ?>" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition-all duration-300 <?php echo e(request()->routeIs('ideas.*') ? 'bg-white text-[#6c3483] font-semibold shadow-sm' : 'hover:bg-yellow-400 hover:text-[#6c3483]'); ?>">
                    <i class="fas fa-lightbulb mr-3"></i>
                    <span>Ideas Bank</span>
                </a>
            </nav>
            <div class="p-4 border-t border-[#512e5f]">
                <div class="flex items-center mb-3">
                    <img class="h-10 w-10 rounded-full mr-3 border border-white object-cover" 
                         src="<?php echo e(Auth::user()->getProfilePictureUrl()); ?>" 
                         alt="<?php echo e(Auth::user()->name); ?>">
                    <div>
                        <div class="font-semibold"><?php echo e(Auth::user()->name); ?></div>
                        <div class="text-sm text-purple-100"><?php echo e(Auth::user()->email); ?></div>
                    </div>
                </div>
                <a href="<?php echo e(route('profile.show')); ?>" class="flex items-center px-4 py-2 text-white hover:bg-[#512e5f] rounded-lg transition-all font-medium">
                    <i class="bi bi-person-fill mr-3"></i> My Profile
                </a>
                <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-[#512e5f] rounded-lg transition-all font-medium">
                    <i class="bi bi-gear-fill mr-3"></i> Settings
                </a>
                <form action="<?php echo e(route('logout')); ?>" method="POST" class="mt-1">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-white hover:bg-[#512e5f] rounded-lg transition-all font-medium">
                        <i class="bi bi-box-arrow-right mr-3"></i> Logout
                    </button>
                </form>
            </div>
        </div>
        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="flex items-center justify-between p-4 bg-white border-b shadow-sm">
                <div class="flex items-center">
                    <h1 class="text-2xl font-semibold text-gray-800"><i class="bi bi-grid-fill mr-2"></i> Dashboard</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..." class="border border-gray-300 rounded-md py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-[#6c3483]">
                        <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <?php echo $__env->make('components.notification-badge', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <a href="<?php echo e(route('bdsp.messages')); ?>" class="relative text-gray-600 hover:text-gray-800 mr-2">
                        <i class="bi bi-chat-dots-fill text-xl"></i>
                        <?php
                            $unreadMessages = auth()->check() ? auth()->user()->getUnreadMessageCount() : 0;
                        ?>
                        <?php if($unreadMessages > 0): ?>
                            <span class="absolute -top-2 -right-2 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold text-white bg-blue-500 rounded-full min-w-[18px]">
                                <?php echo e($unreadMessages > 99 ? '99+' : $unreadMessages); ?>

                            </span>
                        <?php endif; ?>
                    </a>
                    <div class="flex items-center">
                        <img class="h-8 w-8 rounded-full mr-2 object-cover" 
                             src="<?php echo e(Auth::user()->getProfilePictureUrl()); ?>" 
                             alt="<?php echo e(Auth::user()->name); ?>">
                        <div>
                            <div class="font-semibold text-gray-800"><?php echo e(Auth::user()->name); ?></div>
                            <div class="text-sm text-gray-500">BDSP</div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- age Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\ABU-UMAR\Documents\GitHub\backend\resources\views/layouts/bdsp.blade.php ENDPATH**/ ?>