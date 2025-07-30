<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as a Mentee | AWN Venture Ready Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .input-field:focus { box-shadow: 0 0 0 3px rgba(184, 29, 143, 0.2); }
        .btn-primary { background-color: #b81d8f; transition: all 0.3s ease; }
        .btn-primary:hover { background-color: #9e1879; transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <header class="bg-white shadow-sm py-4">
        <div class="container mx-auto px-4 flex justify-center items-center">
            <a href="/" class="flex items-center group">
                <img src="/images/logo.jpg" alt="AWN Logo" class="w-10 h-10 rounded-full shadow-lg mr-3 group-hover:scale-105 transition-transform">
                <h1 class="text-xl font-bold text-gray-800">AWN Venture Ready Portal</h1>
            </a>
        </div>
    </header>
    <main class="container mx-auto px-4 py-8 md:py-12">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Register as a Mentee</h2>
                <p class="text-gray-600 text-lg">Get matched with mentors and grow your venture skills.</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 md:p-8">
                <form method="POST" action="{{ route('register.mentee') }}" id="registrationForm" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}"
                               class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                        @error('name') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}"
                               class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                        @error('email') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Short Bio *</label>
                        <textarea id="bio" name="bio" required rows="3"
                                  class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">{{ old('bio') }}</textarea>
                        @error('bio') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="interests" class="block text-sm font-medium text-gray-700 mb-1">Interests *</label>
                        <input type="text" id="interests" name="interests" required value="{{ old('interests') }}"
                               class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none" placeholder="e.g. Marketing, Leadership, Tech">
                        @error('interests') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="goals" class="block text-sm font-medium text-gray-700 mb-1">Learning Goals *</label>
                        <textarea id="goals" name="goals" required rows="2"
                                  class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">{{ old('goals') }}</textarea>
                        @error('goals') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="linkedin" class="block text-sm font-medium text-gray-700 mb-1">LinkedIn Profile</label>
                        <input type="url" id="linkedin" name="linkedin" value="{{ old('linkedin') }}"
                               class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none" placeholder="https://linkedin.com/in/yourprofile">
                        @error('linkedin') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                        <input type="password" id="password" name="password" required minlength="6"
                               class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                        <p class="mt-1 text-xs text-gray-500">Password must be at least 6 characters</p>
                        @error('password') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
                    </div>
                    <div class="pt-2">
                        <button type="submit"
                                class="btn-primary w-full py-3 px-4 text-white font-medium rounded-lg hover:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                            Register
                        </button>
                    </div>
                    <div class="text-center text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-[#b81d8f] font-medium hover:underline">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html> 