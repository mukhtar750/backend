<div class="bg-white rounded-2xl shadow p-6 mb-6">
    <h3 class="text-lg font-bold mb-4">Upcoming Tasks</h3>
    <ul class="space-y-4">
        <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                <div>
                    <div class="font-semibold">Submit Financial Projections</div>
                    <div class="text-xs text-gray-400">Financial Planning</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-xs text-gray-400 flex items-center gap-1"><i class="bi bi-clock"></i> Due Tomorrow</div>
                <div class="text-xs text-gray-400">2 hours</div>
                <a href="{{ route('entrepreneur.task', ['task' => 'financial-projections']) }}" class="mt-2 inline-block bg-[#b81d8f] hover:bg-[#a259e6] text-white text-xs font-semibold px-3 py-1 rounded-lg transition">Go to Task</a>
            </div>
        </li>
        <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                <div>
                    <div class="font-semibold">Complete Market Analysis Quiz</div>
                    <div class="text-xs text-gray-400">Market Research</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-xs text-gray-400 flex items-center gap-1"><i class="bi bi-clock"></i> Due 3 days</div>
                <div class="text-xs text-gray-400">30 minutes</div>
                <a href="{{ route('entrepreneur.task', ['task' => 'market-analysis-quiz']) }}" class="mt-2 inline-block bg-[#b81d8f] hover:bg-[#a259e6] text-white text-xs font-semibold px-3 py-1 rounded-lg transition">Go to Task</a>
            </div>
        </li>
        <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                <div>
                    <div class="font-semibold">Schedule Mentor Meeting</div>
                    <div class="text-xs text-gray-400">Mentorship</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-xs text-gray-400 flex items-center gap-1"><i class="bi bi-clock"></i> Due 1 week</div>
                <div class="text-xs text-gray-400">15 minutes</div>
                <a href="{{ route('entrepreneur.task', ['task' => 'mentor-meeting']) }}" class="mt-2 inline-block bg-[#b81d8f] hover:bg-[#a259e6] text-white text-xs font-semibold px-3 py-1 rounded-lg transition">Go to Task</a>
            </div>
        </li>
        <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-green-500"></span>
                <div>
                    <div class="font-semibold">Pitch Deck Review Session</div>
                    <div class="text-xs text-gray-400">Pitch Preparation</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-xs text-gray-400 flex items-center gap-1"><i class="bi bi-clock"></i> Due 2 weeks</div>
                <div class="text-xs text-gray-400">1 hour</div>
                <a href="{{ route('entrepreneur.task', ['task' => 'pitch-deck-review']) }}" class="mt-2 inline-block bg-[#b81d8f] hover:bg-[#a259e6] text-white text-xs font-semibold px-3 py-1 rounded-lg transition">Go to Task</a>
            </div>
        </li>
    </ul>
</div> 