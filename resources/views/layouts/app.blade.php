<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Investor Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="font-sans antialiased bg-gray-100">

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-[#b81d8f] via-[#a01a7d] to-[#86156c] text-white flex flex-col">
        <div class="p-4 text-2xl font-bold border-b border-[#a01a7d]">Innovation Portal</div>
        <div class="p-4 text-sm border-b border-[#a01a7d]">Investor Panel</div>

        <nav class="flex-1 px-2 py-4 space-y-2">
            @foreach ([
                ['icon' => 'bi-grid-fill', 'text' => 'Dashboard'],
                ['icon' => 'bi-people-fill', 'text' => 'Startup Profiles'],
                ['icon' => 'bi-calendar-event-fill', 'text' => 'Pitch Events'],
                ['icon' => 'bi-award-fill', 'text' => 'Success Stories'],
            ] as $item)
                <a href="#" class="flex items-center px-4 py-2 hover:bg-[#a01a7d] rounded-lg font-medium transition">
                    <i class="bi {{ $item['icon'] }} mr-3"></i> {{ $item['text'] }}
                </a>
            @endforeach
        </nav>

        <div class="p-4 border-t border-[#a01a7d]">
            <div class="flex items-center mb-3">
                <img class="h-10 w-10 rounded-full mr-3 border border-white" src="https://i.pravatar.cc/40" alt="User avatar">
                <div>
                    <div class="font-semibold">Grace Investor</div>
                    <div class="text-sm text-pink-100">investor@example.com</div>
                </div>
            </div>
            <a href="#" class="flex items-center px-4 py-2 hover:bg-[#a01a7d] rounded-lg font-medium transition">
                <i class="bi bi-gear-fill mr-3"></i> Settings
            </a>
            <form action="#" method="POST" class="mt-1">
                <button type="submit" class="flex items-center w-full px-4 py-2 hover:bg-[#a01a7d] rounded-lg font-medium transition">
                    <i class="bi bi-box-arrow-right mr-3"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="flex items-center justify-between p-4 bg-white border-b shadow-sm">
            <h1 class="text-2xl font-semibold text-gray-800 flex items-center">
                <i class="bi bi-grid-fill mr-2 text-[#b81d8f]"></i> Dashboard
            </h1>

            <div class="flex items-center space-x-4">
                <!-- Search Bar -->
                <div class="relative text-gray-600">
                    <input type="text" aria-label="Search" placeholder="Search..." class="pl-10 pr-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#b81d8f]">
                    <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>

                <!-- Notifications -->
                <a href="#" class="relative hover:text-gray-800" aria-label="Notifications">
                    <i class="bi bi-bell-fill text-xl"></i>
                    <span class="absolute top-0 right-0 px-2 py-1 text-xs font-bold text-white bg-[#b81d8f] rounded-full">2</span>
                </a>

                <!-- Profile Summary -->
                <div class="flex items-center">
                    <img class="h-8 w-8 rounded-full mr-2" src="https://i.pravatar.cc/32" alt="User Avatar">
                    <div>
                        <div class="font-semibold text-gray-800">Grace Investor</div>
                        <div class="text-sm text-gray-500">Investor</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
            <!-- Welcome Banner -->
            <section class="rounded-xl p-8 bg-gradient-to-br from-[#b81d8f] via-[#a01a7d] to-[#86156c] text-white shadow-lg mb-6">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h2 class="text-3xl font-bold mb-2">Welcome, Grace! 👋</h2>
                        <p class="text-lg text-pink-100 max-w-xl">
                            Discover the next generation of African startups ready for investment.
                            Explore innovative ideas, connect with founders, and make informed investment decisions.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 mt-4 md:mt-0">
                        <a href="#" class="inline-block px-6 py-3 rounded-lg bg-white text-[#b81d8f] font-semibold text-sm shadow hover:bg-pink-50 transition">Browse Startups</a>
                        <a href="#" class="inline-block px-6 py-3 rounded-lg border border-white text-white font-semibold text-sm hover:bg-white hover:text-[#b81d8f] transition">Upcoming Pitches</a>
                    </div>
                </div>
            </section>

            <!-- Dynamic Content Slot -->
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
