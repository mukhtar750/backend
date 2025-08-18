<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AWN Venture Ready Portal - Entrepreneur Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f9fafb; }
        .form-input { transition: all 0.3s ease; border: 1px solid #e5e7eb; }
        .form-input:focus { border-color: #b81d8f; box-shadow: 0 0 0 3px rgba(184, 29, 143, 0.1); }
        .btn-primary { background-color: #b81d8f; transition: all 0.3s ease; }
        .btn-primary:hover { background-color: #9e1879; transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .logo-container { background: linear-gradient(135deg, #b81d8f 0%, #6b46c1 100%); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .dropdown:hover .dropdown-menu { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="text-center mb-8 animate-fade-in" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-center mb-4">
                <a href="/" class="logo-container text-4xl font-bold mr-2" aria-label="Go to home">
                    <img src="/images/logo.jpg" alt="AWN Logo" class="w-14 h-14 object-contain rounded-full shadow-lg transition-transform group-hover:scale-105">
                </a>
                <h1 class="text-2xl font-bold text-gray-800">AWN Venture Ready Portal</h1>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Register as an Entrepreneur</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Get venture-ready and access resources, mentorship, and funding opportunities.
            </p>
        </header>

        <!-- Registration Form -->
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden animate-fade-in" style="animation-delay: 0.2s;">
            <div class="p-8">
                <form method="POST" action="{{ route('register.entrepreneur') }}" id="registrationForm">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <div class="relative">
                                <input type="text" id="name" name="name" required value="{{ old('name') }}"
                                    class="form-input w-full px-4 py-2 rounded-lg focus:outline-none"
                                    placeholder="Enter your full name">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                            </div>
                            @error('name') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <!-- Email -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <div class="relative">
                                <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                    class="form-input w-full px-4 py-2 rounded-lg focus:outline-none"
                                    placeholder="your@email.com">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                            </div>
                            @error('email') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <!-- Business Name -->
                        <div class="col-span-2">
                            <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">Business Name *</label>
                            <div class="relative">
                                <input type="text" id="business_name" name="business_name" required value="{{ old('business_name') }}"
                                    class="form-input w-full px-4 py-2 rounded-lg focus:outline-none"
                                    placeholder="Your business name">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-building text-gray-400"></i>
                                </div>
                            </div>
                            @error('business_name') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <!-- Sector -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="sector" class="block text-sm font-medium text-gray-700 mb-1">Sector *</label>
                            <div class="relative">
                                <select id="sector" name="sector" required
                                    class="form-input w-full px-4 py-2 rounded-lg focus:outline-none appearance-none">
                                    <option value="" disabled selected>Select your sector</option>
                                    <option value="Technology">Technology</option>
                                    <option value="Healthcare">Healthcare</option>
                                    <option value="Education">Education</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Agriculture">Agriculture</option>
                                    <option value="Manufacturing">Manufacturing</option>
                                    <option value="Retail">Retail</option>
                                    <option value="Other">Other</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-industry text-gray-400"></i>
                                </div>
                            </div>
                            @error('sector') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <!-- CAC Number -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="cac_number" class="block text-sm font-medium text-gray-700 mb-1">CAC Number *</label>
                            <div class="relative">
                                <input type="text" id="cac_number" name="cac_number" required value="{{ old('cac_number') }}"
                                    class="form-input w-full px-4 py-2 rounded-lg focus:outline-none"
                                    placeholder="Your CAC registration number">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-id-card text-gray-400"></i>
                                </div>
                            </div>
                            @error('cac_number') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <!-- Funding Stage -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="funding_stage" class="block text-sm font-medium text-gray-700 mb-1">Funding Stage *</label>
                            <div class="relative">
                                <select id="funding_stage" name="funding_stage" required
                                    class="form-input w-full px-4 py-2 rounded-lg focus:outline-none appearance-none">
                                    <option value="" disabled selected>Select funding stage</option>
                                    <option value="idea" {{ old('funding_stage') == 'idea' ? 'selected' : '' }}>Idea Stage</option>
                                    <option value="startup" {{ old('funding_stage') == 'startup' ? 'selected' : '' }}>Startup</option>
                                    <option value="growth" {{ old('funding_stage') == 'growth' ? 'selected' : '' }}>Growth</option>
                                    <option value="scale" {{ old('funding_stage') == 'scale' ? 'selected' : '' }}>Scale</option>
                                    <option value="mature" {{ old('funding_stage') == 'mature' ? 'selected' : '' }}>Mature</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-chart-line text-gray-400"></i>
                                </div>
                            </div>
                            @error('funding_stage') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <!-- Phone Number -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="entrepreneur_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                            <div class="relative">
                                <input type="tel" id="entrepreneur_phone" name="entrepreneur_phone" required value="{{ old('entrepreneur_phone') }}"
                                    class="form-input w-full px-4 py-2 rounded-lg focus:outline-none"
                                    inputmode="tel" pattern="\+?[0-9]{7,15}" maxlength="16" placeholder="+2348000000000">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                            </div>
                            @error('entrepreneur_phone') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <!-- Business Website -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Business Website</label>
                            <div class="relative">
                                <input type="url" id="website" name="website" value="{{ old('website') }}"
                                    class="form-input w-full px-4 py-2 rounded-lg focus:outline-none"
                                    placeholder="https://yourbusiness.com">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-globe text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <!-- LinkedIn Profile -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="entrepreneur_linkedin" class="block text-sm font-medium text-gray-700 mb-1">LinkedIn Profile</label>
                            <div class="relative">
                                <input type="url" id="entrepreneur_linkedin" name="entrepreneur_linkedin" value="{{ old('entrepreneur_linkedin') }}"
                                    class="form-input w-full px-4 py-2 rounded-lg focus:outline-none"
                                    placeholder="https://linkedin.com/in/yourprofile">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fab fa-linkedin text-gray-400"></i>
                                </div>
                            </div>
                            @error('entrepreneur_linkedin') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <!-- Password -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required minlength="6"
                                    class="form-input w-full px-4 py-2 rounded-lg focus:outline-none"
                                    placeholder="Create a password">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i id="togglePassword" class="fas fa-eye text-gray-400 cursor-pointer"></i>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Password must be at least 6 characters</p>
                        </div>
                        <!-- Confirm Password -->
                        <div class="col-span-2 md:col-span-1">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password *</label>
                            <div class="relative">
                                <input type="password" id="confirmPassword" name="password_confirmation" required
                                    class="form-input w-full px-4 py-2 rounded-lg focus:outline-none"
                                    placeholder="Confirm your password">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i id="toggleConfirmPassword" class="fas fa-eye text-gray-400 cursor-pointer"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Terms and Conditions -->
                    <div class="mt-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required
                                    class="focus:ring-purple-500 h-4 w-4 text-purple-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-700">
                                    I agree to the <a href="#" class="text-purple-600 hover:text-purple-500">Terms of Service</a> and <a href="#" class="text-purple-600 hover:text-purple-500">Privacy Policy</a>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="mt-8">
                        <button type="submit"
                            class="btn-primary w-full px-6 py-3 rounded-lg text-white font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            Register Now
                        </button>
                    </div>
                    <!-- Login Link -->
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="font-medium text-purple-600 hover:text-purple-500">Login</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
        // Toggle confirm password visibility
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const icon = this;
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                confirmPasswordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
        // Phone number input: allow optional leading + and up to 15 digits (no spaces)
        document.getElementById('entrepreneur_phone').addEventListener('input', function(e) {
            let value = e.target.value;
            const hasPlus = value.startsWith('+');
            value = value.replace(/\D/g, '');
            value = (hasPlus ? '+' : '') + value;
            // Limit to + and 15 digits (16 chars total if + present)
            e.target.value = hasPlus ? value.slice(0, 16) : value.slice(0, 15);
        });
    </script>
</body>
</html> 