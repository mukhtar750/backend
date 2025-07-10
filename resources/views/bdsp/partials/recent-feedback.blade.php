<div class="bg-white p-6 rounded-xl shadow mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Feedback</h3>
    <div class="flex flex-col md:flex-row gap-4">
        @foreach ([
            [
                'name' => 'Aisha Patel',
                'avatar' => 'https://randomuser.me/api/portraits/women/68.jpg',
                'session' => 'Business Strategy Review',
                'rating' => 5,
                'score' => '5/5',
                'comment' => 'Excellent guidance on business model canvas. Very insightful session!',
                'time' => '1 day ago',
            ],
            [
                'name' => 'David Wilson',
                'avatar' => 'https://randomuser.me/api/portraits/men/31.jpg',
                'session' => 'Market Analysis',
                'rating' => 4,
                'score' => '4/5',
                'comment' => 'Very helpful session on market research methodologies.',
                'time' => '3 days ago',
            ],
            [
                'name' => 'Sarah Johnson',
                'avatar' => 'https://randomuser.me/api/portraits/women/44.jpg',
                'session' => 'Financial Planning',
                'rating' => 5,
                'score' => '5/5',
                'comment' => 'Clear explanations on financial projections. Thank you!',
                'time' => '1 week ago',
            ],
        ] as $feedback)
            <div class="flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm p-5 w-full md:w-1/3 min-w-[260px]">
                <div class="flex items-center gap-3 mb-2">
                    <img src="{{ $feedback['avatar'] }}" alt="{{ $feedback['name'] }}" class="h-10 w-10 rounded-full object-cover">
                    <div>
                        <div class="font-semibold text-gray-900">{{ $feedback['name'] }}</div>
                        <div class="text-xs text-gray-500">{{ $feedback['session'] }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="flex items-center text-yellow-400">
                        @for ($i = 0; $i < $feedback['rating']; $i++)
                            <i class="bi bi-star-fill"></i>
                        @endfor
                    </span>
                    <span class="text-xs font-semibold text-gray-700">{{ $feedback['score'] }}</span>
                </div>
                <div class="italic text-gray-700 text-sm mb-2">"{{ $feedback['comment'] }}"</div>
                <div class="text-xs text-gray-400 mt-auto">{{ $feedback['time'] }}</div>
            </div>
        @endforeach
    </div>
</div> 