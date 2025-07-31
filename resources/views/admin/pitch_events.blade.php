@extends('admin.layouts.admin')

@section('content')
    <div x-data="{
        showCreateModal: false,
        isEditMode: false,
        editEventId: null,
        createForm: {
            title: '',
            description: '',
            event_date: '',
            event_time: '',
            location: '',
            event_type: 'virtual',
            capacity: '',
            registration_deadline: '',
            status: 'draft',
            contact_email: '',
            contact_phone: '',
            agenda: [],
            requirements: [],
            prizes: [],
            tags: '',
            image: null
        },
        createLoading: false,
        createError: '',
        createSuccess: '',
        resetCreateForm() {
            this.createForm = {
                title: '', description: '', event_date: '', event_time: '', location: '',
                event_type: 'virtual', capacity: '', registration_deadline: '', status: 'draft',
                contact_email: '', contact_phone: '', agenda: [], requirements: [], prizes: [], tags: '', image: null
            };
            this.createError = '';
            this.createSuccess = '';
            this.isEditMode = false;
            this.editEventId = null;
        },
        loadEventForEdit(event) {
            this.isEditMode = true;
            this.editEventId = event.id;
            this.createForm = {
                title: event.title || '',
                description: event.description || '',
                event_date: event.event_date ? event.event_date.split('T')[0] : '',
                event_time: event.event_date ? event.event_date.split('T')[1]?.substring(0,5) : '',
                location: event.location || '',
                event_type: event.event_type || 'virtual',
                capacity: event.capacity || '',
                registration_deadline: event.registration_deadline ? event.registration_deadline.replace(' ', 'T') : '',
                status: event.status || 'draft',
                contact_email: event.contact_email || '',
                contact_phone: event.contact_phone || '',
                agenda: event.agenda || [],
                requirements: event.requirements || [],
                prizes: event.prizes || [],
                tags: event.tags || '',
                image: null
            };
            this.createError = '';
            this.createSuccess = '';
            this.showCreateModal = true;
        },
        async createEvent() {
            this.createLoading = true;
            this.createError = '';
            this.createSuccess = '';
            // Ensure agenda, requirements, and prizes are arrays and filter out empty strings
            ['agenda', 'requirements', 'prizes'].forEach(key => {
                if (!Array.isArray(this.createForm[key])) {
                    this.createForm[key] = [];
                } else {
                    this.createForm[key] = this.createForm[key].filter(item => item && item.trim() !== '');
                }
            });
            const formData = new FormData();
            Object.keys(this.createForm).forEach(key => {
                if (this.createForm[key] !== null && this.createForm[key] !== '') {
                    if (key === 'event_date' && this.createForm.event_time) {
                        const dateTime = `${this.createForm.event_date} ${this.createForm.event_time}:00`;
                        formData.append('event_date', dateTime);
                    } else if (['agenda','requirements','prizes'].includes(key)) {
                        formData.append(key, JSON.stringify(this.createForm[key]));
                    } else if (key !== 'event_time') {
                        formData.append(key, this.createForm[key]);
                    }
                }
            });
            let url = this.isEditMode ? `/admin/pitch-events/${this.editEventId}` : '{{ route('admin.pitch-events.store') }}';
            let method = this.isEditMode ? 'POST' : 'POST';
            if (this.isEditMode) formData.append('_method', 'PATCH');
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                });
                const result = await response.json();
                if (result.success) {
                    this.createSuccess = result.message;
                    setTimeout(() => {
                        this.showCreateModal = false;
                        window.location.reload();
                    }, 1500);
                } else {
                    this.createError = result.message || 'Failed to save event';
                }
            } catch (error) {
                this.createError = 'Network error. Please try again.';
            } finally {
                this.createLoading = false;
            }
        }
    }">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Pitch Events Management</h1>
            <button 
                @click="showCreateModal = true"
                class="bg-[#b81d8f] hover:bg-[#a01a7d] text-white font-bold py-3 px-6 rounded-xl shadow-lg flex items-center gap-2 text-base focus:outline-none focus:ring-4 focus:ring-[#b81d8f]/30 transition"
                type="button"
            >
                <i class="bi bi-plus-circle text-xl"></i>
                Create New Event
            </button>
        </div>

        <!-- Create Event Modal -->
        <div x-show="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
            <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800" x-text="isEditMode ? 'Edit Pitch Event' : 'Create New Pitch Event'"></h3>
                    <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                </div>

                <!-- Success/Error Messages -->
                <div x-show="createSuccess" x-text="createSuccess" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded"></div>
                <div x-show="createError" x-text="createError" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded"></div>

                <form @submit.prevent="createEvent" class="space-y-6">
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Event Title *</label>
                            <input type="text" x-model="createForm.title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Event Type *</label>
                            <select x-model="createForm.event_type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                                <option value="virtual">Virtual</option>
                                <option value="in-person">In-Person</option>
                                <option value="hybrid">Hybrid</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                        <textarea x-model="createForm.description" required rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent"></textarea>
                    </div>

                    <!-- Date and Time -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Event Date *</label>
                            <input type="date" x-model="createForm.event_date" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Event Time *</label>
                            <input type="time" x-model="createForm.event_time" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Registration Deadline</label>
                            <input type="datetime-local" x-model="createForm.registration_deadline" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                        </div>
                    </div>

                    <!-- Location and Capacity -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                            <input type="text" x-model="createForm.location" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Capacity</label>
                            <input type="number" x-model="createForm.capacity" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
                            <input type="email" x-model="createForm.contact_email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contact Phone</label>
                            <input type="tel" x-model="createForm.contact_phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Event Agenda</label>
                        <template x-for="(item, idx) in createForm.agenda" :key="idx">
                            <div class="flex items-center gap-2 mb-2">
                                <input type="text" x-model="createForm.agenda[idx]" class="w-full px-3 py-2 border rounded-lg" placeholder="Agenda item">
                                <button type="button" @click="createForm.agenda.splice(idx, 1)" class="text-red-500">&times;</button>
                            </div>
                        </template>
                        <button type="button" @click="createForm.agenda.push('')" class="text-xs text-[#b81d8f] font-semibold">+ Add Agenda Item</button>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Requirements</label>
                        <template x-for="(item, idx) in createForm.requirements" :key="idx">
                            <div class="flex items-center gap-2 mb-2">
                                <input type="text" x-model="createForm.requirements[idx]" class="w-full px-3 py-2 border rounded-lg" placeholder="Requirement">
                                <button type="button" @click="createForm.requirements.splice(idx, 1)" class="text-red-500">&times;</button>
                            </div>
                        </template>
                        <button type="button" @click="createForm.requirements.push('')" class="text-xs text-[#b81d8f] font-semibold">+ Add Requirement</button>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prizes & Benefits</label>
                        <template x-for="(item, idx) in createForm.prizes" :key="idx">
                            <div class="flex items-center gap-2 mb-2">
                                <input type="text" x-model="createForm.prizes[idx]" class="w-full px-3 py-2 border rounded-lg" placeholder="Prize or benefit">
                                <button type="button" @click="createForm.prizes.splice(idx, 1)" class="text-red-500">&times;</button>
                            </div>
                        </template>
                        <button type="button" @click="createForm.prizes.push('')" class="text-xs text-[#b81d8f] font-semibold">+ Add Prize/Benefit</button>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                        <input type="text" x-model="createForm.tags" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent" placeholder="Enter tags separated by commas">
                    </div>

                    <!-- Event Link -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Event Link</label>
                        <input type="url" x-model="createForm.event_link" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent" placeholder="https://zoom.us/j/1234567890">
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Event Image</label>
                        <input type="file" @change="createForm.image = $event.target.files[0]" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select x-model="createForm.status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b81d8f] focus:border-transparent">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <button 
                            type="button" 
                            @click="showCreateModal = false"
                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
                        >
                            Cancel
                        </button>
                        <button 
                            type="submit" 
                            :disabled="createLoading"
                            class="px-6 py-2 bg-[#b81d8f] text-white rounded-lg hover:bg-[#a01a7d] transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                        >
                            <span x-show="createLoading" class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></span>
                            <span x-text="isEditMode ? 'Update Event' : 'Create Event'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        @php
            $summaryCards = [
                ['title' => 'Total Events', 'value' => '5', 'icon' => 'bi-calendar-event', 'color' => 'magenta'],
                ['title' => 'Upcoming', 'value' => '2', 'icon' => 'bi-hourglass-split', 'color' => 'blue'],
                ['title' => 'Completed', 'value' => '3', 'icon' => 'bi-check-circle', 'color' => 'green'],
                ['title' => 'Avg. Participants', 'value' => '75', 'icon' => 'bi-people', 'color' => 'purple'],
            ];
        @endphp

        @foreach ($summaryCards as $card)
            <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
                <div>
                    <p class="text-gray-500">{{ $card['title'] }}</p>
                    <div class="text-2xl font-bold text-{{ $card['color'] }}-600">{{ $card['value'] }}</div>
                </div>
                <i class="bi {{ $card['icon'] }} text-{{ $card['color'] }}-400 text-4xl"></i>
            </div>
        @endforeach
    </div>

    <!-- Tabs for Event Status -->
    <div class="mb-6" x-data="{ tab: 'upcoming' }">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button @click="tab = 'upcoming'" :class="tab === 'upcoming' ? 'border-[#b81d8f] text-[#b81d8f] border-b-2' : 'text-gray-500 border-transparent'" class="whitespace-nowrap py-4 px-1 font-medium text-sm focus:outline-none">Upcoming ({{ $events->where('status', 'published')->where('event_date', '>', now())->count() }})</button>
                <button @click="tab = 'live'" :class="tab === 'live' ? 'border-[#b81d8f] text-[#b81d8f] border-b-2' : 'text-gray-500 border-transparent'" class="whitespace-nowrap py-4 px-1 font-medium text-sm focus:outline-none">Live ({{ $events->where('status', 'live')->count() }})</button>
                <button @click="tab = 'completed'" :class="tab === 'completed' ? 'border-[#b81d8f] text-[#b81d8f] border-b-2' : 'text-gray-500 border-transparent'" class="whitespace-nowrap py-4 px-1 font-medium text-sm focus:outline-none">Completed ({{ $events->where('status', 'completed')->count() }})</button>
                <button @click="tab = 'draft'" :class="tab === 'draft' ? 'border-[#b81d8f] text-[#b81d8f] border-b-2' : 'text-gray-500 border-transparent'" class="whitespace-nowrap py-4 px-1 font-medium text-sm focus:outline-none">Draft ({{ $events->where('status', 'draft')->count() }})</button>
                <a href="{{ route('admin.proposals.index') }}" class="whitespace-nowrap py-4 px-1 font-medium text-sm text-gray-500 hover:text-[#b81d8f] border-transparent border-b-2 hover:border-[#b81d8f] focus:outline-none">
                    Proposals 
                    @php
                        $pendingProposals = \App\Models\PitchEventProposal::where('status', 'pending')->count();
                    @endphp
                    @if($pendingProposals > 0)
                        <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            {{ $pendingProposals }}
                        </span>
                    @endif
                </a>
            </nav>
        </div>

        <!-- Event Listings by Tab -->
        <div class="grid grid-cols-1 gap-6 mt-6">
            <!-- Upcoming Events -->
            <template x-if="tab === 'upcoming'">
                <div>
                    @forelse ($events->where('status', 'published')->where('event_date', '>', now()) as $event)
                        @include('admin.partials.pitch_event_card', ['event' => $event])
                    @empty
                        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">No upcoming events found.</div>
                    @endforelse
                </div>
            </template>
            <!-- Live Events -->
            <template x-if="tab === 'live'">
                <div>
                    @forelse ($events->where('status', 'live') as $event)
                        @include('admin.partials.pitch_event_card', ['event' => $event])
                    @empty
                        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">No live events found.</div>
                    @endforelse
                </div>
            </template>
            <!-- Completed Events -->
            <template x-if="tab === 'completed'">
                <div>
                    @forelse ($events->where('status', 'completed') as $event)
                        @include('admin.partials.pitch_event_card', ['event' => $event])
                    @empty
                        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">No completed events found.</div>
                    @endforelse
                </div>
            </template>
            <!-- Draft Events -->
            <template x-if="tab === 'draft'">
                <div>
                    @forelse ($events->where('status', 'draft') as $event)
                        @include('admin.partials.pitch_event_card', ['event' => $event])
                    @empty
                        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">No draft events found.</div>
                    @endforelse
                </div>
            </template>
        </div>
    </div>
@endsection
<script>
    window.editPitchEvent = (event) => {
        const root = document.querySelector('[x-data]');
        if (root && root.__x) {
            root.__x.$data.loadEventForEdit(event);
        }
    };
</script>
