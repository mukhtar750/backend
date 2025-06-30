<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Tailwind CSS CDN for prototyping -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-purple-800 text-white flex flex-col">
            <div class="p-4 text-2xl font-bold border-b border-purple-700">
                Innovation Portal
            </div>
            <div class="p-4 text-sm border-b border-purple-700">
                Admin Panel
            </div>
            <nav class="flex-1 px-2 py-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-200 hover:bg-purple-700 rounded-md">
                    <i class="bi bi-grid-fill mr-3"></i> Dashboard
                </a>
                <a href="{{ route('admin.user-management') }}" class="flex items-center px-4 py-2 text-gray-200 hover:bg-purple-700 rounded-md">
                    <i class="bi bi-people-fill mr-3"></i> User Management
                </a>
                <a href="{{ route('admin.training_programs') }}" class="flex items-center px-4 py-2 text-gray-200 hover:bg-purple-700 rounded-md">
                    <i class="bi bi-book-fill mr-3"></i> Training Programs
                </a>
                <a href="{{ route('admin.mentorship') }}" class="flex items-center px-4 py-2 text-gray-200 hover:bg-purple-700 rounded-md">
                    <i class="bi bi-person-check-fill mr-3"></i> Mentorship
                </a>
                <a href="{{ route('admin.pitch_events') }}" class="flex items-center px-4 py-2 text-gray-200 hover:bg-purple-700 rounded-md">
                    <i class="bi bi-megaphone-fill mr-3"></i> Pitch Events
                </a>
                <a href="{{ route('admin.analytics') }}" class="flex items-center px-4 py-2 text-gray-200 hover:bg-purple-700 rounded-md">
                    <i class="bi bi-graph-up mr-3"></i> Analytics
                </a>
                <a href="{{ route('admin.content_management') }}" class="flex items-center px-4 py-2 text-gray-200 hover:bg-purple-700 rounded-md">
                    <i class="bi bi-file-earmark-text-fill mr-3"></i> Content Management
                </a>
            </nav>
            <div class="p-4 border-t border-purple-700">
                <div class="flex items-center">
                    <img class="h-10 w-10 rounded-full mr-3" src="https://via.placeholder.com/40" alt="Sarah Admin">
                    <div>
                        <div class="font-semibold">Sarah Admin</div>
                        <div class="text-sm text-gray-400">admin@awn.org</div>
                    </div>
                </div>
                <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-2 text-gray-200 hover:bg-purple-700 rounded-md mt-2">
                    <i class="bi bi-gear-fill mr-3"></i> Settings
                </a>
                <form action="{{ route('logout') }}" method="POST" class="flex items-center px-4 py-2 text-gray-200 hover:bg-purple-700 rounded-md mt-1">
@csrf
<button type="submit" class="flex items-center">
<i class="bi bi-box-arrow-right mr-3"></i> Logout
</button>
</form>
                </a>
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
                        <input type="text" placeholder="Search..." class="border border-gray-300 rounded-md py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <a href="#" class="relative text-gray-600 hover:text-gray-800">
                        <i class="bi bi-bell-fill text-xl"></i>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">2</span>
                    </a>
                    <div class="flex items-center">
                        <img class="h-8 w-8 rounded-full mr-2" src="https://via.placeholder.com/32" alt="Sarah Admin">
                        <div>
                            <div class="font-semibold text-gray-800">Sarah Admin</div>
                            <div class="text-sm text-gray-500">Admin</div>
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