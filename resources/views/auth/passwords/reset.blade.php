<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AWN Venture Ready Portal - Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #f9f0ff 0%, #f0e5ff 100%); }
        .logo-text { background: linear-gradient(to right, #b81d8f, #6a0dad); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .input-field { transition: all 0.3s ease; box-shadow: 0 2px 5px rgba(184, 29, 143, 0.1); }
        .input-field:focus { border-color: #b81d8f; box-shadow: 0 0 0 3px rgba(184, 29, 143, 0.2); }
        .reset-btn { transition: all 0.3s ease; background-color: #b81d8f; }
        .reset-btn:hover { background-color: #9e187a; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(184, 29, 143, 0.3); }
        .login-link { color: #b81d8f; }
        .login-link:hover { text-decoration: underline; }
        .abstract-shape { position: absolute; width: 300px; height: 300px; border-radius: 50%; background: rgba(184, 29, 143, 0.05); filter: blur(60px); z-index: -1; }
        .fade-in { animation: fadeIn 1s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(30px);} to { opacity: 1; transform: none; } }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Abstract background shapes -->
    <div class="abstract-shape top-0 left-0"></div>
    <div class="abstract-shape bottom-0 right-0"></div>

    <div class="w-full max-w-md fade-in">
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
            <a href="#" aria-label="Go to home">
                <img src="/images/logo.jpg" alt="AWN Logo" class="w-20 h-20 object-contain rounded-full shadow-lg">
            </div>
            <h1 class="text-3xl font-bold logo-text mb-1">AWN Venture Ready Portal</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mt-6">Set New Password</h2>
            <p class="text-gray-600 mt-2">Create a new secure password for your account</p>
        </div>

        <!-- Reset Password Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            @if (session('status'))
                <div class="mb-4 text-green-600 text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 text-red-600 text-sm font-medium">
                    {{ $errors->first() }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.update') }}" class="space-y-5" x-data="{ show: false, showConfirm: false }">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required autofocus
                        class="w-full px-4 py-3 rounded-lg input-field border border-gray-300 focus:outline-none focus:border-b81d8f"
                        value="{{ $email ?? old('email') }}" readonly>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" id="password" name="password" required
                            class="w-full px-4 py-3 rounded-lg input-field border border-gray-300 focus:outline-none focus:border-b81d8f pr-12">
                        <button type="button" @click="show = !show" tabindex="-1"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-b81d8f focus:outline-none">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.654 17.654L6.346 6.346" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Password must be at least 8 characters</p>
                </div>
                
                <div>
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <div class="relative">
                        <input :type="showConfirm ? 'text' : 'password'" id="password-confirm" name="password_confirmation" required
                            class="w-full px-4 py-3 rounded-lg input-field border border-gray-300 focus:outline-none focus:border-b81d8f pr-12">
                        <button type="button" @click="showConfirm = !showConfirm" tabindex="-1"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-b81d8f focus:outline-none">
                            <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.654 17.654L6.346 6.346" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <button type="submit"
                    class="w-full py-3 px-4 rounded-lg text-white font-semibold reset-btn focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-b81d8f">
                    Reset Password
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center text-xs text-gray-500 mt-8">
            © 2025 AWN. Empowering female-led ventures.
        </div>
    </div>
</body>
</html>