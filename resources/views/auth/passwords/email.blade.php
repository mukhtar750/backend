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
            <h2 class="text-2xl font-semibold text-gray-800 mt-6">Reset Password</h2>
            <p class="text-gray-600 mt-2">Enter your email to receive a password reset link</p>
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
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required autofocus
                        class="w-full px-4 py-3 rounded-lg input-field border border-gray-300 focus:outline-none focus:border-b81d8f"
                        value="{{ old('email') }}">
                </div>
                <button type="submit"
                    class="w-full py-3 px-4 rounded-lg text-white font-semibold reset-btn focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-b81d8f">
                    Send Password Reset Link
                </button>
                <div class="text-center text-sm text-gray-600 mt-4">
                    Remember your password?
                    <a href="{{ route('login') }}" class="font-medium login-link">Back to Login</a>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center text-xs text-gray-500 mt-8">
            © 2025 AWN. Empowering female-led ventures.
        </div>
    </div>
</body>
</html>