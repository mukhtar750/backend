<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aryaas Venture | Mentor Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="min-h-screen flex">
    <!-- Mobile menu button -->
    <div class="md:hidden fixed top-4 left-4 z-20">
        <button id="menuBtn" class="p-2 rounded-lg bg-white shadow-md text-indigo-900">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <!-- Overlay for mobile -->
    <div id="overlay" class="overlay"></div>
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar relative w-64 min-h-screen h-auto bg-[#6c3483] text-white shadow-md z-20 flex flex-col flex-shrink-0">
        <div class="p-6 flex-1 flex flex-col">
            <div class="flex items-center justify-center mb-8">
                <img src="{{ asset('images/avatar-placeholder.png') }}" alt="Aryaas Logo" class="h-10 w-10">
                <h1 class="text-xl font-bold ml-3 text-white">Aryaas</h1>
            </div>
            <nav class="mt-8 space-y-1 flex-1">
                <a href="{{ route('mentor.dashboard') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition-all duration-300 {{ request()->routeIs('mentor.dashboard') ? 'bg-white text-[#6c3483] font-semibold shadow-sm' : 'hover:bg-purple-700' }}">
                    <i class="fas fa-home mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('mentor.mentees.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition-all duration-300 {{ request()->routeIs('mentor.mentees.*') ? 'bg-white text-[#6c3483] font-semibold shadow-sm' : 'hover:bg-purple-700' }}">
                    <i class="fas fa-user-friends mr-3"></i>
                    <span>Mentees</span>
                </a>
                <a href="{{ route('mentor.sessions.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition-all duration-300 {{ request()->routeIs('mentor.sessions.*') ? 'bg-white text-[#6c3483] font-semibold shadow-sm' : 'hover:bg-purple-700' }}">
                    <i class="fas fa-calendar-check mr-3"></i>
                    <span>Sessions</span>
                </a>
                <a href="{{ route('mentor.messages.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition-all duration-300 {{ request()->routeIs('mentor.messages.*') ? 'bg-white text-[#6c3483] font-semibold shadow-sm' : 'hover:bg-purple-700' }}">
                    <i class="fas fa-comments mr-3"></i>
                    <span>Messages</span>
                </a>
                <a href="{{ route('mentor.resources') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition-all duration-300 {{ request()->routeIs('mentor.resources') ? 'bg-white text-[#6c3483] font-semibold shadow-sm' : 'hover:bg-purple-700' }}">
                    <i class="fas fa-book-open mr-3"></i>
                    <span>Resources</span>
                </a>
                <a href="{{ route('mentor.forms') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition-all duration-300 {{ request()->routeIs('mentor.forms*') ? 'bg-white text-[#6c3483] font-semibold shadow-sm' : 'hover:bg-purple-700' }}">
                    <i class="fas fa-file-alt mr-3"></i>
                    <span>Forms</span>
                </a>
                <a href="{{ route('mentor.calendar') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition-all duration-300 {{ request()->routeIs('mentor.calendar') ? 'bg-white text-[#6c3483] font-semibold shadow-sm' : 'hover:bg-purple-700' }}">
                    <i class="fas fa-calendar-alt mr-3"></i>
                    <span>Calendar</span>
                </a>
                <a href="{{ route('mentor.reports') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition-all duration-300 {{ request()->routeIs('mentor.reports') ? 'bg-white text-[#6c3483] font-semibold shadow-sm' : 'hover:bg-purple-700' }}">
                    <i class="fas fa-chart-line mr-3"></i>
                    <span>Reports/Outcomes</span>
                </a>
                <a href="{{ route('mentor.tasks.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition-all duration-300 {{ request()->routeIs('mentor.tasks.*') ? 'bg-white text-[#6c3483] font-semibold shadow-sm' : 'hover:bg-purple-700' }}">
                    <i class="fas fa-tasks mr-3"></i>
                    <span>Tasks</span>
                </a>
                <a href="{{ route('ideas.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition-all duration-300 {{ request()->routeIs('ideas.*') ? 'bg-white text-[#6c3483] font-semibold shadow-sm' : 'hover:bg-yellow-400 hover:text-[#6c3483]' }}">
                    <i class="fas fa-lightbulb mr-3"></i>
                    <span>Ideas Bank</span>
                </a>
                <a href="{{ route('mentor.settings') }}" class="sidebar-link flex items-center px-4 py-3 rounded-lg transition-all duration-300 {{ request()->routeIs('mentor.settings') ? 'bg-white text-[#6c3483] font-semibold shadow-sm' : 'hover:bg-purple-700' }}">
                    <i class="fas fa-cog mr-3"></i>
                    <span>Settings</span>
                </a>
            </nav>
        </div>
        <div class="p-6 border-t border-[#512e5f]">
            <div class="flex items-center mb-3">
                <img class="h-10 w-10 rounded-full mr-3 border border-white" src="{{ Auth::user()->profile_photo_url ?? asset('images/avatar-placeholder.png') }}" alt="{{ Auth::user()->name }}">
                <div>
                    <div class="font-semibold">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-purple-100">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <a href="{{ route('mentor.settings') }}" class="flex items-center px-4 py-2 text-white hover:bg-[#512e5f] rounded-lg transition-all font-medium">
                <i class="fas fa-cog mr-3"></i> Settings
            </a>
            <form action="{{ route('logout') }}" method="POST" class="mt-1">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-2 text-white hover:bg-[#512e5f] rounded-lg transition-all font-medium">
                    <i class="fas fa-sign-out-alt mr-3"></i> Logout
                </button>
            </form>
        </div>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 overflow-auto min-h-screen bg-gray-50">
        <div class="p-6 md:p-8">
            @yield('content')
        </div>
    </main>
    @stack('scripts')
</body>
</html>