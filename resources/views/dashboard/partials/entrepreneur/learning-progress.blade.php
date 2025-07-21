<div class="bg-white rounded-2xl shadow p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold">Learning Progress</h3>
        <span class="text-sm font-semibold text-[#b81d8f]">Overall: {{ $overallProgress ?? '68%' }} Complete</span>
    </div>
    <div class="space-y-6">
        <!-- Module: Business Model Canvas -->
        <div class="border rounded-xl p-4 flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="bg-green-100 text-green-600 rounded-full p-2"><i class="bi bi-check-circle-fill"></i></span>
                    <div>
                        <div class="font-semibold">Business Model Canvas</div>
                        <div class="text-xs text-gray-500">8/8 lessons • 12 hours</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="bg-green-50 text-green-700 text-xs px-2 py-1 rounded-full flex items-center gap-1"><i class="bi bi-award"></i> completed</span>
                </div>
            </div>
            <div>
                <div class="text-xs text-gray-400 mb-1">Progress</div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                </div>
            </div>
        </div>
        <!-- Module: Financial Planning -->
        <div class="border rounded-xl p-4 flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="bg-blue-100 text-blue-600 rounded-full p-2"><i class="bi bi-play-circle"></i></span>
                    <div>
                        <div class="font-semibold">Financial Planning</div>
                        <div class="text-xs text-gray-500">8/10 lessons • 15 hours</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="bg-blue-50 text-blue-700 text-xs px-2 py-1 rounded-full flex items-center gap-1">in progress</span>
                    <a href="{{ route('entrepreneur.module', ['module' => 'financial-planning']) }}" class="ml-2 bg-[#b81d8f] hover:bg-[#a259e6] text-white text-xs font-semibold px-3 py-1 rounded-lg transition">Go to Module</a>
                </div>
            </div>
            <div>
                <div class="text-xs text-gray-400 mb-1">Progress</div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 80%"></div>
                </div>
            </div>
        </div>
        <!-- Module: Market Research -->
        <div class="border rounded-xl p-4 flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="bg-green-100 text-green-600 rounded-full p-2"><i class="bi bi-check-circle-fill"></i></span>
                    <div>
                        <div class="font-semibold">Market Research</div>
                        <div class="text-xs text-gray-500">6/6 lessons • 8 hours</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="bg-green-50 text-green-700 text-xs px-2 py-1 rounded-full flex items-center gap-1"><i class="bi bi-award"></i> completed</span>
                </div>
            </div>
            <div>
                <div class="text-xs text-gray-400 mb-1">Progress</div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                </div>
            </div>
        </div>
        <!-- Module: Pitch Deck Creation -->
        <div class="border rounded-xl p-4 flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="bg-blue-100 text-blue-600 rounded-full p-2"><i class="bi bi-play-circle"></i></span>
                    <div>
                        <div class="font-semibold">Pitch Deck Creation</div>
                        <div class="text-xs text-gray-500">7/12 lessons • 10 hours</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="bg-blue-50 text-blue-700 text-xs px-2 py-1 rounded-full flex items-center gap-1">in progress</span>
                    <a href="{{ route('entrepreneur.module', ['module' => 'pitch-deck-creation']) }}" class="ml-2 bg-[#b81d8f] hover:bg-[#a259e6] text-white text-xs font-semibold px-3 py-1 rounded-lg transition">Go to Module</a>
                </div>
            </div>
            <div>
                <div class="text-xs text-gray-400 mb-1">Progress</div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 60%"></div>
                </div>
            </div>
        </div>
        <!-- Module: Legal Framework -->
        <div class="border rounded-xl p-4 flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="bg-gray-200 text-gray-500 rounded-full p-2"><i class="bi bi-clock"></i></span>
                    <div>
                        <div class="font-semibold">Legal Framework</div>
                        <div class="text-xs text-gray-500">0/8 lessons • 0 hours</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full flex items-center gap-1">pending</span>
                    <a href="{{ route('entrepreneur.module', ['module' => 'legal-framework']) }}" class="ml-2 bg-[#b81d8f] hover:bg-[#a259e6] text-white text-xs font-semibold px-3 py-1 rounded-lg transition">Go to Module</a>
                </div>
            </div>
            <div>
                <div class="text-xs text-gray-400 mb-1">Progress</div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gray-300 h-2 rounded-full" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>
</div> 