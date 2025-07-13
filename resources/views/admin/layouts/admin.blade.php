<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .active {
            @apply bg-white text-purple-800 font-semibold shadow-sm;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-purple-800 text-white flex flex-col">
        <div class="px-6 py-4 text-2xl font-bold">Innovation Portal</div>
        <div class="px-6 text-sm mb-4">Admin Panel</div>
        <nav class="flex-1 px-4 space-y-2">
            @php $route = Route::currentRouteName(); @endphp

            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 {{ $route == 'admin.dashboard' ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>
            <a href="{{ route('admin.user-management') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 {{ $route == 'admin.user-management' ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> User Management
            </a>
            <a href="{{ route('admin.training_programs') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 {{ $route == 'admin.training_programs' ? 'active' : '' }}">
                <i class="bi bi-book-fill"></i> Training Programs
            </a>
            <a href="{{ route('admin.mentorship') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 {{ $route == 'admin.mentorship' ? 'active' : '' }}">
                <i class="bi bi-person-check-fill"></i> Mentorship
            </a>
            <a href="{{ route('admin.pitch_events') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 {{ $route == 'admin.pitch_events' ? 'active' : '' }}">
                <i class="bi bi-megaphone-fill"></i> Pitch Events
            </a>
            <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 {{ $route == 'admin.analytics' ? 'active' : '' }}">
                <i class="bi bi-graph-up"></i> Analytics
            </a>
            <a href="{{ route('admin.content_management') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 {{ $route == 'admin.content_management' ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text-fill"></i> Content Management
            </a>
            <a href="{{ route('admin.messages') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-purple-700 {{ $route == 'admin.messages' ? 'active' : '' }}">
                <i class="bi bi-envelope-fill"></i> Messages
            </a>
        </nav>

        <div class="p-4 border-t border-purple-700">
            <div class="flex items-center mb-2">
                <img class="h-10 w-10 rounded-full mr-3" src="https://via.placeholder.com/40" alt="Sarah Admin">
                <div>
                    <div class="font-semibold">Sarah Admin</div>
                    <div class="text-sm text-gray-300">admin@awn.org</div>
                </div>
            </div>
            <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-2 text-gray-200 hover:bg-purple-700 rounded-md">
                <i class="bi bi-gear-fill"></i> Settings
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-4 py-2 text-gray-200 hover:bg-purple-700 rounded-md">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Top Navigation -->
        <header class="flex items-center justify-between bg-white p-4 shadow-sm border-b">
            <div class="flex items-center gap-3">
                <img src="https://cdn-icons-png.flaticon.com/512/616/616494.png" alt="Logo" class="h-7 w-7 mr-2">
                <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
            </div>
            <div class="flex items-center gap-4 flex-1 justify-end">
                <div class="relative w-80 max-w-xs mr-4">
                    <input type="text" placeholder="Search..." class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    <i class="bi bi-search text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                </div>
                <a href="#" class="relative text-gray-600 hover:text-gray-800 mr-2">
                    <i class="bi bi-chat-dots text-xl"></i>
                </a>
                @include('components.notification-badge')
                <div class="flex items-center">
                    <img class="h-8 w-8 rounded-full mr-2" src="https://via.placeholder.com/32" alt="Sarah Admin">
                    <div>
                        <div class="font-semibold text-gray-800 text-sm">Sarah Admin</div>
                        <div class="text-xs text-gray-500">Admin</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 bg-gray-100 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
