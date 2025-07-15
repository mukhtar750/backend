@extends('admin.layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mentorship Management</h1>
        <button
            id="openScheduleSessionModal"
            class="flex items-center gap-2 bg-pink-600 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-pink-700 transition text-base font-bold border-2 border-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-300"
        >
            <i class="bi bi-plus-circle text-xl"></i>
            Schedule Session
        </button>
    </div>
    <!-- Schedule Session Modal -->
    <div id="scheduleSessionModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative">
            <button id="closeScheduleSessionModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
            <h4 class="text-lg font-bold mb-4">Schedule Mentorship Session</h4>
            <form method="POST" action="{{ route('mentorship-sessions.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Select Pairing</label>
                    <select name="pairing_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Select...</option>
                        @foreach($pairings as $pairing)
                            <option value="{{ $pairing->id }}">
                                {{ $pairing->userOne->name }} ↔ {{ $pairing->userTwo->name }} ({{ ucwords(str_replace('_', ' ', $pairing->pairing_type)) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Date & Time</label>
                    <input type="datetime-local" name="date_time" class="w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Duration (minutes)</label>
                    <input type="number" name="duration" min="15" max="240" class="w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Topic</label>
                    <input type="text" name="topic" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Meeting Link</label>
                    <input type="url" name="meeting_link" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="https://..." required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Notes</label>
                    <textarea name="notes" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="flex items-center gap-2 bg-pink-600 text-white font-bold px-6 py-3 rounded-xl shadow-lg hover:bg-pink-700 transition text-base border-2 border-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-300">
                        <i class="bi bi-calendar-plus text-xl"></i>
                        Schedule Session
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('openScheduleSessionModal').onclick = function() {
            document.getElementById('scheduleSessionModal').classList.remove('hidden');
        };
        document.getElementById('closeScheduleSessionModal').onclick = function() {
            document.getElementById('scheduleSessionModal').classList.add('hidden');
        };
    </script>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        @php
            $summaryCards = [
                ['title' => 'Total Sessions', 'value' => '3', 'icon' => 'bi-people', 'color' => 'magenta'],
                ['title' => 'Scheduled', 'value' => '2', 'icon' => 'bi-calendar-check', 'color' => 'blue'],
                ['title' => 'Completed', 'value' => '1', 'icon' => 'bi-check-circle', 'color' => 'green'],
                ['title' => 'Avg. Rating', 'value' => '4.8', 'icon' => 'bi-star', 'color' => 'orange'],
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

    <!-- Tabs for Session Status and Session Listings -->
    <div x-data="{ tab: 'scheduled', sessions: {{ json_encode($sessions) }} }">
        <div class="mb-6 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="#" @click.prevent="tab = 'scheduled'"
                   :class="tab === 'scheduled' ? 'border-magenta-500 text-magenta-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" aria-current="page">
                    <span>Scheduled (</span>
                    <span x-text="sessions.filter(s => s.status === 'pending' || s.status === 'confirmed').length"></span>
                    <span>)</span>
                </a>
                <a href="#" @click.prevent="tab = 'completed'"
                   :class="tab === 'completed' ? 'border-magenta-500 text-magenta-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    <span>Completed (</span>
                    <span x-text="sessions.filter(s => s.status === 'completed').length"></span>
                    <span>)</span>
                </a>
                <a href="#" @click.prevent="tab = 'all'"
                   :class="tab === 'all' ? 'border-magenta-500 text-magenta-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    <span>All (</span>
                    <span x-text="sessions.length"></span>
                    <span>)</span>
                </a>
            </nav>
        </div>
        <!-- Session Listings -->
        <div class="grid grid-cols-1 gap-6">
            <template x-for="session in sessions" :key="session.id">
                <div x-show="(tab === 'all') || (tab === 'scheduled' && (session.status === 'pending' || session.status === 'confirmed')) || (tab === 'completed' && session.status === 'completed')">
                    <div class="bg-white rounded-2xl shadow p-6 mb-6 relative">
                        <!-- Status badge -->
                        <span class="absolute top-6 right-6 bg-blue-100 text-blue-700 text-xs font-semibold px-4 py-1 rounded-full" x-text="session.status.charAt(0).toUpperCase() + session.status.slice(1)"></span>
                        <!-- Avatars, Names, Roles, Meeting Icon -->
                        <div class="flex items-center mb-4">
                            <img :src="session.pairing.user_one.avatar_url || 'https://via.placeholder.com/40'" alt="User One Avatar" class="h-12 w-12 rounded-full object-cover mr-3 border-2 border-white shadow">
                            <div class="mr-6">
                                <p class="font-semibold text-gray-900" x-text="session.pairing.user_one.name"></p>
                                <p class="text-xs text-gray-500" x-text="session.pairing.user_one.role.charAt(0).toUpperCase() + session.pairing.user_one.role.slice(1)"></p>
                            </div>
                            <template x-if="session.meeting_link">
                                <span class="bg-purple-100 text-purple-700 rounded-full px-2 py-1 text-xs font-semibold flex items-center gap-1 mr-6">
                                    <i class="bi bi-camera-video-fill"></i>
                                </span>
                            </template>
                            <img :src="session.pairing.user_two.avatar_url || 'https://via.placeholder.com/40'" alt="User Two Avatar" class="h-12 w-12 rounded-full object-cover ml-3 border-2 border-white shadow">
                            <div>
                                <p class="font-semibold text-gray-900" x-text="session.pairing.user_two.name"></p>
                                <p class="text-xs text-gray-500" x-text="session.pairing.user_two.role.charAt(0).toUpperCase() + session.pairing.user_two.role.slice(1)"></p>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 mb-2" x-text="session.topic || '(No Topic)'"></h3>
                        <div class="flex items-center text-gray-700 text-sm mb-2 gap-6">
                            <span class="flex items-center gap-1"><i class="bi bi-calendar"></i> <span x-text="new Date(session.date_time).toLocaleString()"></span></span>
                            <span class="flex items-center gap-1"><i class="bi bi-clock"></i> <span x-text="session.duration"></span> minutes</span>
                        </div>
                        <hr class="my-3">
                        <div class="flex justify-end items-center gap-6">
                            <div class="flex gap-2 bg-gray-50 rounded-xl shadow-sm px-3 py-3 items-center h-full">
                                <button @click="openEditModal(session)" class="flex items-center gap-1 px-4 py-2 rounded text-sm font-medium text-gray-700 bg-white hover:bg-gray-100 transition h-full">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <form :action="`/mentorship-sessions/${session.id}/complete`" method="POST" style="display:inline" @submit.prevent="if(confirm('Mark as completed?')) $event.target.submit()">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="flex items-center gap-1 px-4 py-2 rounded text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 transition h-full">
                                        <i class="bi bi-check-circle"></i> Complete
                                    </button>
                                </form>
                                <form :action="`/mentorship-sessions/${session.id}/cancel`" method="POST" style="display:inline" @submit.prevent="if(confirm('Cancel this session?')) $event.target.submit()">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="flex items-center gap-1 px-4 py-2 rounded text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 transition h-full">
                                        <i class="bi bi-x-circle"></i> Cancel
                                    </button>
                                </form>
                                <a href="#" class="flex items-center gap-1 px-4 py-2 rounded text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 transition h-full">
                                    <i class="bi bi-arrow-repeat"></i> Reschedule
                                </a>
                            </div>
                            <template x-if="session.meeting_link">
                                <a
                                    :href="session.meeting_link"
                                    target="_blank"
                                    class="flex items-center gap-2 bg-pink-600 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-pink-700 transition text-base font-bold border-2 border-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-300"
                                    style="min-width: 160px; justify-content: center;"
                                >
                                    <i class="bi bi-camera-video-fill text-lg"></i>
                                    Join Session
                                </a>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
            <div x-show="sessions.length === 0" class="text-center text-gray-500 py-8">No mentorship sessions found.</div>
        </div>
    </div>

    <!-- Edit Session Modal -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40" style="display: none;">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative">
            <button @click="showEditModal = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
            <h4 class="text-lg font-bold mb-4">Edit Mentorship Session</h4>
            <form :action="`/mentorship-sessions/${editSession.id}`" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Meeting Link</label>
                    <input type="url" name="meeting_link" class="w-full border-gray-300 rounded-md shadow-sm" :value="editSession.meeting_link" placeholder="https://...">
                </div>
                <!-- Add other fields as needed -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-magenta hover:bg-magenta-700 text-white font-semibold px-6 py-2 rounded-lg">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('mentorshipAdmin', () => ({
            showEditModal: false,
            editSession: {},
            openEditModal(session) {
                this.editSession = JSON.parse(JSON.stringify(session));
                this.showEditModal = true;
            }
        }));
    });
</script>