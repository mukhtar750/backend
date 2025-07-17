<div x-data="{ expanded: false }" class="bg-white p-6 rounded-lg shadow mb-4">
    <div class="flex items-center gap-4 mb-2">
        <div class="flex-shrink-0 bg-[#b81d8f] text-white rounded-lg p-3 text-2xl">
            <i class="bi bi-calendar-event"></i>
        </div>
        <div class="flex-1">
            <h3 class="text-xl font-semibold text-gray-800 mb-1">{{ $event->title }}</h3>
            <div class="flex flex-wrap items-center gap-2 text-xs mb-1">
                <span class="inline-block bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full capitalize">{{ $event->status }}</span>
                @if($event->tags)
                    @foreach((array)$event->tags as $tag)
                        <span class="inline-block bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full">{{ $tag }}</span>
                    @endforeach
                @endif
            </div>
            <div class="text-gray-500 text-sm flex flex-wrap gap-4 items-center">
                <span><i class="bi bi-calendar"></i> {{ $event->event_date ? $event->event_date->format('Y-m-d') : '-' }}</span>
                <span><i class="bi bi-clock"></i> {{ $event->event_date ? $event->event_date->format('g:i A') : '-' }}</span>
                <span><i class="bi bi-geo-alt"></i> {{ $event->location }}</span>
            </div>
        </div>
    </div>
    <p class="text-gray-700 text-sm mb-4">{{ $event->description }}</p>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
        <div class="bg-gray-50 rounded-lg p-3 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">Participants</div>
            <div class="font-bold text-lg text-[#b81d8f]">
                {{ $event->confirmedParticipants->count() }}@if($event->capacity)/{{ $event->capacity }}@endif
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                @if($event->capacity)
                    @php $percent = $event->capacity ? min(100, round(($event->confirmedParticipants->count() / $event->capacity) * 100)) : 0; @endphp
                    <div class="bg-[#b81d8f] h-2 rounded-full" style="width: {{ $percent }}%"></div>
                @else
                    <div class="bg-[#b81d8f] h-2 rounded-full" style="width: 0%"></div>
                @endif
            </div>
        </div>
        <div class="bg-gray-50 rounded-lg p-3 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">Investors</div>
            <div class="font-bold text-lg text-green-600">{{ $event->confirmedInvestors->count() }}</div>
            <div class="text-xs text-green-600">{{ $event->confirmedInvestors->count() }} confirmed</div>
        </div>
        <div class="bg-gray-50 rounded-lg p-3 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">Startups</div>
            <div class="font-bold text-lg text-blue-600">{{ $event->confirmedStartups->count() }}</div>
            <div class="text-xs text-blue-600">{{ $event->confirmedStartups->count() }} confirmed</div>
        </div>
        <div class="bg-gray-50 rounded-lg p-3 flex flex-col items-center">
            <div class="text-xs text-gray-500 mb-1">Registration</div>
            <div class="font-bold text-sm text-gray-800">Closes {{ $event->registration_deadline ? \Carbon\Carbon::parse($event->registration_deadline)->format('Y-m-d') : '-' }}</div>
            <div class="text-xs text-gray-500">{{ $event->registration_deadline ? \Carbon\Carbon::parse($event->registration_deadline)->diffForHumans(null, false, false, 2) : '' }}</div>
        </div>
    </div>
    <div class="flex justify-between items-center mt-2">
        <div class="flex items-center -space-x-2">
            @foreach($event->confirmedInvestors->take(3) as $investor)
                @if($investor->user && $investor->user->profile_photo_url)
                    <img src="{{ $investor->user->profile_photo_url }}" class="w-8 h-8 rounded-full border-2 border-white" alt="Investor">
                @else
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-8 h-8 rounded-full border-2 border-white" alt="Investor">
                @endif
            @endforeach
            <span class="text-xs text-gray-500 ml-2">Confirmed investors</span>
        </div>
        <div class="flex items-center gap-2">
            <a href="#" @click.prevent="expanded = !expanded" class="text-[#b81d8f] text-sm font-medium hover:underline">
                <span x-text="expanded ? 'Show Less' : 'View Details'"></span>
            </a>
            <button class="text-gray-400 hover:text-[#b81d8f]" title="Edit"
                @click="window.editPitchEvent(@json($event))">
                <i class="bi bi-pencil-square"></i>
            </button>
            <button class="text-gray-400 hover:text-red-500" title="Delete"
                @click="if(confirm('Are you sure you want to delete this event?')) { window.deletePitchEvent({{ $event->id }}); }">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </div>
    <div x-show="expanded" class="mt-6 border-t pt-4">
        <div class="mb-2 font-semibold">Event Agenda</div>
        <ul class="mb-4 text-sm text-gray-700 list-disc list-inside">
            @if(is_array($event->agenda) && count($event->agenda))
                @foreach($event->agenda as $item)
                    <li>{{ $item }}</li>
                @endforeach
            @else
                <li>No agenda set.</li>
            @endif
        </ul>
        <div class="mb-2 font-semibold">Requirements</div>
        <ul class="mb-4 text-sm text-gray-700 list-disc list-inside">
            @if(is_array($event->requirements) && count($event->requirements))
                @foreach($event->requirements as $item)
                    <li>{{ $item }}</li>
                @endforeach
            @else
                <li>No requirements set.</li>
            @endif
        </ul>
        <div class="mb-2 font-semibold">Prizes & Benefits</div>
        <ul class="mb-2 text-sm text-gray-700 list-disc list-inside">
            @if(is_array($event->prizes) && count($event->prizes))
                @foreach($event->prizes as $item)
                    <li>{{ $item }}</li>
                @endforeach
            @else
                <li>No prizes or benefits set.</li>
            @endif
        </ul>
    </div>
</div>

<script>
window.deletePitchEvent = async function(eventId) {
    if (!eventId) return;
    try {
        const response = await fetch(`/admin/pitch-events/${eventId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: new URLSearchParams({ _method: 'DELETE' })
        });
        const result = await response.json();
        if (result.success) {
            window.location.reload();
        } else {
            alert(result.message || 'Failed to delete event.');
        }
    } catch (e) {
        alert('Network error. Please try again.');
    }
}
</script> 