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
                        <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name *</label>
                        <input type="text" id="fullName" name="fullName" required value="{{ old('fullName') }}"
                            class="mt-1 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b81d8f] focus:ring-[#b81d8f] py-2 px-3 border">
                        @error('fullName') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
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
                        <label for="investorType" class="block text-sm font-medium text-gray-700">Type of Investor *</label>
                        <select id="investorType" name="investorType" required
                            class="mt-1 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b81d8f] focus:ring-[#b81d8f] py-2 px-3 border">
                            <option value="" disabled selected>Select investor type</option>
                            <option value="Angel">Angel</option>
                            <option value="VC">VC</option>
                            <option value="Corporate">Corporate</option>
                        </select>
                        @error('investorType') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="interestAreas" class="block text-sm font-medium text-gray-700">Interest Areas</label>
                        <input type="text" id="interestAreas" name="interestAreas" placeholder="Fintech, Healthcare, Edtech" value="{{ old('interestAreas') }}"
                            class="mt-1 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b81d8f] focus:ring-[#b81d8f] py-2 px-3 border">
                    </div>
                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700">Company (optional)</label>
                        <input type="text" id="company" name="company" value="{{ old('company') }}"
                            class="mt-1 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b81d8f] focus:ring-[#b81d8f] py-2 px-3 border">
                    </div>
                    <div>
                        <label for="linkedin" class="block text-sm font-medium text-gray-700">LinkedIn Profile (optional)</label>
                        <input type="url" id="linkedin" name="linkedin" value="{{ old('linkedin') }}"
                            class="mt-1 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b81d8f] focus:ring-[#b81d8f] py-2 px-3 border">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password *</label>
                        <input type="password" id="password" name="password" required minlength="8"
                            class="mt-1 form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b81d8f] focus:ring-[#b81d8f] py-2 px-3 border">
                        <p class="mt-1 text-xs text-gray-500">Password must be at least 8 characters</p>
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
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Get form values
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const passwordError = document.getElementById('passwordError');
            // Validate password match
            if (password !== confirmPassword) {
                passwordError.classList.remove('hidden');
                return;
            } else {
                passwordError.classList.add('hidden');
            }
            // Validate required fields
            const requiredFields = ['fullName', 'email', 'phone', 'investorType', 'password', 'confirmPassword'];
            let isValid = true;
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            if (!isValid) {
                return;
            }
            // If all validations pass, you would typically submit the form here
            alert('Registration successful!');
            // In a real application, you would submit to a server:
            // this.submit();
        });
        // Add real-time password matching validation
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