@extends('layouts.bdsp')
@section('title', 'Schedule Session')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8">Schedule New Session</h1>
    
    <div class="bg-white rounded-xl shadow p-8 mb-8" x-data="scheduleSessionForm()">
        <form @submit.prevent="submitForm()">
            <!-- Mentee Selection -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Select Mentee: <span class="text-red-500">*</span></label>
                <select x-model="formData.mentee_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]" required>
                    <option value="">Choose a mentee...</option>
                    @foreach($pairedMentees as $mentee)
                        <option value="{{ $mentee->id }}">{{ $mentee->name }} - {{ $mentee->business_name ?? 'Entrepreneur' }}</option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-1">You can only schedule sessions with your paired mentees</p>
            </div>

            <!-- Session Title/Topic -->
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

            <!-- Submit Button -->
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

    <!-- Recent Sessions -->
    <div class="bg-white rounded-xl shadow p-8">
        <h2 class="text-xl font-semibold mb-6">Recent Sessions</h2>
        <div class="space-y-4">
            @forelse($recentSessions as $session)
                @php
                    $otherUser = $session->scheduled_by == auth()->id() ? $session->scheduledFor : $session->scheduledBy;
                @endphp
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-[#b81d8f] rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-sm">{{ strtoupper(substr($otherUser->name, 0, 2)) }}</span>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">{{ $otherUser->name }}</div>
                                <div class="text-sm text-gray-600">{{ $session->topic }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $session->date_time->format('M j, Y g:i A') }} • {{ $session->duration }} min
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                @if($session->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($session->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($session->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-calendar-event text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No sessions scheduled yet</h3>
                    <p class="text-gray-500">Schedule your first session with a mentee to get started.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function scheduleSessionForm() {
    return {
        submitting: false,
        formData: {
            mentee_id: '',
            topic: '',
            session_type: '',
            session_date: '',
            session_time: '',
            session_link: '',
            notes: ''
        },

        resetForm() {
            this.formData = {
                mentee_id: '',
                topic: '',
                session_type: '',
                session_date: '',
                session_time: '',
                session_link: '',
                notes: ''
            };
        },

        async submitForm() {
            if (!this.formData.mentee_id || !this.formData.topic || !this.formData.session_type || 
                !this.formData.session_date || !this.formData.session_time) {
                alert('Please fill in all required fields.');
                return;
            }

            this.submitting = true;

            const formData = new FormData();
            formData.append('mentee_id', this.formData.mentee_id);
            formData.append('topic', this.formData.topic);
            formData.append('session_type', this.formData.session_type);
            formData.append('session_date', this.formData.session_date);
            formData.append('session_time', this.formData.session_time);
            formData.append('session_link', this.formData.session_link);
            formData.append('notes', this.formData.notes);

            try {
                console.log('Submitting form data:', Object.fromEntries(formData));
                
                const response = await fetch('/bdsp/schedule-session', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData
                });

                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);

                const data = await response.json();
                console.log('Response data:', data);

                if (data.success) {
                    alert('Session scheduled successfully!');
                    this.resetForm();
                    window.location.reload();
                } else {
                    alert(data.error || 'Failed to schedule session.');
                }
            } catch (error) {
                console.error('Error scheduling session:', error);
                console.error('Error details:', {
                    message: error.message,
                    stack: error.stack
                });
                alert('Failed to schedule session. Please check the console for details.');
            } finally {
                this.submitting = false;
            }
        }
    }
}
</script>
@endsection 