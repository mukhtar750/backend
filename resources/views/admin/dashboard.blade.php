@extends('admin.layouts.admin')

@section('content')
    <!-- Your dashboard content will go here -->
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Dashboard Overview</h2>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Total Users</div>
                <div class="text-3xl font-bold text-gray-900">245</div>
                <div class="text-sm text-green-500">+12% from last month</div>
            </div>
            <div class="bg-purple-100 p-3 rounded-full">
                <i class="bi bi-people-fill text-purple-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Active Programs</div>
                <div class="text-3xl font-bold text-gray-900">8</div>
                <div class="text-sm text-green-500">+25% from last quarter</div>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="bi bi-book-fill text-blue-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Pitch Events</div>
                <div class="text-3xl font-bold text-gray-900">15</div>
                <div class="text-sm text-gray-500">3 upcoming</div>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="bi bi-megaphone-fill text-green-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Success Rate</div>
                <div class="text-3xl font-bold text-gray-900">78%</div>
                <div class="text-sm text-green-500">+5% improvement</div>
            </div>
            <div class="bg-orange-100 p-3 rounded-full">
                <i class="bi bi-graph-up text-orange-600 text-2xl"></i>
            </div>
        </div>
    </div>


    <!-- Quick Actions -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        <div class="bg-purple-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <i class="bi bi-people-fill text-purple-600 text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm text-gray-700">Approve Users</p>
        </div>
        <div class="bg-blue-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <i class="bi bi-calendar-event-fill text-blue-600 text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm text-gray-700">Schedule Event</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <i class="bi bi-file-earmark-text-fill text-green-600 text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm text-gray-700">Review Content</p>
        </div>
        <div class="bg-orange-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <i class="bi bi-graph-up text-orange-600 text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm text-gray-700">Analytics</p>
        </div>
        <div class="bg-red-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <i class="bi bi-megaphone-fill text-red-600 text-2xl mb-2 block"></i>
            <p class="font-semibold text-sm text-gray-700">Pitch Events</p>
        </div>
        <div class="bg-indigo-50 p-4 rounded-lg text-center shadow-sm hover:shadow-md transition">
            <a href="{{ route('messages.index') }}" class="block">
                <i class="bi bi-chat-dots-fill text-indigo-600 text-2xl mb-2 block"></i>
                <p class="font-semibold text-sm text-gray-700">Messages</p>
            </a>
        </div>
    </div>

    <!-- Main Panel -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                <a href="#" class="text-purple-600 text-sm font-medium hover:underline">View All</a>
            </div>
            <div class="space-y-4">
                @foreach ([
                    ['msg' => 'New entrepreneur profile pending approval', 'by' => 'Amina Hassan', 'status' => 'pending', 'time' => '2 minutes ago'],
                    ['msg' => 'Business Plan Workshop completed', 'by' => 'Dr. Kemi Adebayo', 'status' => 'completed', 'time' => '1 hour ago'],
                    ['msg' => 'Pitch event scheduled for next week', 'by' => 'Grace Mwangi', 'status' => 'scheduled', 'time' => '3 hours ago'],
                    ['msg' => '5 new feedback submissions received', 'by' => 'Multiple Users', 'status' => 'new', 'time' => '1 day ago'],
                    ['msg' => 'New mentorship session completed', 'by' => 'Fatima Al-Rashid', 'status' => 'completed', 'time' => '2 days ago'],
                ] as $item)
                    <div class="flex items-start justify-between bg-gray-50 px-4 py-3 rounded-md hover:bg-gray-100 transition">
                        <div>
                            <p class="font-semibold text-sm text-gray-800">{{ $item['msg'] }}</p>
                            <p class="text-xs text-gray-500">by {{ $item['by'] }} • {{ $item['time'] }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full
                            @if($item['status'] === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($item['status'] === 'completed') bg-green-100 text-green-800
                            @elseif($item['status'] === 'scheduled') bg-blue-100 text-blue-800
                            @else bg-purple-100 text-purple-800
                            @endif">
                            {{ ucfirst($item['status']) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Pending Approvals</h3>
                <span class="text-xs bg-yellow-200 text-yellow-800 px-2 py-1 rounded-full">3</span>
            </div>
            @foreach ([
                ['name' => 'Amina Hassan', 'email' => 'amina@techstartup.com', 'org' => 'TechStartup Solutions', 'time' => '2 days ago'],
                ['name' => 'Kwame Asante', 'email' => 'kwame@agritech.com', 'org' => 'AgriTech Innovations', 'time' => '1 day ago'],
                ['name' => 'Fatima Al-Rashid', 'email' => 'fatima@healthtech.com', 'org' => 'HealthTech Hub', 'time' => '3 hours ago'],
            ] as $user)
                <div class="bg-gray-50 rounded-md p-4 mb-4">
                    <div class="font-semibold text-gray-800">{{ $user['name'] }}</div>
                    <div class="text-sm text-gray-500">{{ $user['email'] }}</div>
                    <div class="text-xs text-gray-400 mb-2">{{ $user['org'] }}</div>
                    <div class="flex justify-between items-center">
                        <div class="text-xs text-gray-400">{{ $user['time'] }}</div>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">Approve</button>
                            <button class="px-3 py-1 bg-gray-300 text-gray-800 text-xs rounded hover:bg-gray-400">Review</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Pitch Events Management -->
    <div class="mt-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pitch Events Management</h3>
            <button class="bg-[#b81d8f] text-white px-4 py-2 rounded-md flex items-center gap-2">
                <i class="bi bi-plus-lg"></i> Create Event
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Example Event Card -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <div class="font-bold text-gray-800">Q1 Investor Showcase</div>
                        <div class="text-sm text-gray-500">FinTech</div>
                    </div>
                    <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded">upcoming</span>
                </div>
                <div class="text-sm text-gray-500 mb-2"><i class="bi bi-calendar-event"></i> 2025-02-15 at 2:00 PM</div>
                <div class="text-sm text-gray-500 mb-2"><i class="bi bi-people"></i> 12/15 participants</div>
                <div class="text-sm text-gray-500 mb-2"><i class="bi bi-geo-alt"></i> Lagos Innovation Hub</div>
                <div class="mb-2">
                    <div class="text-xs text-gray-500 mb-1">Registration Progress</div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-[#b81d8f] h-2 rounded-full" style="width: 80%"></div>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="text-xs text-gray-500 mb-1">Confirmed Investors:</div>
                    <div class="flex flex-wrap gap-1">
                        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded">Grace Mwangi</span>
                        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded">Michael Chen</span>
                        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded">Sarah Johnson</span>
                    </div>
                </div>
                <button class="mt-2 w-full bg-gray-100 text-[#b81d8f] font-semibold py-2 rounded hover:bg-gray-200">View Details</button>
            </div>
            <!-- Repeat for other events as needed -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <div class="font-bold text-gray-800">HealthTech Demo Day</div>
                        <div class="text-sm text-gray-500">HealthTech</div>
                    </div>
                    <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded">upcoming</span>
                </div>
                <div class="text-sm text-gray-500 mb-2"><i class="bi bi-calendar-event"></i> 2025-02-28 at 10:00 AM</div>
                <div class="text-sm text-gray-500 mb-2"><i class="bi bi-people"></i> 8/10 participants</div>
                <div class="text-sm text-gray-500 mb-2"><i class="bi bi-globe"></i> Virtual Event</div>
                <div class="mb-2">
                    <div class="text-xs text-gray-500 mb-1">Registration Progress</div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-[#b81d8f] h-2 rounded-full" style="width: 80%"></div>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="text-xs text-gray-500 mb-1">Confirmed Investors:</div>
                    <div class="flex flex-wrap gap-1">
                        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded">Grace Mwangi</span>
                        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded">David Wilson</span>
                    </div>
                </div>
                <button class="mt-2 w-full bg-gray-100 text-[#b81d8f] font-semibold py-2 rounded hover:bg-gray-200">View Details</button>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <div class="font-bold text-gray-800">AgriTech Innovation Pitch</div>
                        <div class="text-sm text-gray-500">AgriTech</div>
                    </div>
                    <span class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded">completed</span>
                </div>
                <div class="text-sm text-gray-500 mb-2"><i class="bi bi-calendar-event"></i> 2025-01-20 at 3:00 PM</div>
                <div class="text-sm text-gray-500 mb-2"><i class="bi bi-people"></i> 15/15 participants</div>
                <div class="text-sm text-gray-500 mb-2"><i class="bi bi-geo-alt"></i> Abuja Tech Center</div>
                <div class="mb-2">
                    <div class="text-xs text-gray-500 mb-1">Registration Progress</div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-[#b81d8f] h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="text-xs text-gray-500 mb-1">Confirmed Investors:</div>
                    <div class="flex flex-wrap gap-1">
                        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded">Grace Mwangi</span>
                        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded">Michael Chen</span>
                        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded">Sarah Johnson</span>
                        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded">David Wilson</span>
                    </div>
                </div>
                <button class="mt-2 w-full bg-gray-100 text-[#b81d8f] font-semibold py-2 rounded hover:bg-gray-200">View Details</button>
            </div>
        </div>
    </div>

    <!-- Upcoming Training Events -->
    <div class="mt-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Upcoming Training Events</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
                <div>
                    <div class="font-semibold text-gray-800">Digital Marketing Workshop</div>
                    <div class="text-sm text-gray-500">Tomorrow 10:00 AM</div>
                    <div class="text-xs text-gray-400">by Sarah Johnson</div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-purple-600">25</div>
                    <div class="text-sm text-gray-500">participants</div>
                    <div class="text-xs text-green-600">confirmed</div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
                <div>
                    <div class="font-semibold text-gray-800">Investor Pitch Day</div>
                    <div class="text-sm text-gray-500">Friday 2:00 PM</div>
                    <div class="text-xs text-gray-400">by Michael Chen</div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-purple-600">12</div>
                    <div class="text-sm text-gray-500">participants</div>
                    <div class="text-xs text-green-600">confirmed</div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
                <div>
                    <div class="font-semibold text-gray-800">Mentorship Matching Session</div>
                    <div class="text-sm text-gray-500">Next Monday 9:00 AM</div>
                    <div class="text-xs text-gray-400">by Dr. Kemi Adebayo</div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-purple-600">18</div>
                    <div class="text-sm text-gray-500">participants</div>
                    <div class="text-xs text-yellow-600">pending</div>
                </div>
            </div>
        </div>
    </div>
@endsection
