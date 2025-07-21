<div class="mb-8">
    <h4 class="text-lg font-bold mb-4">Upcoming Sessions for You</h4>
    <div class="space-y-4">
        @forelse($sessions as $session)
            @php
                $mentor = $session->pairing->userOne->role === 'mentor' ? $session->pairing->userOne : $session->pairing->userTwo;
                $scheduledBy = $session->scheduledBy->name ?? 'Unknown';
                $type = $session->session_type ?? 'Video Call';
                $avatar = $mentor->avatar ?? ("https://randomuser.me/api/portraits/" . ($mentor->gender === 'female' ? 'women' : 'men') . "/" . ($mentor->id % 100) . ".jpg");
            @endphp
            <div class="bg-white rounded-xl shadow p-5 flex flex-col md:flex-row md:items-center gap-4 justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ $avatar }}" class="h-12 w-12 rounded-full object-cover" alt="Mentor">
                    <div>
                        <div class="font-semibold text-gray-900">{{ $mentor->name }}</div>
                        <div class="text-xs text-gray-500">{{ $mentor->specialty ?? 'Mentor' }}</div>
                        <div class="text-xs text-gray-400">Scheduled by: {{ $scheduledBy }}</div>
                        <div class="text-xs text-gray-400">Topic: {{ $session->topic }}</div>
                        <div class="text-xs text-gray-400">Date: {{ \Carbon\Carbon::parse($session->date_time)->format('Y-m-d \a\t g:i A') }}</div>
                        <div class="text-xs text-gray-400">Type: {{ $type }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-2 md:mt-0">
                    <button class="bg-[#b81d8f] text-white px-5 py-2 rounded-lg font-semibold hover:bg-[#a01a7d] transition">Join Session</button>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-400 py-8">
                No upcoming mentorship sessions scheduled.
            </div>
        @endforelse
    </div>
</div>
<!-- Existing mentorship session management content below -->
<div class="text-center text-gray-400 py-8">
    Mentorship session details will appear here.
</div> 