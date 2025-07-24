<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Entrepreneur Dashboard')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="font-sans antialiased bg-gray-100">
    @php $route = Route::currentRouteName(); @endphp
    @php $role = auth()->user()->role; @endphp
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-[#b81d8f] text-white flex flex-col">
            <div class="p-4 text-2xl font-bold border-b border-[#a01a7d]">
                <i class="bi bi-person-badge-fill mr-2"></i> VR Portal
            </div>
            <div class="p-4 text-sm border-b border-[#a01a7d] tracking-wide">
                Entrepreneur Panel
            </div>
            <nav class="flex-1 px-2 py-4 space-y-2">
                <a href="{{ route('dashboard.entrepreneur') }}" class="flex items-center px-4 py-2 text-white hover:bg-[#a01a7d] rounded-lg font-medium"><i class="bi bi-grid-fill mr-3"></i> Dashboard</a>
                <a href="{{ route('entrepreneur.progress') }}" class="flex items-center px-4 py-2 text-white hover:bg-[#a01a7d] rounded-lg font-medium"><i class="bi bi-bar-chart-fill mr-3"></i> My Progress</a>
                <a href="{{ route('entrepreneur.calendar') }}" class="flex items-center px-4 py-2 text-white hover:bg-[#a01a7d] rounded-lg font-medium"><i class="bi bi-calendar-event-fill mr-3"></i> Training Calendar</a>
                <a href="{{ route('entrepreneur.mentorship') }}" class="flex items-center px-4 py-2 text-white hover:bg-[#a01a7d] rounded-lg font-medium"><i class="bi bi-people-fill mr-3"></i> Mentorship</a>
                <a href="{{ route('entrepreneur.pitch') }}" class="flex items-center px-4 py-2 text-white hover:bg-[#a01a7d] rounded-lg font-medium"><i class="bi bi-easel-fill mr-3"></i> Pitch Preparation</a>
                <a href="{{ route('entrepreneur.startup-profile') }}" class="flex items-center px-4 py-2 text-white hover:bg-[#a01a7d] rounded-lg font-medium"><i class="bi bi-building mr-3"></i> My Startup Profile</a>
                <a href="{{ route('entrepreneur.tasks') }}" class="flex items-center px-4 py-2 text-white hover:bg-[#a01a7d] rounded-lg font-medium"><i class="bi bi-check2-square mr-3"></i> Assignments & Tasks</a>
                <a href="{{ route('messages.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 {{ $route == 'messages.index' ? 'bg-white text-purple-800 font-semibold shadow-sm' : '' }}">
                    <i class="bi bi-chat-dots"></i> Messages
                </a>
                <a href="{{ route('entrepreneur.feedback') }}" class="flex items-center px-4 py-2 text-white hover:bg-[#a01a7d] rounded-lg font-medium"><i class="bi bi-chat-dots-fill mr-3"></i> Feedback</a>
            </nav>
            <div class="p-4 border-t border-[#a01a7d]">
                <div class="flex items-center mb-3">
                    <img class="h-10 w-10 rounded-full mr-3 border border-white" src="https://i.pravatar.cc/40" alt="{{ Auth::user()->name }}">
                    <div>
                        <div class="font-semibold">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-pink-100">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-[#a01a7d] rounded-lg font-medium"><i class="bi bi-gear-fill mr-3"></i> Settings</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-1">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-white hover:bg-[#a01a7d] rounded-lg font-medium">
                        <i class="bi bi-box-arrow-right mr-3"></i> Logout
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
                    <a href="{{ route('messages.index') }}" class="relative text-gray-600 hover:text-gray-800 mr-2">
                        <i class="bi bi-chat-dots-fill text-xl"></i>
                        @php
                            $unreadMessages = auth()->check() ? auth()->user()->getUnreadMessageCount() : 0;
                        @endphp
                        @if($unreadMessages > 0)
                            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-blue-600 rounded-full">
                                {{ $unreadMessages > 99 ? '99+' : $unreadMessages }}
                            </span>
                        @endif
                    </a>
                    <div class="flex items-center">
                        <img class="h-8 w-8 rounded-full mr-2" src="https://i.pravatar.cc/32" alt="{{ Auth::user()->name }}">
                        <div>
                            <div class="font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500">Entrepreneur</div>
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
</body>
</html>