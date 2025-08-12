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
                        <div class="space-y-3 max-h-64 overflow-y-auto border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="business_model_review" name="services_provided[]" value="business_model_review" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="business_model_review" class="text-sm text-gray-700 cursor-pointer">1. Business Model Review and Validation</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="financial_forecasting" name="services_provided[]" value="financial_forecasting" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="financial_forecasting" class="text-sm text-gray-700 cursor-pointer">2. Financial Forecasting and Planning</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="valuation_support" name="services_provided[]" value="valuation_support" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="valuation_support" class="text-sm text-gray-700 cursor-pointer">3. Valuation Support and Benchmarking</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="pitch_deck_development" name="services_provided[]" value="pitch_deck_development" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="pitch_deck_development" class="text-sm text-gray-700 cursor-pointer">4. Pitch Deck Development and Review</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="investor_pitch_coaching" name="services_provided[]" value="investor_pitch_coaching" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="investor_pitch_coaching" class="text-sm text-gray-700 cursor-pointer">5. Investor Pitch Coaching and Presentation Skills</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="capital_raising_strategy" name="services_provided[]" value="capital_raising_strategy" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="capital_raising_strategy" class="text-sm text-gray-700 cursor-pointer">6. Capital Raising Strategy (Debt, Equity, Grants)</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="term_sheets" name="services_provided[]" value="term_sheets" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="term_sheets" class="text-sm text-gray-700 cursor-pointer">7. Understanding Term Sheets and Investment Structures</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="due_diligence_preparation" name="services_provided[]" value="due_diligence_preparation" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="due_diligence_preparation" class="text-sm text-gray-700 cursor-pointer">8. Due Diligence Preparation and Data Room Setup</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="legal_regulatory_advice" name="services_provided[]" value="legal_regulatory_advice" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="legal_regulatory_advice" class="text-sm text-gray-700 cursor-pointer">9. Legal and Regulatory Advice for Investment</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="market_sizing" name="services_provided[]" value="market_sizing" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="market_sizing" class="text-sm text-gray-700 cursor-pointer">10. Market Sizing and Competitive Positioning</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="investor_identification" name="services_provided[]" value="investor_identification" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="investor_identification" class="text-sm text-gray-700 cursor-pointer">11. Identifying and Approaching the Right Investors</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="esg_impact_readiness" name="services_provided[]" value="esg_impact_readiness" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="investor_identification" class="text-sm text-gray-700 cursor-pointer">12. ESG and Impact Readiness for Investment</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="governance_board_structuring" name="services_provided[]" value="governance_board_structuring" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="governance_board_structuring" class="text-sm text-gray-700 cursor-pointer">13. Governance and Board Structuring Advice</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="mentoring_experienced_founders" name="services_provided[]" value="mentoring_experienced_founders" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="mentoring_experienced_founders" class="text-sm text-gray-700 cursor-pointer">14. Mentoring by Experienced Founders or Investors</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="investor_networks_demo_days" name="services_provided[]" value="investor_networks_demo_days" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="investor_networks_demo_days" class="text-sm text-gray-700 cursor-pointer">15. Access to Investor Networks and Demo Days</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="exit_strategy_planning" name="services_provided[]" value="exit_strategy_planning" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="exit_strategy_planning" class="text-sm text-gray-700 cursor-pointer">16. Exit Strategy Planning</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="ip_asset_protection" name="services_provided[]" value="ip_asset_protection" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="ip_asset_protection" class="text-sm text-gray-700 cursor-pointer">17. IP and Asset Protection for Investment</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="growth_strategy_post_investment" name="services_provided[]" value="growth_strategy_post_investment" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="growth_strategy_post_investment" class="text-sm text-gray-700 cursor-pointer">18. Growth Strategy Post-Investment</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="storytelling_vision_alignment" name="services_provided[]" value="storytelling_vision_alignment" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="storytelling_vision_alignment" class="text-sm text-gray-700 cursor-pointer">19. Storytelling and Vision Alignment for Investors</label>
                            </div>
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" id="one_on_one_coaching" name="services_provided[]" value="one_on_one_coaching" class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="one_on_one_coaching" class="text-sm text-gray-700 cursor-pointer">20. One-on-One Coaching with Investment Advisors</label>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Select all services you provide by checking the boxes above</p>
                        <div id="selectedServices" class="mt-3 flex flex-wrap gap-2"></div>
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
            const servicesCheckboxes = document.querySelectorAll('input[name="services_provided[]"]');
            const selectedServicesContainer = document.getElementById('selectedServices');

            // Function to update selected services display
            function updateSelectedServicesDisplay() {
                selectedServicesContainer.innerHTML = ''; // Clear previous tags
                
                servicesCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const tag = document.createElement('div');
                        tag.className = 'tag';
                        tag.innerHTML = `
                            ${checkbox.nextElementSibling.textContent}
                            <span class="tag-remove" data-value="${checkbox.value}">×</span>
                        `;
                        selectedServicesContainer.appendChild(tag);
                    }
                });
            }

            // Handle change event on all checkboxes
            servicesCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedServicesDisplay);
            });

            // Remove tag when clicked and uncheck the checkbox
            selectedServicesContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('tag-remove')) {
                    const tagToRemove = e.target.parentElement;
                    const valueToRemove = e.target.getAttribute('data-value');
                    
                    // Uncheck the corresponding checkbox
                    const checkboxToUncheck = document.querySelector(`input[value="${valueToRemove}"]`);
                    if (checkboxToUncheck) {
                        checkboxToUncheck.checked = false;
                    }
                    
                    // Remove the tag
                    tagToRemove.remove();
                }
            });

            // Initialize display
            updateSelectedServicesDisplay();
        });
    </script>
</body>
</html> 