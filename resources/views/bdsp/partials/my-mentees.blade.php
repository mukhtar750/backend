@php
    $mentees = [
        [
            'name' => 'Sarah Johnson',
            'avatar' => 'https://randomuser.me/api/portraits/women/44.jpg',
            'company' => 'EcoTech Solutions',
            'joined' => '2024-10-15',
            'progress' => 85,
            'modules' => '6/8',
            'focus' => 'Financial Planning',
            'last_session' => '2 days ago',
            'next_session' => 'Tomorrow 2:00 PM',
            'status' => 'on track',
            'status_color' => 'bg-blue-100 text-blue-600',
        ],
        [
            'name' => 'Michael Chen',
            'avatar' => 'https://randomuser.me/api/portraits/men/32.jpg',
            'company' => 'FinanceFlow',
            'joined' => '2024-11-01',
            'progress' => 70,
            'modules' => '4/8',
            'focus' => 'Market Research',
            'last_session' => '1 week ago',
            'next_session' => 'Friday 10:00 AM',
            'status' => 'needs attention',
            'status_color' => 'bg-orange-100 text-orange-600',
        ],
        [
            'name' => 'Aisha Patel',
            'avatar' => 'https://randomuser.me/api/portraits/women/68.jpg',
            'company' => 'HealthTech Hub',
            'joined' => '2024-09-20',
            'progress' => 95,
            'modules' => '8/8',
            'focus' => 'Pitch Preparation',
            'last_session' => '1 day ago',
            'next_session' => 'Next week',
            'status' => 'excellent',
            'status_color' => 'bg-green-100 text-green-600',
        ],
        [
            'name' => 'David Wilson',
            'avatar' => 'https://randomuser.me/api/portraits/men/31.jpg',
            'company' => 'AgriSmart',
            'joined' => '2024-12-01',
            'progress' => 60,
            'modules' => '3/8',
            'focus' => 'Business Model',
            'last_session' => '3 days ago',
            'next_session' => 'Monday 11:00 AM',
            'status' => 'on track',
            'status_color' => 'bg-blue-100 text-blue-600',
        ],
    ];
@endphp

<div class="bg-white p-6 rounded-xl shadow mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">My Mentees</h3>
        <a href="#" class="text-purple-600 text-sm font-medium hover:underline">View All</a>
    </div>
    <div x-data="{ open: false, mentee: null }" class="space-y-6">
        @foreach ($mentees as $mentee)
            <div
                @click="mentee = {{ Js::from($mentee) }}; open = true"
                class="flex flex-col md:flex-row md:items-center justify-between bg-gray-50 px-6 py-5 rounded-xl border border-gray-200 shadow-sm cursor-pointer hover:shadow-md transition"
            >
                <div class="flex items-center gap-4 flex-1">
                    <img src="{{ $mentee['avatar'] }}" alt="{{ $mentee['name'] }}" class="h-14 w-14 rounded-full object-cover border-2 border-white shadow">
                    <div>
                        <div class="font-bold text-gray-900 text-lg">{{ $mentee['name'] }}</div>
                        <div class="text-sm text-gray-500">{{ $mentee['company'] }}</div>
                        <div class="text-xs text-gray-400">Joined {{ $mentee['joined'] }}</div>
                    </div>
                </div>
                <div class="flex-1 mt-4 md:mt-0 md:ml-8">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs text-gray-500">Overall Progress</span>
                        <span class="font-semibold text-gray-700">{{ $mentee['progress'] }}%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full mb-2">
                        <div class="h-2 rounded-full bg-gradient-to-r from-blue-500 to-purple-400" style="width: {{ $mentee['progress'] }}%"></div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <span>Modules <span class="font-bold text-gray-700">{{ $mentee['modules'] }}</span></span>
                        <span class="mx-1">•</span>
                        <span><i class="bi bi-bullseye"></i> Focus: {{ $mentee['focus'] }}</span>
                    </div>
                </div>
                <div class="flex flex-col items-end flex-1 mt-4 md:mt-0 md:ml-8">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs text-gray-500"><i class="bi bi-clock"></i> Last session: {{ $mentee['last_session'] }}</span>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs text-gray-500">Next: {{ $mentee['next_session'] }}</span>
                    </div>
                    <span class="text-xs px-3 py-1 rounded-full font-semibold {{ $mentee['status_color'] }} capitalize">{{ $mentee['status'] }}</span>
                </div>
            </div>
        @endforeach

        <!-- Modal -->
        <div x-show="open" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/30">
            <div @click.away="open = false" class="bg-white rounded-2xl border-2 border-[#b81d8f] p-8 w-full max-w-2xl relative shadow-xl">
                <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl"><i class="bi bi-x-lg"></i></button>
                <template x-if="mentee">
                    <div>
                        <div class="flex items-center gap-4 mb-4">
                            <img :src="mentee.avatar" :alt="mentee.name" class="h-16 w-16 rounded-full object-cover border-2 border-white shadow">
                            <div>
                                <div class="font-bold text-2xl text-gray-900" x-text="mentee.name"></div>
                                <div class="text-md text-gray-500" x-text="mentee.company"></div>
                                <div class="text-xs text-gray-400">Joined <span x-text="mentee.joined"></span></div>
                            </div>
                            <span class="ml-auto text-xs px-3 py-1 rounded-full font-semibold capitalize self-start" :class="mentee.status_color" x-text="mentee.status"></span>
                        </div>
                        <div class="flex flex-wrap items-center gap-4 mb-2">
                            <span class="text-gray-600 font-semibold">Overall Progress</span>
                            <span class="font-bold text-gray-900 text-lg" x-text="mentee.progress + '%'"></span>
                            <span class="text-gray-600">Modules</span>
                            <span class="font-bold text-gray-900" x-text="mentee.modules"></span>
                            <span class="flex items-center text-gray-600"><i class="bi bi-bullseye mr-1"></i> Focus: <span x-text="mentee.focus"></span></span>
                        </div>
                        <div class="w-full h-2 bg-gray-200 rounded-full mb-4">
                            <div class="h-2 rounded-full bg-gradient-to-r from-blue-500 to-purple-400" :style="'width: ' + mentee.progress + '%'"></div>
                        </div>
                        <div class="flex flex-wrap items-center justify-between text-gray-600 mb-6">
                            <div class="flex items-center gap-2"><i class="bi bi-clock"></i> Last session: <span x-text="mentee.last_session"></span></div>
                            <div class="flex items-center gap-2">Next: <span x-text="mentee.next_session"></span></div>
                        </div>
                        <hr class="my-4">
                        <div class="flex items-center gap-3">
                            <button class="flex-1 bg-[#b81d8f] hover:bg-[#a01a7c] text-white font-semibold py-3 rounded-xl text-lg transition">Schedule Session</button>
                            <button class="p-3 rounded-xl border border-gray-300 hover:bg-gray-100"><i class="bi bi-chat-dots text-xl text-gray-600"></i></button>
                            <button class="p-3 rounded-xl border border-gray-300 hover:bg-gray-100"><i class="bi bi-envelope text-xl text-gray-600"></i></button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div> 