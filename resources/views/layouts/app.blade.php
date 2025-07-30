<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VR Portal')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpg') }}">

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Styles -->
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <img src="https://cdn-icons-png.flaticon.com/512/616/616494.png" alt="Logo" class="h-8 w-8">
                        <span class="text-xl font-bold text-gray-800">VR Portal</span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.messages') : route('messages.index') }}" class="text-gray-600 hover:text-gray-800 relative">
                        <i class="bi bi-chat-dots text-xl"></i>
                        @if(auth()->user()->getUnreadMessageCount() > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ auth()->user()->getUnreadMessageCount() }}</span>
                        @endif
                    </a>
                    @include('components.notification-badge')
                    <div class="flex items-center space-x-2">
                        <img class="h-8 w-8 rounded-full" src="https://via.placeholder.com/32" alt="User">
                        <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>
</body>
</html>
