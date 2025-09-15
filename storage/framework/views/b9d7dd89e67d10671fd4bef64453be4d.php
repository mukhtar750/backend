

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Create New Pairing</h2>
        
        <!-- Debug Info -->
        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded">
            <p class="text-sm text-blue-800">
                <strong>Available Users:</strong><br>
                Mentors: <?php echo e($mentors->count()); ?> | Mentees: <?php echo e($mentees->count()); ?> | 
                BDSP: <?php echo e($bdsp->count()); ?> | Entrepreneurs: <?php echo e($entrepreneurs->count()); ?> | 
                Investors: <?php echo e($investors->count()); ?>

            </p>
            <p class="text-sm text-blue-800 mt-2">
                <strong>Note:</strong> After creating a pairing, you'll be redirected to User Management. 
                Click the "Pairings" tab to see your new pairing.
            </p>
        </div>
        
        <?php if(session('error')): ?>
            <div class="mb-4 text-red-600"><?php echo e(session('error')); ?></div>
        <?php endif; ?>
        
        <?php if(session('success')): ?>
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <span class="block sm:inline"><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>
        <div id="ajax-message"></div>
        <form id="pairingForm" action="<?php echo e(route('admin.pairings.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label for="pairing_type" class="block text-gray-700 font-semibold mb-2">Pairing Type</label>
                <select name="pairing_type" id="pairing_type" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Select pairing type</option>
                    <option value="bdsp_entrepreneur">BDSP ↔ Entrepreneur</option>
                    <option value="investor_entrepreneur">Investor ↔ Entrepreneur</option>
                    <option value="mentor_entrepreneur">Mentor ↔ Entrepreneur</option>
                    <option value="mentor_mentee">Mentor ↔ Mentee</option>
                </select>
            </div>
            <div id="user-selectors">
                <div class="mb-4" id="mentor_mentee_selectors" style="display:none;">
                    <label class="block text-gray-700 font-semibold mb-2">Mentor</label>
                    <select name="user_one_id" class="w-full border-gray-300 rounded-md shadow-sm mb-2">
                        <option value="">Select Mentor</option>
                        <?php $__currentLoopData = $mentors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($mentor->id); ?>"><?php echo e($mentor->name); ?> (<?php echo e($mentor->email); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <label class="block text-gray-700 font-semibold mb-2">Mentee</label>
                    <select name="user_two_id" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Select Mentee</option>
                        <?php $__currentLoopData = $mentees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($mentee->id); ?>"><?php echo e($mentee->name); ?> (<?php echo e($mentee->email); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="mb-4" id="bdsp_entrepreneur_selectors" style="display:none;">
                    <label class="block text-gray-700 font-semibold mb-2">BDSP</label>
                    <select name="user_one_id" class="w-full border-gray-300 rounded-md shadow-sm mb-2">
                        <option value="">Select BDSP</option>
                        <?php $__currentLoopData = $bdsp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($b->id); ?>"><?php echo e($b->name); ?> (<?php echo e($b->email); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <label class="block text-gray-700 font-semibold mb-2">Entrepreneur(s)</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                        <?php $__currentLoopData = $entrepreneurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="user_two_id[]" value="<?php echo e($e->id); ?>" class="form-checkbox">
                                <span class="ml-2"><?php echo e($e->name); ?> (<?php echo e($e->email); ?>)</span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="mb-4" id="investor_entrepreneur_selectors" style="display:none;">
                    <label class="block text-gray-700 font-semibold mb-2">Investor</label>
                    <select name="user_one_id" class="w-full border-gray-300 rounded-md shadow-sm mb-2">
                        <option value="">Select Investor</option>
                        <?php $__currentLoopData = $investors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($inv->id); ?>"><?php echo e($inv->name); ?> (<?php echo e($inv->email); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <label class="block text-gray-700 font-semibold mb-2">Entrepreneur(s)</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                        <?php $__currentLoopData = $entrepreneurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="user_two_id[]" value="<?php echo e($e->id); ?>" class="form-checkbox">
                                <span class="ml-2"><?php echo e($e->name); ?> (<?php echo e($e->email); ?>)</span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="mb-4" id="mentor_entrepreneur_selectors" style="display:none;">
                    <label class="block text-gray-700 font-semibold mb-2">Mentor</label>
                    <select class="w-full border-gray-300 rounded-md shadow-sm mb-2">
                        <option value="">Select Mentor</option>
                        <?php $__currentLoopData = $mentors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($mentor->id); ?>"><?php echo e($mentor->name); ?> (<?php echo e($mentor->email); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <label class="block text-gray-700 font-semibold mb-2">Entrepreneur</label>
                    <select class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Select Entrepreneur</option>
                        <?php $__currentLoopData = $entrepreneurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($e->id); ?>"><?php echo e($e->name); ?> (<?php echo e($e->email); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Pairing</button>
                <a href="<?php echo e(route('admin.user-management')); ?>" class="ml-4 text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pairingType = document.getElementById('pairing_type');
    const mentorMentee = document.getElementById('mentor_mentee_selectors');
    const bdspEntrepreneur = document.getElementById('bdsp_entrepreneur_selectors');
    const investorEntrepreneur = document.getElementById('investor_entrepreneur_selectors');
    const form = document.getElementById('pairingForm');
    const ajaxMsg = document.getElementById('ajax-message');

    function updateSelectors() {
        mentorMentee.style.display = 'none';
        bdspEntrepreneur.style.display = 'none';
        investorEntrepreneur.style.display = 'none';
        const mentorEntrepreneur = document.getElementById('mentor_entrepreneur_selectors');
        if (mentorEntrepreneur) {
            mentorEntrepreneur.style.display = 'none';
            mentorEntrepreneur.querySelectorAll('select').forEach(sel => sel.removeAttribute('name'));
        }
        // Clear name attributes from all possible user_one_id and user_two_id elements
        document.querySelectorAll('[name="user_one_id"], [name="user_two_id"], [name="user_two_id[]"]').forEach(el => {
            el.removeAttribute('name');
        });

        // Set name attributes for the active section
        if (pairingType.value === 'mentor_mentee') {
            mentorMentee.style.display = 'block';
            mentorMentee.querySelector('select:nth-of-type(1)').setAttribute('name', 'user_one_id');
            mentorMentee.querySelector('select:nth-of-type(2)').setAttribute('name', 'user_two_id');
        } else if (pairingType.value === 'bdsp_entrepreneur') {
            bdspEntrepreneur.style.display = 'block';
            bdspEntrepreneur.querySelector('select:nth-of-type(1)').setAttribute('name', 'user_one_id');
            bdspEntrepreneur.querySelectorAll('input[type="checkbox"]').forEach(chk => chk.setAttribute('name', 'user_two_id[]'));
        } else if (pairingType.value === 'investor_entrepreneur') {
            investorEntrepreneur.style.display = 'block';
            investorEntrepreneur.querySelector('select:nth-of-type(1)').setAttribute('name', 'user_one_id');
            investorEntrepreneur.querySelectorAll('input[type="checkbox"]').forEach(chk => chk.setAttribute('name', 'user_two_id[]'));
        } else if (pairingType.value === 'mentor_entrepreneur') {
            mentorEntrepreneur.style.display = 'block';
            mentorEntrepreneur.querySelector('select:nth-of-type(1)').setAttribute('name', 'user_one_id');
            mentorEntrepreneur.querySelector('select:nth-of-type(2)').setAttribute('name', 'user_two_id');
        }
    }
    pairingType.addEventListener('change', updateSelectors);
    updateSelectors();

    // AJAX form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        ajaxMsg.innerHTML = '';
        const formData = new FormData(form);
        ajaxMsg.innerHTML = '<div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative flex items-center"><svg class="animate-spin h-5 w-5 mr-2 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>Processing...</div>';
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json().catch(() => response))
        .then(data => {
            ajaxMsg.innerHTML = '';
            if (data.errors) {
                let errorHtml = '<div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative flex items-center">';
                errorHtml += '<svg class="h-5 w-5 mr-2 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
                errorHtml += '<ul class="ml-2">';
                Object.values(data.errors).forEach(errArr => {
                    errArr.forEach(err => errorHtml += `<li>${err}</li>`);
                });
                errorHtml += '</ul></div>';
                ajaxMsg.innerHTML = errorHtml;
            } else if (data.message || data.success) {
                ajaxMsg.innerHTML = '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative flex items-center">' +
                    '<svg class="h-5 w-5 mr-2 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>' +
                    '<span>' + (data.message || data.success) + '</span></div>';
                setTimeout(() => { window.location.href = "<?php echo e(route('admin.user-management', ['tab' => 'pairings'])); ?>"; }, 1200);
            } else {
                ajaxMsg.innerHTML = '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative flex items-center">' +
                    '<svg class="h-5 w-5 mr-2 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>' +
                    '<span>Pairing created successfully.</span></div>';
                setTimeout(() => { window.location.href = "<?php echo e(route('admin.user-management', ['tab' => 'pairings'])); ?>"; }, 1200);
            }
        })
        .catch(() => {
            ajaxMsg.innerHTML = '<div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative flex items-center">' +
                '<svg class="h-5 w-5 mr-2 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>' +
                '<span>Something went wrong. Please try again.</span></div>';
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ABU-UMAR\Documents\GitHub\backend\resources\views/admin/pairings/create.blade.php ENDPATH**/ ?>