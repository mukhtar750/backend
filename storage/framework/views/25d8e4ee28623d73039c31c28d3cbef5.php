<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">User Management</h1>
    <a href="#" class="flex items-center gap-2 bg-pink-600 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-pink-700 transition text-base font-bold border-2 border-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-300">
        <i class="bi bi-download text-xl"></i>
        Export Data
    </a>
</div>

<?php if(session('success')): ?>
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
        <span class="block sm:inline"><?php echo e(session('success')); ?></span>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
        <span class="block sm:inline"><?php echo e(session('error')); ?></span>
    </div>
<?php endif; ?>

<!-- Tabs -->
<div x-data="{ tab: '<?php echo e(request('tab', 'users')); ?>' }" class="mb-6">
    <nav class="flex space-x-4 border-b border-gray-200">
        <button @click="tab = 'users'" :class="tab === 'users' ? 'border-b-2 border-[#b81d8f] text-[#b81d8f]' : 'text-gray-500'" class="px-4 py-2 font-semibold focus:outline-none">Users</button>
        <button @click="tab = 'pairings'" :class="tab === 'pairings' ? 'border-b-2 border-[#b81d8f] text-[#b81d8f]' : 'text-gray-500'" class="px-4 py-2 font-semibold focus:outline-none">Pairings</button>
        <button @click="tab = 'startup-profiles'" :class="tab === 'startup-profiles' ? 'border-b-2 border-[#b81d8f] text-[#b81d8f]' : 'text-gray-500'" class="px-4 py-2 font-semibold focus:outline-none">Startup Profiles</button>
        <button @click="tab = 'info-requests'" :class="tab === 'info-requests' ? 'border-b-2 border-[#b81d8f] text-[#b81d8f]' : 'text-gray-500'" class="px-4 py-2 font-semibold focus:outline-none">Info Requests</button>
    </nav>

    <!-- Users Tab -->
    <div x-show="tab === 'users'" class="mt-6">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <input type="text" placeholder="Search users..." class="form-input rounded-lg border-gray-300 shadow-sm focus:border-magenta focus:ring focus:ring-magenta-200 focus:ring-opacity-50">
            <select class="form-select rounded-lg border-gray-300 shadow-sm focus:border-magenta focus:ring focus:ring-magenta-200 focus:ring-opacity-50">
                <option>All Roles</option>
                <option>Entrepreneur</option>
                <option>BDSP</option>
                <option>Investor</option>
            </select>
            <select class="form-select rounded-lg border-gray-300 shadow-sm focus:border-custom-purple focus:ring focus:ring-custom-purple-200 focus:ring-opacity-50">
                <option>All Status</option>
                <option>Pending</option>
                <option>Approved</option>
                <option>Rejected</option>
            </select>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <?php $__currentLoopData = ['User', 'Role', 'Status', 'Join Date', 'Last Active', 'Actions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $heading): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e($heading); ?></th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $allUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <i class="bi bi-person text-gray-600"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($user->name); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($user->email); ?></div>
                                    <div class="text-xs text-gray-400"><?php echo e($user->location ?? 'N/A'); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800"><?php echo App\Helpers\RoleHelper::displayRole($user->role); ?></span>
                            <div class="text-xs text-gray-500"><?php echo e($user->company ?? 'N/A'); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($user->is_approved): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                            <?php else: ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($user->created_at->format('Y-m-d')); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($user->last_active ?? 'N/A'); ?></td>
                        <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                            <a href="<?php echo e(route('admin.editUser', $user->id)); ?>" class="text-indigo-600 hover:text-indigo-900"><i class="bi bi-pencil"></i> Edit</a>
                            <?php if(!$user->is_approved): ?>
                                <form action="<?php echo e(route('admin.approve', $user->id)); ?>" method="POST" class="inline-block">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="text-green-600 hover:text-green-900"><i class="bi bi-person-check"></i> Approve</button>
                                </form>
                                <form action="<?php echo e(route('admin.reject', $user->id)); ?>" method="POST" class="inline-block">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-900"><i class="bi bi-person-x"></i> Decline</button>
                                </form>
                            <?php endif; ?>
                            <form action="<?php echo e(route('admin.destroy', $user->id)); ?>" method="POST" class="inline-block">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900"><i class="bi bi-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pairings Tab -->
    <div x-show="tab === 'pairings'" class="mt-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Mentorship Pairings</h3>
            <a href="<?php echo e(route('admin.pairings.create')); ?>" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                <i class="bi bi-plus-circle mr-2"></i>Create Pairing
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mentor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mentee</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mentorship Agreement</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if($pairings->count() > 0): ?>
                        <?php $__currentLoopData = $pairings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pairing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <i class="bi bi-person text-gray-600"></i>
                                        </div>
                                    </div>
                                                                        <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?php echo e($pairing->userOne->name ?? 'N/A'); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo e($pairing->userOne ? \App\Helpers\RoleHelper::displayRole($pairing->userOne->role) : 'N/A'); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <i class="bi bi-person text-gray-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?php echo e($pairing->userTwo->name ?? 'N/A'); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo e($pairing->userTwo ? \App\Helpers\RoleHelper::displayRole($pairing->userTwo->role) : 'N/A'); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($pairing->created_at->format('M d, Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="<?php echo e(route('admin.pairings.destroy', $pairing->id)); ?>" method="POST" class="inline-block">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="bi bi-trash"></i> Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                             <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                 No pairings found. <a href="<?php echo e(route('admin.pairings.create')); ?>" class="text-blue-600 hover:underline">Create your first pairing</a>
                             </td>
                         </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Startup Profiles Tab -->
    <div x-show="tab === 'startup-profiles'" class="mt-6">
        <?php if($startups->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Startup</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Founder</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sector</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $startups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $startup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <?php if($startup->logo): ?>
                                            <img class="h-10 w-10 rounded-full" src="<?php echo e(asset('storage/' . $startup->logo)); ?>" alt="<?php echo e($startup->name); ?>">
                                        <?php else: ?>
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <i class="bi bi-building text-gray-600"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?php echo e($startup->name); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo e($startup->tagline ?? 'No tagline'); ?></div>
                                        <div class="text-xs text-gray-400"><?php echo e($startup->website ?? 'No website'); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo e($startup->founder->name ?? 'Unknown'); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($startup->founder->email ?? 'No email'); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <?php echo e($startup->sector ?? 'N/A'); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($startup->status === 'approved'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                <?php elseif($startup->status === 'pending'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                <?php elseif($startup->status === 'rejected'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                <?php else: ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800"><?php echo e(ucfirst($startup->status)); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($startup->created_at->format('M d, Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="<?php echo e(route('admin.startups.show', $startup->id)); ?>" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <?php if($startup->status === 'pending'): ?>
                                    <form action="<?php echo e(route('admin.startups.approve', $startup->id)); ?>" method="POST" class="inline-block">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="text-green-600 hover:text-green-900">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('admin.startups.reject', $startup->id)); ?>" method="POST" class="inline-block">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="bi bi-building text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Startup Profiles</h3>
                <p class="text-gray-500">No startup profiles have been submitted yet.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Info Requests Tab -->
    <div x-show="tab === 'info-requests'" class="mt-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Startup Info Requests</h3>
            <div class="flex gap-2">
                <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-purple-500 focus:border-purple-500">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>
        
        <?php if(isset($startupInfoRequests) && $startupInfoRequests->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Investor</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Startup</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $startupInfoRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <i class="bi bi-person text-gray-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?php echo e($request->investor->name); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo e($request->investor->email); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($request->startup->name); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($request->startup->sector ?? 'N/A'); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($request->status === 'pending'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                <?php elseif($request->status === 'approved'): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Approved
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($request->created_at->format('M d, Y H:i')); ?>

                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <?php echo e(Str::limit($request->request_message ?? 'No message provided', 50)); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <?php if($request->status === 'pending'): ?>
                                    <form action="<?php echo e(route('admin.startup-info-requests.approve', $request->id)); ?>" method="POST" class="inline-block">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="text-green-600 hover:text-green-900">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('admin.startup-info-requests.reject', $request->id)); ?>" method="POST" class="inline-block">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="bi bi-x-circle"></i> Reject
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-gray-400">
                                        <?php if($request->status === 'approved'): ?>
                                            Approved <?php echo e($request->approved_at ? $request->approved_at->format('M d, Y') : ''); ?>

                                        <?php else: ?>
                                            Rejected <?php echo e($request->rejected_at ? $request->rejected_at->format('M d, Y') : ''); ?>

                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="bi bi-inbox text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Info Requests</h3>
                <p class="text-gray-500">No startup information requests have been made yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>


<?php if(isset($users) && !$users->isEmpty()): ?>
<div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Users Awaiting Approval</h3>
    </div>
    <div class="border-t border-gray-200">
        <dl>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $row = [
                        'Name' => $user->name,
                        'Email' => $user->email,
                        'Role' => $user->role,
                    ];
                ?>
                <?php $__currentLoopData = $row; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="<?php echo e($loop->even ? 'bg-white' : 'bg-gray-50'); ?> px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500"><?php echo e($label); ?></dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"><?php echo e($value); ?></dd>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Actions</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 flex space-x-3">
                        <form action="<?php echo e(route('admin.approve', $user->id)); ?>" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn-approve">Approve</button>
                        </form>
                        <form action="<?php echo e(route('admin.reject', $user->id)); ?>" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn-reject">Reject</button>
                        </form>
                        <form action="<?php echo e(route('admin.destroy', $user->id)); ?>" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </dd>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </dl>
    </div>
</div>
<?php else: ?>
<p class="text-center text-gray-600 py-4">No pending users for approval.</p>
<?php endif; ?>


<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <?php $__currentLoopData = [
        ['label' => 'Total Users', 'value' => 4, 'icon' => 'bi-people'],
        ['label' => 'Pending Approval', 'value' => 1, 'icon' => 'bi-person-check'],
        ['label' => 'Entrepreneurs', 'value' => 2, 'icon' => 'bi-person-workspace'],
        ['label' => 'Active This Week', 'value' => 4, 'icon' => 'bi-graph-up'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
            <div>
                <div class="text-gray-500"><?php echo e($card['label']); ?></div>
                <div class="text-2xl font-bold"><?php echo e($card['value']); ?></div>
            </div>
            <i class="bi <?php echo e($card['icon']); ?> text-magenta text-4xl"></i>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ABU-UMAR\Documents\GitHub\backend\resources\views/admin/user-management.blade.php ENDPATH**/ ?>