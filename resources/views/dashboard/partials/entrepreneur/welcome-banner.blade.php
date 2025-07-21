<div class="rounded-2xl p-8 bg-gradient-to-r from-[#7b2ff2] to-[#f357a8] text-white shadow-lg mb-6">
    <div class="flex flex-col gap-6">
        <div>
            <h2 class="text-3xl md:text-4xl font-bold mb-2">Welcome back, {{ $name ?? 'Amara' }}! <span class="inline-block">👋</span></h2>
            <p class="text-base text-pink-100 max-w-xl">You're making excellent progress in your investment readiness journey.</p>
        </div>
        <div class="flex flex-col md:flex-row gap-4 w-full mt-4">
            <div class="flex-1 min-w-[180px] rounded-xl px-6 py-5 border border-white/30 bg-white/20 backdrop-blur-md shadow-sm flex flex-col items-start justify-center">
                <span class="text-xs text-white/80 mb-1">Next Milestone</span>
                <span class="font-semibold text-lg text-white">{{ $milestone ?? 'Pitch Deck Completion' }}</span>
            </div>
            <div class="flex-1 min-w-[180px] rounded-xl px-6 py-5 border border-white/30 bg-white/20 backdrop-blur-md shadow-sm flex flex-col items-start justify-center">
                <span class="text-xs text-white/80 mb-1">Days Left</span>
                <span class="font-semibold text-lg text-white">{{ $daysLeft ?? '14 days' }}</span>
            </div>
            <div class="flex-1 min-w-[180px] rounded-xl px-6 py-5 border border-white/30 bg-white/20 backdrop-blur-md shadow-sm flex flex-col items-start justify-center">
                <span class="text-xs text-white/80 mb-1">Total Points</span>
                <span class="font-semibold text-lg text-white">{{ $points ?? '1,250 pts' }}</span>
            </div>
            <div class="flex-1 min-w-[180px] flex flex-col items-center justify-center mt-4 md:mt-0">
                <a href="{{ route('entrepreneur.progress') }}" class="bg-white/30 hover:bg-white/50 text-white font-semibold px-6 py-2 rounded-lg shadow transition flex items-center gap-2">
                    <i class="bi bi-flag"></i> View Milestone
                </a>
            </div>
        </div>
    </div>
</div> 