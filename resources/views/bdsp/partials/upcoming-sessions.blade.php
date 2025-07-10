<div class="bg-white p-6 rounded-xl shadow mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Upcoming Sessions</h3>
    </div>
    <div class="space-y-4">
        @foreach ([
            [
                'mentee' => 'Sarah Johnson',
                'avatar' => 'https://randomuser.me/api/portraits/women/44.jpg',
                'title' => 'Financial Modeling',
                'datetime' => 'Today 2:00 PM',
                'platform' => 'Zoom',
                'duration' => '60 min',
                'status' => 'confirmed',
                'status_color' => 'bg-green-50 text-green-600',
                'icon' => 'bi-camera-video',
            ],
            [
                'mentee' => 'Michael Chen',
                'avatar' => 'https://randomuser.me/api/portraits/men/32.jpg',
                'title' => 'Market Strategy',
                'datetime' => 'Tomorrow 10:00 AM',
                'platform' => 'Google Meet',
                'duration' => '45 min',
                'status' => 'confirmed',
                'status_color' => 'bg-green-50 text-green-600',
                'icon' => 'bi-camera-video',
            ],
            [
                'mentee' => 'Group Session',
                'avatar' => null,
                'title' => 'Pitch Preparation',
                'datetime' => 'Friday 3:00 PM',
                'platform' => 'Teams',
                'duration' => '90 min',
                'status' => 'pending',
                'status_color' => 'bg-yellow-50 text-yellow-700',
                'icon' => 'bi-people',
            ],
        ] as $session)
            <div class="flex items-center justify-between bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">
                <div class="flex items-center gap-3">
                    @if($session['avatar'])
                        <img src="{{ $session['avatar'] }}" alt="{{ $session['mentee'] }}" class="h-10 w-10 rounded-full object-cover">
                    @else
                        <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                            <i class="bi {{ $session['icon'] }} text-lg"></i>
                        </div>
                    @endif
                    <div>
                        <div class="font-semibold text-gray-900">{{ $session['mentee'] }}</div>
                        <div class="text-xs text-gray-500">{{ $session['title'] }}</div>
                        <div class="text-xs text-gray-400">{{ $session['datetime'] }}</div>
                        <div class="text-xs text-gray-400">{{ $session['platform'] }}</div>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-1">
                    <span class="text-xs text-gray-500">{{ $session['duration'] }}</span>
                    <span class="text-xs px-2 py-1 rounded-full font-semibold {{ $session['status_color'] }} capitalize">{{ $session['status'] }}</span>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Monthly Performance Section -->
    <div class="mt-8">
        <div class="bg-white rounded-xl border border-gray-200 shadow p-4">
            <h3 class="text-md font-semibold text-gray-800 mb-4">Monthly Performance</h3>
            <div class="space-y-2">
                @foreach ([
                    ['month' => 'Jan', 'sessions' => 28, 'completed' => 26, 'rating' => 4.7],
                    ['month' => 'Feb', 'sessions' => 32, 'completed' => 30, 'rating' => 4.8],
                    ['month' => 'Mar', 'sessions' => 35, 'completed' => 33, 'rating' => 4.9],
                    ['month' => 'Apr', 'sessions' => 30, 'completed' => 28, 'rating' => 4.6],
                ] as $perf)
                    <div class="flex items-center justify-between text-sm">
                        <span class="w-10 text-gray-500">{{ $perf['month'] }}</span>
                        <span class="w-20 text-gray-700">{{ $perf['sessions'] }} <span class="text-gray-400">sessions</span></span>
                        <span class="w-24 text-green-600">{{ $perf['completed'] }} <span class="text-gray-400">completed</span></span>
                        <span class="w-16 text-orange-500 font-semibold">{{ $perf['rating'] }} <i class="bi bi-star-fill text-yellow-400"></i></span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div> 