@php
    $role = auth()->check() ? auth()->user()->role : null;
    $layout = match($role) {
        'mentor' => 'layouts.mentor',
        'entrepreneur' => 'layouts.entrepreneur',
        'mentee' => 'layouts.mentee',
        'investor' => 'layouts.investor',
        'bdsp' => 'layouts.bdsp',
        default => 'layouts.app',
    };
@endphp
@extends($layout)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Profile</h1>
            <a href="{{ route('profile.show') }}" class="text-purple-600 hover:text-purple-800 font-semibold">
                Back to Profile
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Profile Picture Upload -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Profile Picture</label>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        @if($user->profile_picture)
                            <img src="{{ request()->getSchemeAndHttpHost() . '/storage/' . $user->profile_picture }}" 
                                 alt="Current Profile Picture" 
                                 class="w-20 h-20 rounded-full object-cover border-2 border-gray-300">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7C3AED&background=EDE9FE&size=200" 
                                 alt="Default Avatar" 
                                 class="w-20 h-20 rounded-full object-cover border-2 border-gray-300">
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" 
                               name="profile_picture" 
                               accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                        <p class="text-xs text-gray-500 mt-1">Upload a new profile picture (JPEG, PNG, JPG, GIF, max 2MB)</p>
                    </div>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Name *</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500"
                           required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email *</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500"
                           required>
                </div>
            </div>

            <!-- Role-specific fields -->
            @if($user->role === 'entrepreneur')
                <div class="border-t pt-6 mt-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Business Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="business_name" class="block text-sm font-semibold text-gray-700 mb-1">Business Name</label>
                            <input type="text" 
                                   id="business_name" 
                                   name="business_name" 
                                   value="{{ old('business_name', $user->business_name) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label for="sector" class="block text-sm font-semibold text-gray-700 mb-1">Sector</label>
                            <input type="text" 
                                   id="sector" 
                                   name="sector" 
                                   value="{{ old('sector', $user->sector) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label for="entrepreneur_phone" class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                            <input type="text" 
                                   id="entrepreneur_phone" 
                                   name="entrepreneur_phone" 
                                   value="{{ old('entrepreneur_phone', $user->entrepreneur_phone) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label for="website" class="block text-sm font-semibold text-gray-700 mb-1">Website</label>
                            <input type="url" 
                                   id="website" 
                                   name="website" 
                                   value="{{ old('website', $user->website) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>
                </div>
            @endif

            @if($user->role === 'investor')
                <div class="border-t pt-6 mt-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Investor Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="company" class="block text-sm font-semibold text-gray-700 mb-1">Company</label>
                            <input type="text" 
                                   id="company" 
                                   name="company" 
                                   value="{{ old('company', $user->company) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                            <input type="text" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $user->phone) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>
                </div>
            @endif

            @if($user->role === 'bdsp')
                <div class="border-t pt-6 mt-6">
                    <h3 class="font-semibold text-gray-800 mb-4">BDSP Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="organization" class="block text-sm font-semibold text-gray-700 mb-1">Organization</label>
                            <input type="text" 
                                   id="organization" 
                                   name="organization" 
                                   value="{{ old('organization', $user->organization) }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label for="services_provided" class="block text-sm font-semibold text-gray-700 mb-1">Services Provided</label>
                            <div class="space-y-3 max-h-64 overflow-y-auto border border-gray-200 rounded-lg p-4 bg-gray-50">
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="business_model_review" name="services_provided[]" value="business_model_review" {{ in_array('business_model_review', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="business_model_review" class="text-sm text-gray-700 cursor-pointer">1. Business Model Review and Validation</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="financial_forecasting" name="services_provided[]" value="financial_forecasting" {{ in_array('financial_forecasting', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="financial_forecasting" class="text-sm text-gray-700 cursor-pointer">2. Financial Forecasting and Planning</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="valuation_support" name="services_provided[]" value="valuation_support" {{ in_array('valuation_support', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="valuation_support" class="text-sm text-gray-700 cursor-pointer">3. Valuation Support and Benchmarking</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="pitch_deck_development" name="services_provided[]" value="pitch_deck_development" {{ in_array('pitch_deck_development', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="pitch_deck_development" class="text-sm text-gray-700 cursor-pointer">4. Pitch Deck Development and Review</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="investor_pitch_coaching" name="services_provided[]" value="investor_pitch_coaching" {{ in_array('investor_pitch_coaching', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="investor_pitch_coaching" class="text-sm text-gray-700 cursor-pointer">5. Investor Pitch Coaching and Presentation Skills</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="capital_raising_strategy" name="services_provided[]" value="capital_raising_strategy" {{ in_array('capital_raising_strategy', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="capital_raising_strategy" class="text-sm text-gray-700 cursor-pointer">6. Capital Raising Strategy (Debt, Equity, Grants)</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="term_sheets" name="services_provided[]" value="term_sheets" {{ in_array('term_sheets', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="term_sheets" class="text-sm text-gray-700 cursor-pointer">7. Understanding Term Sheets and Investment Structures</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="due_diligence_preparation" name="services_provided[]" value="due_diligence_preparation" {{ in_array('due_diligence_preparation', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="due_diligence_preparation" class="text-sm text-gray-700 cursor-pointer">8. Due Diligence Preparation and Data Room Setup</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="legal_regulatory_advice" name="services_provided[]" value="legal_regulatory_advice" {{ in_array('legal_regulatory_advice', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="legal_regulatory_advice" class="text-sm text-gray-700 cursor-pointer">9. Legal and Regulatory Advice for Investment</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="market_sizing" name="services_provided[]" value="market_sizing" {{ in_array('market_sizing', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="market_sizing" class="text-sm text-gray-700 cursor-pointer">10. Market Sizing and Competitive Positioning</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="investor_identification" name="services_provided[]" value="investor_identification" {{ in_array('investor_identification', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="investor_identification" class="text-sm text-gray-700 cursor-pointer">11. Identifying and Approaching the Right Investors</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="esg_impact_readiness" name="services_provided[]" value="esg_impact_readiness" {{ in_array('esg_impact_readiness', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="esg_impact_readiness" class="text-sm text-gray-700 cursor-pointer">12. ESG and Impact Readiness for Investment</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="governance_board_structuring" name="services_provided[]" value="governance_board_structuring" {{ in_array('governance_board_structuring', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="governance_board_structuring" class="text-sm text-gray-700 cursor-pointer">13. Governance and Board Structuring Advice</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="mentoring_experienced_founders" name="services_provided[]" value="mentoring_experienced_founders" {{ in_array('mentoring_experienced_founders', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="mentoring_experienced_founders" class="text-sm text-gray-700 cursor-pointer">14. Mentoring by Experienced Founders or Investors</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="investor_networks_demo_days" name="services_provided[]" value="investor_networks_demo_days" {{ in_array('investor_networks_demo_days', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="investor_networks_demo_days" class="text-sm text-gray-700 cursor-pointer">15. Access to Investor Networks and Demo Days</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="exit_strategy_planning" name="services_provided[]" value="exit_strategy_planning" {{ in_array('exit_strategy_planning', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="exit_strategy_planning" class="text-sm text-gray-700 cursor-pointer">16. Exit Strategy Planning</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="ip_asset_protection" name="services_provided[]" value="ip_asset_protection" {{ in_array('ip_asset_protection', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="ip_asset_protection" class="text-sm text-gray-700 cursor-pointer">17. IP and Asset Protection for Investment</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="growth_strategy_post_investment" name="services_provided[]" value="growth_strategy_post_investment" {{ in_array('growth_strategy_post_investment', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="growth_strategy_post_investment" class="text-sm text-gray-700 cursor-pointer">18. Growth Strategy Post-Investment</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="storytelling_vision_alignment" name="services_provided[]" value="storytelling_vision_alignment" {{ in_array('storytelling_vision_alignment', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="storytelling_vision_alignment" class="text-sm text-gray-700 cursor-pointer">19. Storytelling and Vision Alignment for Investors</label>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox" id="one_on_one_coaching" name="services_provided[]" value="one_on_one_coaching" {{ in_array('one_on_one_coaching', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="one_on_one_coaching" class="text-sm text-gray-700 cursor-pointer">20. One-on-One Coaching with Investment Advisors</label>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Select all services you provide by checking the boxes above</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('profile.show') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 