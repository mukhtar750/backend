<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Investor Dashboard')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Styles -->
    @vite('resources/css/app.css')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-[#b81d8f] text-white flex flex-col justify-between py-4">
            <!-- Branding/Header -->
            <div>
                <div class="flex items-center gap-3 px-6 pb-2">
                    <span class="bg-yellow-400 text-white rounded-full p-2 flex items-center justify-center"><i class="bi bi-award-fill text-xl"></i></span>
                    <div>
                        <div class="text-lg font-bold leading-tight">AWN Portal</div>
                        <div class="text-xs text-pink-100">Investor Panel</div>
                    </div>
                </div>
                <nav class="mt-8 flex flex-col gap-1 px-2">
                    <a href="{{ route('dashboard.investor') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold {{ request()->routeIs('dashboard.investor') ? 'bg-[#a01a7d] shadow-sm' : 'hover:bg-[#a01a7d] transition' }}">
                        <i class="bi bi-grid-fill text-lg"></i> Dashboard
                    </a>
                    <a href="{{ route('investor.startup_profiles') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium {{ request()->routeIs('investor.startup_profiles') ? 'bg-[#a01a7d] shadow-sm' : 'hover:bg-[#a01a7d] transition' }}">
                        <i class="bi bi-graph-up-arrow text-lg"></i> Startup Profiles
                    </a>
                    <a href="{{ route('investor.pitch_events') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium {{ request()->routeIs('investor.pitch_events') ? 'bg-[#a01a7d] shadow-sm' : 'hover:bg-[#a01a7d] transition' }}">
                        <i class="bi bi-calendar-event text-lg"></i> Pitch Events
                    </a>
                    <a href="{{ route('investor.proposals.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium {{ request()->routeIs('investor.proposals.*') ? 'bg-[#a01a7d] shadow-sm' : 'hover:bg-[#a01a7d] transition' }}">
                        <i class="bi bi-lightbulb text-lg"></i> My Proposals
                    </a>
                    <a href="{{ route('investor.success_stories') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium {{ request()->routeIs('investor.success_stories') ? 'bg-[#a01a7d] shadow-sm' : 'hover:bg-[#a01a7d] transition' }}">
                        <i class="bi bi-award text-lg"></i> Success Stories
                    </a>
                    <a href="{{ route('messages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium {{ request()->routeIs('messages.index') ? 'bg-[#a01a7d] shadow-sm' : 'hover:bg-[#a01a7d] transition' }}">
                        <i class="bi bi-chat-left-text text-lg"></i> Messages
                    </a>
                </nav>
            </div>
            <!-- User Profile Section -->
            <div class="px-6 pt-6 pb-2 border-t border-[#a01a7d] mt-8">
                <div class="flex items-center gap-3 mb-3">
                    <img class="h-10 w-10 rounded-full border-2 border-white" src="https://i.pravatar.cc/40" alt="Grace Investor">
                    <div>
                        <div class="font-semibold leading-tight">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-pink-100">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-[#a01a7d] transition text-sm font-medium">
                    <i class="bi bi-gear text-base"></i> Settings
                </a>
                <form action="{{ route('logout') }}" method="POST" class="mt-1">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 rounded-lg hover:bg-[#a01a7d] transition text-sm font-medium">
                        <i class="bi bi-box-arrow-right text-base"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="flex items-center justify-between p-4 bg-white border-b shadow-sm">
                <div class="flex items-center">
                    <h1 class="text-2xl font-semibold text-gray-800"><i class="bi bi-grid-fill mr-2"></i> Dashboard</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..." class="border border-gray-300 rounded-md py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-[#b81d8f]">
                        <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @include('components.notification-badge')
                    <div class="flex items-center">
                        <img class="h-8 w-8 rounded-full mr-2" src="https://i.pravatar.cc/32" alt="Grace Investor">
                        <div>
                            <div class="font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500">Investor</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @yield('content')
            </main>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>
</html>
