<div class="bg-white rounded-2xl shadow p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold">Mentorship</h3>
        <button id="openBookSessionModal" class="bg-[#b81d8f] hover:bg-[#a259e6] text-white text-xs font-semibold px-5 py-2 rounded-lg shadow transition flex items-center gap-2">
            <i class="bi bi-calendar-plus"></i> Book Session
        </button>
    </div>
    <!-- Book Session Modal -->
    <div id="bookSessionModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative">
            <button id="closeBookSessionModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
            <h4 class="text-lg font-bold mb-4">Book Mentorship Session</h4>
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
                    <label class="block text-gray-700 font-semibold mb-2">Notes</label>
                    <textarea name="notes" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-[#b81d8f] hover:bg-[#a259e6] text-white font-semibold px-6 py-2 rounded-lg">Book Session</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('openBookSessionModal').onclick = function() {
            document.getElementById('bookSessionModal').classList.remove('hidden');
        };
        document.getElementById('closeBookSessionModal').onclick = function() {
            document.getElementById('bookSessionModal').classList.add('hidden');
        };
    </script>
    
    @if(isset($mentorshipSessions) && $mentorshipSessions->count() > 0)
        <ul class="space-y-4">
            @foreach($mentorshipSessions as $session)
                <li class="flex items-center justify-between p-3 rounded-xl border border-gray-100 cursor-pointer hover:bg-purple-50 transition" onclick="window.location='{{ route('entrepreneur.mentorship.session', ['id' => $session->id]) }}'">
                    <div class="flex items-center gap-3">
                        @if($session->mentor && $session->mentor->profile_picture)
                            <img src="{{ asset('storage/' . $session->mentor->profile_picture) }}" class="h-10 w-10 rounded-full object-cover" alt="{{ $session->mentor->name }}">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($session->mentor->name ?? 'Mentor') }}&color=7C3AED&background=EDE9FE&size=200" class="h-10 w-10 rounded-full object-cover" alt="{{ $session->mentor->name ?? 'Mentor' }}">
                        @endif
                        <div>
                            <div class="font-semibold">{{ $session->mentor->name ?? 'Your Mentor' }}</div>
                            <div class="text-xs text-gray-400">{{ $session->topic ?? 'No topic specified' }}</div>
                            <div class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                <i class="bi bi-clock"></i> 
                                @if($session->date_time)
                                    @if($session->date_time->isToday())
                                        Today {{ $session->date_time->format('g:i A') }}
                                    @elseif($session->date_time->isTomorrow())
                                        Tomorrow {{ $session->date_time->format('g:i A') }}
                                    @elseif($session->date_time->isPast())
                                        {{ $session->date_time->diffForHumans() }}
                                    @else
                                        {{ $session->date_time->format('M d, g:i A') }}
                                    @endif
                                @else
                                    No date set
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($session->status === 'scheduled') bg-purple-100 text-purple-700
                        @elseif($session->status === 'completed') bg-green-100 text-green-700
                        @elseif($session->status === 'cancelled') bg-red-100 text-red-700
                        @else bg-gray-100 text-gray-700 @endif">
                        {{ ucfirst($session->status ?? 'scheduled') }}
                    </span>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-center py-8">
            <div class="text-gray-400 mb-2">
                <i class="bi bi-calendar-event text-3xl"></i>
            </div>
            <p class="text-gray-600 text-sm">No mentorship sessions scheduled.</p>
            <p class="text-gray-500 text-xs mt-1">Book your first session to get started.</p>
        </div>
    @endif
</div> 