<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as a BDSP | AWN Venture Ready Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .input-field { transition: all 0.3s ease; }
        .input-field:focus { box-shadow: 0 0 0 3px rgba(184, 29, 143, 0.2); }
        .tag { display: inline-flex; align-items: center; background-color: #f3e8f3; color: #b81d8f; padding: 0.25rem 0.75rem; border-radius: 9999px; margin-right: 0.5rem; margin-bottom: 0.5rem; font-size: 0.875rem; }
        .tag-remove { margin-left: 0.5rem; cursor: pointer; color: #9f7aea; }
        .tag-remove:hover { color: #b81d8f; }
        .btn-primary { transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .btn-primary:active { transform: translateY(0); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm py-4">
        <div class="container mx-auto px-4 flex justify-center items-center">
            <a href="/" class="flex items-center group">
                <img src="/images/logo.jpg" alt="AWN Logo" class="w-10 h-10 rounded-full shadow-lg mr-3 group-hover:scale-105 transition-transform">
                <h1 class="text-xl font-bold text-gray-800">AWN Venture Ready Portal</h1>
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 md:py-12">
        <div class="max-w-2xl mx-auto">
            <!-- Page Title -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">Register as a BDSP</h2>
                <p class="text-gray-600 text-lg">Join our network of experts supporting venture success.</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-md p-6 md:p-8">
                <form method="POST" action="{{ route('register.bdsp') }}" id="registrationForm" class="space-y-6">
                    @csrf
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}"
                               class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        @error('name') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}"
                               class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        @error('email') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <!-- Services Provided -->
                    <div>
                        <label for="services_provided" class="block text-sm font-medium text-gray-700 mb-1">Services Provided *</label>
                        <div class="relative">
                            <input type="text" id="services_provided" name="services_provided" 
                                   class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                   placeholder="Enter services separated by commas" value="{{ old('services_provided') }}">
                            <div id="tagsContainer" class="mt-2 flex flex-wrap"></div>
                        </div>
                        @error('services_provided') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <!-- Years of Experience -->
                    <div>
                        <label for="years_of_experience" class="block text-sm font-medium text-gray-700 mb-1">Years of Experience *</label>
                        <select id="years_of_experience" name="years_of_experience" required 
                                class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="" disabled selected>Select your experience</option>
                            <option value="1">1-3 years</option>
                            <option value="3">3-5 years</option>
                            <option value="5">5-10 years</option>
                            <option value="10">10+ years</option>
                        </select>
                        @error('years_of_experience') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <!-- Organization -->
                    <div>
                        <label for="organization" class="block text-sm font-medium text-gray-700 mb-1">Organization</label>
                        <input type="text" id="organization" name="organization" value="{{ old('organization') }}"
                               class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        @error('organization') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <!-- Certifications -->
                    <div>
                        <label for="certifications" class="block text-sm font-medium text-gray-700 mb-1">Certifications</label>
                        <input type="text" id="certifications" name="certifications" value="{{ old('certifications') }}"
                               class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        @error('certifications') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <!-- LinkedIn Profile -->
                    <div>
                        <label for="bdsp_linkedin" class="block text-sm font-semibold text-gray-700 mb-2">LinkedIn Profile (Optional)</label>
                        <input type="url" id="bdsp_linkedin" name="bdsp_linkedin" value="{{ old('bdsp_linkedin') }}"
                               class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                               placeholder="https://linkedin.com/in/yourprofile">
                        @error('bdsp_linkedin') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                        <input type="password" id="password" name="password" required minlength="6"
                               class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <p class="mt-1 text-xs text-gray-500">Password must be at least 6 characters</p>
                        @error('password') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" 
                                class="btn-primary w-full py-3 px-4 bg-[#b81d8f] text-white font-medium rounded-lg hover:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                            Register
                        </button>
                    </div>
                    <!-- Login Link -->
                    <div class="text-center text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-[#b81d8f] font-medium hover:underline">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const servicesInput = document.getElementById('services_provided');
            const tagsContainer = document.getElementById('tagsContainer');
            // Handle services input to create tags
            servicesInput.addEventListener('keydown', function(e) {
                if (e.key === ',' || e.key === 'Enter') {
                    e.preventDefault();
                    const value = this.value.trim();
                    if (value) {
                        createTag(value);
                        this.value = '';
                    }
                }
            });
            // Remove tag when clicked
            tagsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('tag-remove')) {
                    e.target.parentElement.remove();
                }
            });
            // Helper function to create a tag
            function createTag(value) {
                const tag = document.createElement('div');
                tag.className = 'tag';
                tag.innerHTML = `
                    ${value}
                    <span class="tag-remove">×</span>
                `;
                tagsContainer.appendChild(tag);
            }
        });
    </script>
</body>
</html> 