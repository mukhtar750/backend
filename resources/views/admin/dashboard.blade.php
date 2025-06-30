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

    <!-- Quick Actions Section -->
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <div class="bg-purple-100 p-3 rounded-full inline-block mb-3">
                <i class="bi bi-people-fill text-purple-600 text-2xl"></i>
            </div>
            <div class="font-semibold text-gray-800">Approve Users</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <div class="bg-blue-100 p-3 rounded-full inline-block mb-3">
                <i class="bi bi-calendar-event-fill text-blue-600 text-2xl"></i>
            </div>
            <div class="font-semibold text-gray-800">Schedule Event</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <div class="bg-green-100 p-3 rounded-full inline-block mb-3">
                <i class="bi bi-file-earmark-text-fill text-green-600 text-2xl"></i>
            </div>
            <div class="font-semibold text-gray-800">Review Content</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <div class="bg-orange-100 p-3 rounded-full inline-block mb-3">
                <i class="bi bi-graph-up text-orange-600 text-2xl"></i>
            </div>
            <div class="font-semibold text-gray-800">Analytics</div>
        </div>
    </div>

    <!-- Recent Activity and Upcoming Events Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Recent Activity</h3>
            <ul class="space-y-4">
                <li class="flex items-start">
                    <div class="w-2 h-2 bg-purple-500 rounded-full mt-2 mr-3"></div>
                    <div>
                        <div class="font-semibold text-gray-800">New entrepreneur profile pending approval</div>
                        <div class="text-sm text-gray-500">2 minutes ago</div>
                    </div>
                </li>
                <li class="flex items-start">
                    <div class="w-2 h-2 bg-purple-500 rounded-full mt-2 mr-3"></div>
                    <div>
                        <div class="font-semibold text-gray-800">Business Plan Workshop completed</div>
                        <div class="text-sm text-gray-500">1 hour ago</div>
                    </div>
                </li>
                <li class="flex items-start">
                    <div class="w-2 h-2 bg-purple-500 rounded-full mt-2 mr-3"></div>
                    <div>
                        <div class="font-semibold text-gray-800">Pitch event scheduled for next week</div>
                        <div class="text-sm text-gray-500">3 hours ago</div>
                    </div>
                </li>
                <li class="flex items-start">
                    <div class="w-2 h-2 bg-purple-500 rounded-full mt-2 mr-3"></div>
                    <div>
                        <div class="font-semibold text-gray-800">5 new feedback submissions received</div>
                        <div class="text-sm text-gray-500">1 day ago</div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Upcoming Events</h3>
            <ul class="space-y-4">
                <li class="flex items-center justify-between">
                    <div>
                        <div class="font-semibold text-gray-800">Digital Marketing Workshop</div>
                        <div class="text-sm text-gray-500">Tomorrow 10:00 AM</div>
                    </div>
                    <div class="text-right">
                        <div class="font-semibold text-purple-600">25</div>
                        <div class="text-sm text-gray-500">participants</div>
                    </div>
                </li>
                <li class="flex items-center justify-between">
                    <div>
                        <div class="font-semibold text-gray-800">Investor Pitch Day</div>
                        <div class="text-sm text-gray-500">Friday 2:00 PM</div>
                    </div>
                    <div class="text-right">
                        <div class="font-semibold text-purple-600">12</div>
                        <div class="text-sm text-gray-500">participants</div>
                    </div>
                </li>
                <li class="flex items-center justify-between">
                    <div>
                        <div class="font-semibold text-gray-800">Mentorship Matching Session</div>
                        <div class="text-sm text-gray-500">Next Monday 9:00 AM</div>
                    </div>
                    <div class="text-right">
                        <div class="font-semibold text-purple-600">18</div>
                        <div class="text-sm text-gray-500">participants</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection
