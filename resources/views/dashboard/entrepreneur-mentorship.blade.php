@extends('layouts.entrepreneur')
@section('title', 'Mentorship')
@section('content')
<div x-data="mentorshipBooking({{ json_encode($professionalsArray) }})" class="max-w-5xl mx-auto mt-10">
    <!-- Header and Book New Session Button -->
    <div class="flex justify-between items-center mb-6">
        <div class="text-2xl font-bold text-gray-900">Mentorship</div>
        <button @click="showBooking = true" class="bg-[#b81d8f] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#a01a7d] transition">Book New Session</button>
    </div>
    <!-- Professional Directory -->
    <div class="mb-10">
        <h4 class="text-lg font-bold mb-4">Available Professionals</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($professionals as $professional)
                <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center">
                    <img src="{{ $professional->avatar ?? 'https://randomuser.me/api/portraits/men/' . ($professional->id % 100) . '.jpg' }}" class="h-16 w-16 rounded-full object-cover mb-2" alt="Professional">
                    <div class="font-semibold text-gray-900">{{ $professional->name }}</div>
                    <div class="text-xs text-gray-500 mb-1">{{ $professional->specialty ?? ucfirst($professional->role) }}</div>
                    <div class="text-xs text-gray-400 mb-2">{{ $professional->avg_rating ?? '4.8' }} <i class="bi bi-star-fill text-yellow-400"></i></div>
                    <button @click="showBooking = true; selectedProfessional = {{ $professional->id }}" class="bg-[#b81d8f] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#a01a7d] transition">Book</button>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Stats, Tabs, and Session Cards -->
    @include('dashboard.partials.entrepreneur.mentorship-sessions')
    <!-- Booking Modal -->
    <div x-show="showBooking" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" @keydown.escape.window="showBooking = false">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-auto p-6 relative animate-fade-in">
            <button @click="showBooking = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            <h3 class="text-2xl font-bold mb-4">Book New Mentorship Session</h3>
            <form @submit.prevent="submitForm()">
                <!-- Professional Selection -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Select Professional: <span class="text-red-500">*</span></label>
                    <select x-model="formData.professional_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" required>
                        <option value="">Choose a professional...</option>
                        <template x-for="professional in professionals" :key="professional.id">
                            <option :value="professional.id" x-text="professional.name + ' (' + professional.specialty + ')'" :selected="selectedProfessional == professional.id"></option>
                        </template>
                    </select>
                    <p class="text-sm text-gray-500 mt-1">You can only schedule sessions with your paired professionals</p>
                </div>

                <!-- Session Topic -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Session Topic: <span class="text-red-500">*</span></label>
                    <input type="text" x-model="formData.topic" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" 
                           placeholder="e.g., Business Model Canvas, Financial Planning, Market Research" required>
                </div>

                <!-- Session Type -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Session Type: <span class="text-red-500">*</span></label>
                    <select x-model="formData.session_type" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" required>
                        <option value="">Select session type...</option>
                        <option value="1-on-1">1-on-1 Session</option>
                        <option value="group">Group Session</option>
                    </select>
                </div>

                <!-- Date and Time -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Session Date: <span class="text-red-500">*</span></label>
                        <input type="date" x-model="formData.session_date" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Session Time: <span class="text-red-500">*</span></label>
                        <input type="time" x-model="formData.session_time" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" required>
                    </div>
                </div>

                <!-- Session Link (Optional) -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Session Link (Optional):</label>
                    <input type="url" x-model="formData.session_link" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" 
                           placeholder="https://meet.google.com/... or Zoom link">
                    <p class="text-sm text-gray-500 mt-1">Add a meeting link for virtual sessions</p>
                </div>

                <!-- Notes -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Session Notes (Optional):</label>
                    <textarea x-model="formData.notes" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" 
                              placeholder="Additional details about the session, agenda, or preparation needed..."></textarea>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4">
                    <button type="button" @click="resetForm()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                        Reset Form
                    </button>
                    <button type="submit" :disabled="submitting" class="bg-[#b81d8f] text-white px-6 py-2 rounded-lg font-semibold shadow hover:bg-[#6c3483] transition disabled:opacity-50">
                        <span x-show="!submitting">Schedule Session</span>
                        <span x-show="submitting">Scheduling...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function mentorshipBooking(professionals) {
    return {
        showBooking: false,
        selectedProfessional: null,
        professionals: professionals,
        submitting: false,
        formData: {
            professional_id: '',
            topic: '',
            session_type: '',
            session_date: '',
            session_time: '',
            session_link: '',
            notes: ''
        },

        resetForm() {
            this.formData = {
                professional_id: '',
                topic: '',
                session_type: '',
                session_date: '',
                session_time: '',
                session_link: '',
                notes: ''
            };
            this.selectedProfessional = null;
        },

        async submitForm() {
            if (!this.formData.professional_id || !this.formData.topic || !this.formData.session_type || 
                !this.formData.session_date || !this.formData.session_time) {
                alert('Please fill in all required fields.');
                return;
            }

            this.submitting = true;

            const formData = new FormData();
            formData.append('mentor_id', this.formData.professional_id);
            formData.append('topic', this.formData.topic);
            formData.append('session_type', this.formData.session_type);
            formData.append('date_time', this.formData.session_date + ' ' + this.formData.session_time);
            formData.append('session_link', this.formData.session_link);
            formData.append('notes', this.formData.notes);

            try {
                const response = await fetch('{{ route("entrepreneur.mentorship-sessions.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    alert('Session scheduled successfully!');
                    this.resetForm();
                    this.showBooking = false;
                    window.location.reload();
                } else {
                    alert(data.error || 'Failed to schedule session.');
                }
            } catch (error) {
                console.error('Error scheduling session:', error);
                alert('Failed to schedule session. Please try again.');
            } finally {
                this.submitting = false;
            }
        }
    }
}
</script>
@endsection 