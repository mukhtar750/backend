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
    <ul class="space-y-4">
        <li class="flex items-center justify-between p-3 rounded-xl border border-gray-100 cursor-pointer hover:bg-purple-50 transition" onclick="window.location='{{ route('entrepreneur.mentorship.session', ['id' => 1]) }}'">
            <div class="flex items-center gap-3">
                <img src="https://randomuser.me/api/portraits/women/65.jpg" class="h-10 w-10 rounded-full object-cover" alt="Dr. Kemi Adebayo">
                <div>
                    <div class="font-semibold">Dr. Kemi Adebayo</div>
                    <div class="text-xs text-gray-400">Business Model Validation</div>
                    <div class="text-xs text-gray-400 mt-1 flex items-center gap-1"><i class="bi bi-clock"></i> Tomorrow 2:00 PM</div>
                </div>
            </div>
            <span class="bg-purple-100 text-purple-700 text-xs px-3 py-1 rounded-full font-semibold">scheduled</span>
        </li>
        <li class="flex items-center justify-between p-3 rounded-xl border border-gray-100 cursor-pointer hover:bg-purple-50 transition" onclick="window.location='{{ route('entrepreneur.mentorship.session', ['id' => 2]) }}'">
            <div class="flex items-center gap-3">
                <img src="https://randomuser.me/api/portraits/women/66.jpg" class="h-10 w-10 rounded-full object-cover" alt="Grace Mwangi">
                <div>
                    <div class="font-semibold">Grace Mwangi</div>
                    <div class="text-xs text-gray-400">Financial Planning Review</div>
                    <div class="text-xs text-gray-400 mt-1 flex items-center gap-1"><i class="bi bi-clock"></i> Last session</div>
                </div>
            </div>
            <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-semibold">completed</span>
        </li>
    </ul>
</div> 