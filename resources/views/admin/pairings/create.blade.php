@extends('admin.layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Create New Pairing</h2>
        
        <!-- Debug Info -->
        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded">
            <p class="text-sm text-blue-800">
                <strong>Available Users:</strong><br>
                Mentors: {{ $mentors->count() }} | Mentees: {{ $mentees->count() }} | 
                BDSP: {{ $bdsp->count() }} | Entrepreneurs: {{ $entrepreneurs->count() }} | 
                Investors: {{ $investors->count() }}
            </p>
            <p class="text-sm text-blue-800 mt-2">
                <strong>Note:</strong> After creating a pairing, you'll be redirected to User Management. 
                Click the "Pairings" tab to see your new pairing.
            </p>
        </div>
        
        @if(session('error'))
            <div class="mb-4 text-red-600">{{ session('error') }}</div>
        @endif
        
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <div id="ajax-message"></div>
        <form id="pairingForm" action="{{ route('admin.pairings.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="pairing_type" class="block text-gray-700 font-semibold mb-2">Pairing Type</label>
                <select name="pairing_type" id="pairing_type" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Select pairing type</option>
                    <option value="mentor_mentee">Mentor ↔ Mentee</option>
                    <option value="bdsp_entrepreneur">BDSP ↔ Entrepreneur</option>
                    <option value="investor_entrepreneur">Investor ↔ Entrepreneur</option>
                </select>
            </div>
            <div id="user-selectors">
                <div class="mb-4" id="mentor_mentee_selectors" style="display:none;">
                    <label class="block text-gray-700 font-semibold mb-2">Mentor</label>
                    <select name="user_one_id" class="w-full border-gray-300 rounded-md shadow-sm mb-2">
                        <option value="">Select Mentor</option>
                        @foreach($mentors as $mentor)
                            <option value="{{ $mentor->id }}">{{ $mentor->name }} ({{ $mentor->email }})</option>
                        @endforeach
                    </select>
                    <label class="block text-gray-700 font-semibold mb-2">Mentee</label>
                    <select name="user_two_id" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Select Mentee</option>
                        @foreach($mentees as $mentee)
                            <option value="{{ $mentee->id }}">{{ $mentee->name }} ({{ $mentee->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4" id="bdsp_entrepreneur_selectors" style="display:none;">
                    <label class="block text-gray-700 font-semibold mb-2">BDSP</label>
                    <select name="user_one_id" class="w-full border-gray-300 rounded-md shadow-sm mb-2">
                        <option value="">Select BDSP</option>
                        @foreach($bdsp as $b)
                            <option value="{{ $b->id }}">{{ $b->name }} ({{ $b->email }})</option>
                        @endforeach
                    </select>
                    <label class="block text-gray-700 font-semibold mb-2">Entrepreneur</label>
                    <select name="user_two_id" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Select Entrepreneur</option>
                        @foreach($entrepreneurs as $e)
                            <option value="{{ $e->id }}">{{ $e->name }} ({{ $e->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4" id="investor_entrepreneur_selectors" style="display:none;">
                    <label class="block text-gray-700 font-semibold mb-2">Investor</label>
                    <select name="user_one_id" class="w-full border-gray-300 rounded-md shadow-sm mb-2">
                        <option value="">Select Investor</option>
                        @foreach($investors as $inv)
                            <option value="{{ $inv->id }}">{{ $inv->name }} ({{ $inv->email }})</option>
                        @endforeach
                    </select>
                    <label class="block text-gray-700 font-semibold mb-2">Entrepreneur</label>
                    <select name="user_two_id" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Select Entrepreneur</option>
                        @foreach($entrepreneurs as $e)
                            <option value="{{ $e->id }}">{{ $e->name }} ({{ $e->email }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Pairing</button>
                <a href="{{ route('admin.user-management') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
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
        mentorMentee.querySelectorAll('select').forEach(sel => sel.removeAttribute('name'));
        bdspEntrepreneur.querySelectorAll('select').forEach(sel => sel.removeAttribute('name'));
        investorEntrepreneur.querySelectorAll('select').forEach(sel => sel.removeAttribute('name'));
        if (pairingType.value === 'mentor_mentee') {
            mentorMentee.style.display = 'block';
            mentorMentee.querySelectorAll('select')[0].setAttribute('name', 'user_one_id');
            mentorMentee.querySelectorAll('select')[1].setAttribute('name', 'user_two_id');
        } else if (pairingType.value === 'bdsp_entrepreneur') {
            bdspEntrepreneur.style.display = 'block';
            bdspEntrepreneur.querySelectorAll('select')[0].setAttribute('name', 'user_one_id');
            bdspEntrepreneur.querySelectorAll('select')[1].setAttribute('name', 'user_two_id');
        } else if (pairingType.value === 'investor_entrepreneur') {
            investorEntrepreneur.style.display = 'block';
            investorEntrepreneur.querySelectorAll('select')[0].setAttribute('name', 'user_one_id');
            investorEntrepreneur.querySelectorAll('select')[1].setAttribute('name', 'user_two_id');
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
                setTimeout(() => { window.location.href = "{{ route('admin.user-management', ['tab' => 'pairings']) }}"; }, 1200);
            } else {
                ajaxMsg.innerHTML = '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative flex items-center">' +
                    '<svg class="h-5 w-5 mr-2 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>' +
                    '<span>Pairing created successfully.</span></div>';
                setTimeout(() => { window.location.href = "{{ route('admin.user-management', ['tab' => 'pairings']) }}"; }, 1200);
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
@endsection 