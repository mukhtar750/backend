<div class="bg-white rounded-lg shadow p-4 flex flex-col h-full transform transition duration-300 hover:scale-105 hover:shadow-2xl group relative overflow-hidden fade-in-up">
    <div class="overflow-hidden rounded mb-3">
        <img src="{{ $event->image_path ? asset('storage/' . $event->image_path) : asset('images/default-event.jpg') }}"
             alt="{{ $event->title }}"
             class="w-full h-40 object-cover rounded transition-transform duration-300 group-hover:scale-110">
    </div>
    <h3 class="font-semibold text-lg mb-1">{{ $event->title }}</h3>
    <p class="text-sm text-gray-600 mb-2">{{ \Illuminate\Support\Str::limit($event->description, 80) }}</p>
    <div class="text-xs text-gray-500 mb-2">
        <span>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y H:i') }}</span> |
        <span>{{ ucfirst($event->event_type) }}</span>
    </div>
    <div class="mt-auto">
        @if(auth()->check() && $event->confirmedParticipants()->where('user_id', auth()->id())->exists())
            <a href="{{ $event->event_link ?? '#' }}"
               class="btn btn-success w-full transition-transform duration-200 hover:-translate-y-1 hover:bg-green-700"
               target="_blank">Join Event</a>
        @else
            <form action="{{ route('events.register', $event->id) }}" method="POST">
                @csrf
                <button type="submit"
                        class="btn btn-primary w-full transition-transform duration-200 hover:-translate-y-1 hover:bg-[#a01a7d]">Register</button>
            </form>
        @endif
    </div>
    <style>
        .fade-in-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: none;
            }
        }
    </style>
</div> 