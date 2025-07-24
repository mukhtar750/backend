@extends('layouts.mentor')

@section('content')
    <!-- Header -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Welcome back, Mentor {{ $mentor->name ?? 'Mentor' }}!</h1>
            <p class="text-gray-600">Your mentorship impact at a glance</p>
        </div>
        <div class="flex items-center mt-4 md:mt-0">
            <div class="relative mr-4">
                <button class="p-2 rounded-full hover:bg-gray-100">
                    <i class="fas fa-bell text-gray-600"></i>
                    @if($notificationsCount ?? 0)
                        <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                    @endif
                </button>
            </div>
            <div class="flex items-center">
                <img src="{{ $mentor->profile_photo_url ?? asset('images/avatar-placeholder.png') }}" alt="Profile" class="h-10 w-10 rounded-full object-cover border-2 border-indigo-100">
                <span class="ml-2 font-medium text-gray-700">{{ $mentor->name ?? 'Mentor' }}</span>
            </div>
        </div>
    </header>

    <!-- Quick Actions -->
    <div class="flex flex-wrap gap-4 mb-8">
        <a href="{{ route('mentor.sessions.create') }}" class="flex items-center px-4 py-2 bg-indigo-700 text-white rounded-lg shadow hover:bg-indigo-800 transition">
            <i class="fas fa-plus mr-2"></i> Schedule Session
        </a>
        <a href="{{ route('mentor.resources') }}" class="flex items-center px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
            <i class="fas fa-upload mr-2"></i> Upload Resource
        </a>
        <a href="{{ route('mentor.forms') }}" class="flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition">
            <i class="fas fa-file-alt mr-2"></i> Review Forms
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex items-center">
            <div class="p-3 rounded-lg bg-indigo-50 text-indigo-900 mr-4">
                <i class="fas fa-user-friends"></i>
            </div>
            <div>
                <p class="text-gray-500">Active Mentees</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $stats['mentees'] ?? 0 }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex items-center">
            <div class="p-3 rounded-lg bg-purple-50 text-purple-900 mr-4">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <p class="text-gray-500">Upcoming Sessions</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $stats['upcoming_sessions'] ?? 0 }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex items-center">
            <div class="p-3 rounded-lg bg-green-50 text-green-900 mr-4">
                <i class="fas fa-book-open"></i>
            </div>
            <div>
                <p class="text-gray-500">Resources</p>
                <h3 class="text-2xl font-bold text-gray-800">--</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 flex items-center">
            <div class="p-3 rounded-lg bg-yellow-50 text-yellow-900 mr-4">
                <i class="fas fa-comment-dots"></i>
            </div>
            <div>
                <p class="text-gray-500">Feedback</p>
                <h3 class="text-2xl font-bold text-gray-800">--</h3>
            </div>
        </div>
    </div>

    <!-- Upcoming Sessions -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Upcoming Sessions</h2>
            <a href="{{ route('mentor.sessions.create') }}" class="btn-primary text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Schedule New Session
            </a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($upcomingSessions as $session)
                <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div class="flex items-center mb-4 md:mb-0">
                            <img src="{{ $session->mentee->profile_photo_url ?? asset('images/avatar-placeholder.png') }}" alt="Mentee" class="h-12 w-12 rounded-full object-cover mr-4">
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $session->mentee->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $session->mentee->startup_name ?? '' }} - {{ $session->mentee->startup_stage ?? '' }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center">
                            <div class="mb-2 md:mb-0 md:mr-8">
                                <p class="text-sm text-gray-500">Date & Time</p>
                                <p class="font-medium">{{ $session->date_time ? $session->date_time->format('D, h:i A') : '' }}</p>
                            </div>
                            <span class="{{ $session->status == 'confirmed' ? 'status-confirmed' : 'status-pending' }} px-3 py-1 rounded-full text-sm font-medium inline-block">
                                {{ ucfirst($session->status) }}
                            </span>
                        </div>
                        @if($session->meeting_link)
                            <a href="{{ $session->meeting_link }}" target="_blank"
                               class="inline-flex items-center mt-4 px-4 py-2 bg-pink-600 text-white rounded-lg shadow hover:bg-pink-700 transition font-bold border-2 border-pink-700">
                                <i class="fas fa-video mr-2"></i> Join Session
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-6 text-gray-500">No upcoming sessions.</div>
            @endforelse
        </div>
    </div>

    <!-- Past Sessions -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Past Sessions</h2>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($pastSessions as $session)
                <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div class="flex items-center mb-4 md:mb-0">
                            <img src="{{ $session->mentee->profile_photo_url ?? asset('images/avatar-placeholder.png') }}" alt="Mentee" class="h-12 w-12 rounded-full object-cover mr-4">
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $session->mentee->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $session->mentee->startup_name ?? '' }} - {{ $session->mentee->startup_stage ?? '' }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center">
                            <div class="mb-2 md:mb-0 md:mr-8">
                                <p class="text-sm text-gray-500">Date & Time</p>
                                <p class="font-medium">{{ $session->date_time ? $session->date_time->format('D, h:i A') : '' }}</p>
                            </div>
                            <span class="{{ $session->status == 'confirmed' ? 'status-confirmed' : 'status-pending' }} px-3 py-1 rounded-full text-sm font-medium inline-block">
                                {{ ucfirst($session->status) }}
                            </span>
                        </div>
                        @if($session->meeting_link)
                            <a href="{{ $session->meeting_link }}" target="_blank"
                               class="inline-flex items-center mt-4 px-4 py-2 bg-pink-600 text-white rounded-lg shadow hover:bg-pink-700 transition font-bold border-2 border-pink-700">
                                <i class="fas fa-video mr-2"></i> Join Session
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-6 text-gray-500">No past sessions.</div>
            @endforelse
        </div>
    </div>

    <!-- Recent Messages & Assigned Mentees -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Messages -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-semibold text-gray-800">Recent Messages</h2>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($messages as $message)
                    <a href="{{ route('messages.show', $message->conversation_id) }}" class="block p-6 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-start">
                            <img src="{{ $message->sender->profile_photo_url ?? asset('images/avatar-placeholder.png') }}" alt="Mentee" class="h-10 w-10 rounded-full object-cover mr-4">
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-medium text-gray-800">{{ $message->sender->name }}</h4>
                                    <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-600 mt-1">{{ Str::limit($message->body, 80) }}</p>
                            </div>
                            @if(!$message->read)
                                <span class="h-2 w-2 rounded-full bg-indigo-600 ml-2 mt-2"></span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="p-6 text-gray-500">No recent messages.</div>
                @endforelse
            </div>
            <div class="p-4 text-center border-t border-gray-100">
                <a href="{{ route('mentor.messages.index') }}" class="text-indigo-900 font-medium hover:text-indigo-700">View all messages</a>
            </div>
        </div>
        <!-- Assigned Mentees -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-semibold text-gray-800">Assigned Mentees</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-6">
                @forelse($mentees as $mentee)
                    <div class="card-hover bg-white border border-gray-100 rounded-lg p-4 shadow-sm transition-all duration-300">
                        <div class="flex items-center mb-3">
                            <img src="{{ $mentee->profile_photo_url ?? asset('images/avatar-placeholder.png') }}" alt="Mentee" class="h-10 w-10 rounded-full object-cover mr-3">
                            <h4 class="font-medium text-gray-800">{{ $mentee->name }}</h4>
                        </div>
                        <p class="text-sm text-gray-600 mb-1"><span class="font-medium">Startup:</span> {{ $mentee->startup_name ?? '-' }}</p>
                        <p class="text-sm text-gray-600"><span class="font-medium">Stage:</span> {{ $mentee->startup_stage ?? '-' }}</p>
                        <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-xs px-2 py-1 bg-indigo-50 text-indigo-900 rounded">{{ $mentee->industry ?? 'N/A' }}</span>
                            <a href="{{ route('mentor.mentees.show', $mentee->id) }}" class="text-xs text-indigo-900 hover:underline">View Profile</a>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-gray-500">No assigned mentees.</div>
                @endforelse
            </div>
            <div class="p-4 text-center border-t border-gray-100">
                <a href="{{ route('mentor.mentees.index') }}" class="text-indigo-900 font-medium hover:text-indigo-700">View all mentees</a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .sidebar-link:hover { background-color: rgba(75, 0, 130, 0.1); transform: translateX(4px); }
        .sidebar-link.active { background-color: rgba(75, 0, 130, 0.1); border-left: 4px solid #4B0082; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); }
        .btn-primary { background-color: #4B0082; transition: all 0.3s ease; }
        .btn-primary:hover { background-color: #3a0068; transform: translateY(-2px); }
        .status-confirmed { background-color: rgba(74, 222, 128, 0.2); color: #16a34a; }
        .status-pending { background-color: rgba(253, 230, 138, 0.2); color: #d97706; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
            .sidebar.open { transform: translateX(0); }
            .overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 10; display: none; }
            .overlay.open { display: block; }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function () {
            const menuBtn = document.getElementById('menuBtn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            if(menuBtn && sidebar && overlay) {
                menuBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('open');
                    overlay.classList.toggle('open');
                });
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('open');
                });
            }
            // Set active sidebar link
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    sidebarLinks.forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                });
            });
        });
    </script>
@endpush 