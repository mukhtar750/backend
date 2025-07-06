@extends('admin.layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Analytics Dashboard</h1>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @php
            $analyticsCards = [
                ['title' => 'Total Users', 'value' => '1,200', 'icon' => 'bi-people', 'color' => 'magenta'],
                ['title' => 'Active Sessions', 'value' => '85', 'icon' => 'bi-graph-up', 'color' => 'blue'],
                ['title' => 'Page Views', 'value' => '15,000', 'icon' => 'bi-eye', 'color' => 'green'],
            ];
        @endphp

        @foreach ($analyticsCards as $card)
            <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
                <div>
                    <p class="text-gray-500">{{ $card['title'] }}</p>
                    <div class="text-2xl font-bold text-{{ $card['color'] }}-600">{{ $card['value'] }}</div>
                </div>
                <i class="bi {{ $card['icon'] }} text-{{ $card['color'] }}-400 text-4xl"></i>
            </div>
        @endforeach
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">User Growth Over Time</h3>
            <canvas id="userGrowthChart"></canvas>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Session Duration</h3>
            <canvas id="sessionDurationChart"></canvas>
        </div>
    </div>

    <!-- Recent Activity / Top Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Recent User Activity</h3>
            <ul class="divide-y divide-gray-200">
                <li class="py-3 flex justify-between items-center">
                    <span>User A logged in</span>
                    <span class="text-gray-500 text-sm">10 minutes ago</span>
                </li>
                <li class="py-3 flex justify-between items-center">
                    <span>User B viewed Training Programs</span>
                    <span class="text-gray-500 text-sm">30 minutes ago</span>
                </li>
                <li class="py-3 flex justify-between items-center">
                    <span>User C scheduled a Mentorship Session</span>
                    <span class="text-gray-500 text-sm">1 hour ago</span>
                </li>
            </ul>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Top Viewed Content</h3>
            <ul class="divide-y divide-gray-200">
                <li class="py-3 flex justify-between items-center">
                    <span>Business Model Validation Training</span>
                    <span class="text-gray-500 text-sm">500 views</span>
                </li>
                <li class="py-3 flex justify-between items-center">
                    <span>Mentorship Program Overview</span>
                    <span class="text-gray-500 text-sm">450 views</span>
                </li>
                <li class="py-3 flex justify-between items-center">
                    <span>Annual Innovation Pitch Day</span>
                    <span class="text-gray-500 text-sm">400 views</span>
                </li>
            </ul>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // User Growth Chart
                const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
                new Chart(userGrowthCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'New Users',
                            data: [50, 75, 120, 150, 180, 200],
                            borderColor: '#b81d8f',
                            backgroundColor: 'rgba(184, 29, 143, 0.2)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Session Duration Chart
                const sessionDurationCtx = document.getElementById('sessionDurationChart').getContext('2d');
                new Chart(sessionDurationCtx, {
                    type: 'bar',
                    data: {
                        labels: ['0-5 min', '5-15 min', '15-30 min', '30+ min'],
                        datasets: [{
                            label: 'Sessions',
                            data: [30, 50, 15, 5],
                            backgroundColor: ['#b81d8f', '#6a0dad', '#8a2be2', '#9370db'],
                            borderColor: ['#b81d8f', '#6a0dad', '#8a2be2', '#9370db'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection