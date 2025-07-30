<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investor Registration – AWN Venture Readiness Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; }
        .form-input:focus { border-color: #b81d8f; box-shadow: 0 0 0 1px #b81d8f; }
        .btn-primary { background-color: #b81d8f; transition: all 0.3s ease; }
        .btn-primary:hover { background-color: #9e1877; transform: translateY(-1px); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .btn-primary:active { transform: translateY(0); }
        .link-secondary { color: #b81d8f; transition: all 0.2s ease; }
        .link-secondary:hover { color: #9e1877; text-decoration: underline; }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <header class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex justify-center">
            <a href="/" class="flex items-center space-x-2 group">
                <img src="/images/logo.jpg" alt="AWN Logo" class="w-10 h-10 rounded-full shadow-lg group-hover:scale-105 transition-transform">
                <h1 class="text-xl font-bold text-gray-800">Venture Readiness Portal</h1>
            </a>
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-xl shadow-md p-8 sm:p-10">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Investor Registration</h2>
                    <p class="mt-2 text-gray-600">Join our network of investors</p>
                </div>

                <form method="POST" action="{{ route('register.investor') }}" id="registrationForm" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}"
                            class="mt-1 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b81d8f] focus:ring-[#b81d8f] py-2 px-3 border">
                        @error('name') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}"
                            class="mt-1 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b81d8f] focus:ring-[#b81d8f] py-2 px-3 border">
                        @error('email') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" required value="{{ old('phone') }}"
                            class="mt-1 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b81d8f] focus:ring-[#b81d8f] py-2 px-3 border">
                        @error('phone') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="type_of_investor" class="block text-sm font-medium text-gray-700">Type of Investor *</label>
                        <select id="type_of_investor" name="type_of_investor" required
                            class="mt-1 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b81d8f] focus:ring-[#b81d8f] py-2 px-3 border">
                            <option value="" disabled selected>Select investor type</option>
                            <option value="angel" {{ old('type_of_investor') == 'angel' ? 'selected' : '' }}>Angel</option>
                            <option value="venture_capital" {{ old('type_of_investor') == 'venture_capital' ? 'selected' : '' }}>Venture Capital</option>
                            <option value="private_equity" {{ old('type_of_investor') == 'private_equity' ? 'selected' : '' }}>Private Equity</option>
                            <option value="corporate" {{ old('type_of_investor') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                            <option value="government" {{ old('type_of_investor') == 'government' ? 'selected' : '' }}>Government</option>
                            <option value="other" {{ old('type_of_investor') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('type_of_investor') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="interest_areas" class="block text-sm font-medium text-gray-700">Interest Areas *</label>
                        <input type="text" id="interest_areas" name="interest_areas" required placeholder="Fintech, Healthcare, Edtech" value="{{ old('interest_areas') }}"
                            class="mt-1 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b81d8f] focus:ring-[#b81d8f] py-2 px-3 border">
                        @error('interest_areas') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700">Company (optional)</label>
                        <input type="text" id="company" name="company" value="{{ old('company') }}"
                            class="mt-1 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b81d8f] focus:ring-[#b81d8f] py-2 px-3 border">
                    </div>
                    <div>
                        <label for="investor_linkedin" class="block text-sm font-medium text-gray-700">LinkedIn Profile (optional)</label>
                        <input type="url" id="investor_linkedin" name="investor_linkedin" value="{{ old('investor_linkedin') }}"
                            class="mt-1 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b81d8f] focus:ring-[#b81d8f] py-2 px-3 border">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password *</label>
                        <input type="password" id="password" name="password" required minlength="6"
                            class="mt-1 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b81d8f] focus:ring-[#b81d8f] py-2 px-3 border">
                        <p class="mt-1 text-xs text-gray-500">Password must be at least 6 characters</p>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password *</label>
                        <input type="password" id="confirmPassword" name="password_confirmation" required
                            class="mt-1 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b81d8f] focus:ring-[#b81d8f] py-2 px-3 border">
                        <p id="passwordError" class="mt-1 text-xs text-red-600 hidden">Passwords do not match</p>
                    </div>
                    <div>
                        <button type="submit" class="btn-primary w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#b81d8f]">
                            Register
                        </button>
                    </div>
                    <div class="text-center text-sm">
                        <p class="text-gray-600">Already have an account? 
                            <a href="{{ route('login') }}" class="link-secondary font-medium">Login here</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer class="py-4 px-4 sm:px-6 lg:px-8 bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-xs text-gray-500">© 2025 AWN Venture Readiness Portal. All rights reserved.</p>
        </div>
    </footer>
    <script>
        // Add real-time password matching validation (optional, does not block submission)
        document.getElementById('confirmPassword').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const passwordError = document.getElementById('passwordError');
            if (confirmPassword && password !== confirmPassword) {
                passwordError.classList.remove('hidden');
            } else {
                passwordError.classList.add('hidden');
            }
        });
    </script>
</body>
</html> 