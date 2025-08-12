@extends('admin.layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-900">Edit User</h2>
    <form method="POST" action="{{ route('admin.updateUser', $user->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input w-full rounded-lg border-gray-300" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input w-full rounded-lg border-gray-300" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone ?? $user->entrepreneur_phone ?? '') }}" class="form-input w-full rounded-lg border-gray-300">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Role</label>
            <select name="role" class="form-select w-full rounded-lg border-gray-300" required>
                @foreach($roles as $role)
                    <option value="{{ $role }}" @if(old('role', $user->role) == $role) selected @endif>@displayRole($role)</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Status</label>
            <select name="is_approved" class="form-select w-full rounded-lg border-gray-300" required>
                <option value="1" @if(old('is_approved', $user->is_approved)) selected @endif>Approved</option>
                <option value="0" @if(!old('is_approved', $user->is_approved)) selected @endif>Pending</option>
            </select>
        </div>
        {{-- Role-specific fields --}}
        @if($user->role === 'entrepreneur')
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Business Name</label>
                <input type="text" name="business_name" value="{{ old('business_name', $user->business_name) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Sector</label>
                <input type="text" name="sector" value="{{ old('sector', $user->sector) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">CAC Number</label>
                <input type="text" name="cac_number" value="{{ old('cac_number', $user->cac_number) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Funding Stage</label>
                <input type="text" name="funding_stage" value="{{ old('funding_stage', $user->funding_stage) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Website</label>
                <input type="text" name="website" value="{{ old('website', $user->website) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">LinkedIn</label>
                <input type="text" name="entrepreneur_linkedin" value="{{ old('entrepreneur_linkedin', $user->entrepreneur_linkedin) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
        @elseif($user->role === 'bdsp')
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Services Provided</label>
                <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-3 bg-gray-50">
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_business_model_review" name="services_provided[]" value="business_model_review" {{ in_array('business_model_review', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_business_model_review" class="text-sm text-gray-700 cursor-pointer">1. Business Model Review and Validation</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_financial_forecasting" name="services_provided[]" value="financial_forecasting" {{ in_array('financial_forecasting', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_financial_forecasting" class="text-sm text-gray-700 cursor-pointer">2. Financial Forecasting and Planning</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_valuation_support" name="services_provided[]" value="valuation_support" {{ in_array('valuation_support', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_valuation_support" class="text-sm text-gray-700 cursor-pointer">3. Valuation Support and Benchmarking</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_pitch_deck_development" name="services_provided[]" value="pitch_deck_development" {{ in_array('pitch_deck_development', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_pitch_deck_development" class="text-sm text-gray-700 cursor-pointer">4. Pitch Deck Development and Review</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_investor_pitch_coaching" name="services_provided[]" value="investor_pitch_coaching" {{ in_array('investor_pitch_coaching', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_investor_pitch_coaching" class="text-sm text-gray-700 cursor-pointer">5. Investor Pitch Coaching and Presentation Skills</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_capital_raising_strategy" name="services_provided[]" value="capital_raising_strategy" {{ in_array('capital_raising_strategy', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_capital_raising_strategy" class="text-sm text-gray-700 cursor-pointer">6. Capital Raising Strategy (Debt, Equity, Grants)</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_term_sheets" name="services_provided[]" value="term_sheets" {{ in_array('term_sheets', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_term_sheets" class="text-sm text-gray-700 cursor-pointer">7. Understanding Term Sheets and Investment Structures</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_due_diligence_preparation" name="services_provided[]" value="due_diligence_preparation" {{ in_array('due_diligence_preparation', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_due_diligence_preparation" class="text-sm text-gray-700 cursor-pointer">8. Due Diligence Preparation and Data Room Setup</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_legal_regulatory_advice" name="services_provided[]" value="legal_regulatory_advice" {{ in_array('legal_regulatory_advice', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_legal_regulatory_advice" class="text-sm text-gray-700 cursor-pointer">9. Legal and Regulatory Advice for Investment</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_market_sizing" name="services_provided[]" value="market_sizing" {{ in_array('market_sizing', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_market_sizing" class="text-sm text-gray-700 cursor-pointer">10. Market Sizing and Competitive Positioning</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_investor_identification" name="services_provided[]" value="investor_identification" {{ in_array('investor_identification', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_investor_identification" class="text-sm text-gray-700 cursor-pointer">11. Identifying and Approaching the Right Investors</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_esg_impact_readiness" name="services_provided[]" value="esg_impact_readiness" {{ in_array('esg_impact_readiness', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_esg_impact_readiness" class="text-sm text-gray-700 cursor-pointer">12. ESG and Impact Readiness for Investment</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_governance_board_structuring" name="services_provided[]" value="governance_board_structuring" {{ in_array('governance_board_structuring', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_governance_board_structuring" class="text-sm text-gray-700 cursor-pointer">13. Governance and Board Structuring Advice</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_mentoring_experienced_founders" name="services_provided[]" value="mentoring_experienced_founders" {{ in_array('mentoring_experienced_founders', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_mentoring_experienced_founders" class="text-sm text-gray-700 cursor-pointer">14. Mentoring by Experienced Founders or Investors</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_investor_networks_demo_days" name="services_provided[]" value="investor_networks_demo_days" {{ in_array('investor_networks_demo_days', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_investor_networks_demo_days" class="text-sm text-gray-700 cursor-pointer">15. Access to Investor Networks and Demo Days</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_exit_strategy_planning" name="services_provided[]" value="exit_strategy_planning" {{ in_array('exit_strategy_planning', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_exit_strategy_planning" class="text-sm text-gray-700 cursor-pointer">16. Exit Strategy Planning</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_ip_asset_protection" name="services_provided[]" value="ip_asset_protection" {{ in_array('ip_asset_protection', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_ip_asset_protection" class="text-sm text-gray-700 cursor-pointer">17. IP and Asset Protection for Investment</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_growth_strategy_post_investment" name="services_provided[]" value="growth_strategy_post_investment" {{ in_array('growth_strategy_post_investment', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_growth_strategy_post_investment" class="text-sm text-gray-700 cursor-pointer">18. Growth Strategy Post-Investment</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_storytelling_vision_alignment" name="services_provided[]" value="storytelling_vision_alignment" {{ in_array('storytelling_vision_alignment', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_storytelling_vision_alignment" class="text-sm text-gray-700 cursor-pointer">19. Storytelling and Vision Alignment for Investors</label>
                    </div>
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="admin_one_on_one_coaching" name="services_provided[]" value="one_on_one_coaching" {{ in_array('one_on_one_coaching', old('services_provided', $user->services_provided ?? [])) ? 'checked' : '' }} class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="admin_one_on_one_coaching" class="text-sm text-gray-700 cursor-pointer">20. One-on-One Coaching with Investment Advisors</label>
                    </div>
                </div>
                <p class="mt-1 text-xs text-gray-500">Select all services this BDSP provides</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Years of Experience</label>
                <input type="text" name="years_of_experience" value="{{ old('years_of_experience', $user->years_of_experience) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Organization</label>
                <input type="text" name="organization" value="{{ old('organization', $user->organization) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Certifications</label>
                <input type="text" name="certifications" value="{{ old('certifications', $user->certifications) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">LinkedIn</label>
                <input type="text" name="bdsp_linkedin" value="{{ old('bdsp_linkedin', $user->bdsp_linkedin) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
        @elseif($user->role === 'investor')
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Company</label>
                <input type="text" name="company" value="{{ old('company', $user->company) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Type of Investor</label>
                <input type="text" name="type_of_investor" value="{{ old('type_of_investor', $user->type_of_investor) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Interest Areas</label>
                <input type="text" name="interest_areas" value="{{ old('interest_areas', $user->interest_areas) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">LinkedIn</label>
                <input type="text" name="investor_linkedin" value="{{ old('investor_linkedin', $user->investor_linkedin) }}" class="form-input w-full rounded-lg border-gray-300">
            </div>
        @endif
        <div class="flex justify-end gap-4 mt-8">
            <a href="{{ route('admin.user-management') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-300 transition">Cancel</a>
            <button type="submit" class="bg-[#b81d8f] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#a01a7d] transition">Save Changes</button>
        </div>
    </form>
</div>
@endsection 