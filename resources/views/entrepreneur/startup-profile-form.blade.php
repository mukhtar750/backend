@extends('layouts.entrepreneur')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ isset($startup) ? 'Edit' : 'Create' }} Startup Profile</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
                <p>{{ session('info') }}</p>
            </div>
        @endif
        
        <form action="{{ isset($startup) ? route('entrepreneur.startup-profile.update', $startup->id) : route('entrepreneur.startup-profile.store') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="space-y-6">
            @csrf
            @if(isset($startup))
                @method('PUT')
            @endif

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">✅ Basic Information</h2>
                <div class="border-b border-gray-200 mb-4"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Startup Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Startup Name *</label>
                        <input type="text" name="name" id="name" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('name', $startup->name ?? '') }}" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tagline -->
                    <div>
                        <label for="tagline" class="block text-sm font-medium text-gray-700 mb-1">One-liner / Tagline</label>
                        <input type="text" name="tagline" id="tagline" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('tagline', $startup->tagline ?? '') }}" placeholder="A short catchy description">
                        @error('tagline')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Logo Upload -->
                    <div>
                        <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                        <div class="flex items-center space-x-4">
                            @if(isset($startup) && $startup->logo)
                                <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-100">
                                    <img src="{{ asset($startup->logo) }}" alt="{{ $startup->name }} logo" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <input type="file" name="logo" id="logo" 
                                   class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                   accept="image/*">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Upload a square image (JPG, PNG, GIF). Max 2MB.</p>
                        @error('logo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
                        <input type="url" name="website" id="website" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('website', $startup->website ?? '') }}" placeholder="https://example.com">
                        @error('website')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Year Founded -->
                    <div>
                        <label for="year_founded" class="block text-sm font-medium text-gray-700 mb-1">Date Founded</label>
                        <input type="number" name="year_founded" id="year_founded" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('year_founded', $startup->year_founded ?? '') }}" min="1900" max="{{ date('Y') }}">
                        @error('year_founded')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Funding Stage -->
                    <div>
                        <label for="funding_stage" class="block text-sm font-medium text-gray-700 mb-1">Startup Stage *</label>
                        <select name="funding_stage" id="funding_stage" 
                                class="form-select w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                required>
                            <option value="" disabled {{ old('funding_stage', $startup->funding_stage ?? '') ? '' : 'selected' }}>Select startup stage</option>
                            <option value="Idea" {{ old('funding_stage', $startup->funding_stage ?? '') == 'Idea' ? 'selected' : '' }}>Idea</option>
                            <option value="MVP" {{ old('funding_stage', $startup->funding_stage ?? '') == 'MVP' ? 'selected' : '' }}>MVP (Minimum Viable Product)</option>
                            <option value="Early Traction" {{ old('funding_stage', $startup->funding_stage ?? '') == 'Early Traction' ? 'selected' : '' }}>Early Traction</option>
                            <option value="Growth" {{ old('funding_stage', $startup->funding_stage ?? '') == 'Growth' ? 'selected' : '' }}>Growth</option>
                            <option value="Scaling" {{ old('funding_stage', $startup->funding_stage ?? '') == 'Scaling' ? 'selected' : '' }}>Scaling</option>
                            <option value="Pre-seed" {{ old('funding_stage', $startup->funding_stage ?? '') == 'Pre-seed' ? 'selected' : '' }}>Pre-seed</option>
                            <option value="Seed" {{ old('funding_stage', $startup->funding_stage ?? '') == 'Seed' ? 'selected' : '' }}>Seed</option>
                            <option value="Series A" {{ old('funding_stage', $startup->funding_stage ?? '') == 'Series A' ? 'selected' : '' }}>Series A</option>
                            <option value="Series B" {{ old('funding_stage', $startup->funding_stage ?? '') == 'Series B' ? 'selected' : '' }}>Series B</option>
                            <option value="Series C+" {{ old('funding_stage', $startup->funding_stage ?? '') == 'Series C+' ? 'selected' : '' }}>Series C+</option>
                            <option value="Bootstrapped" {{ old('funding_stage', $startup->funding_stage ?? '') == 'Bootstrapped' ? 'selected' : '' }}>Bootstrapped</option>
                        </select>
                        @error('funding_stage')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sector -->
                    <div>
                        <label for="sector" class="block text-sm font-medium text-gray-700 mb-1">Sector *</label>
                        <select name="sector" id="sector"
                                class="form-select w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                            <option value="" disabled {{ old('sector', $startup->sector ?? '') ? '' : 'selected' }}>Select sector</option>
                            <option value="Technology" {{ old('sector', $startup->sector ?? '') == 'Technology' ? 'selected' : '' }}>Technology</option>
                            <option value="Healthcare" {{ old('sector', $startup->sector ?? '') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                            <option value="Finance" {{ old('sector', $startup->sector ?? '') == 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Education" {{ old('sector', $startup->sector ?? '') == 'Education' ? 'selected' : '' }}>Education</option>
                            <option value="Retail" {{ old('sector', $startup->sector ?? '') == 'Retail' ? 'selected' : '' }}>Retail</option>
                            <option value="Food & Beverage" {{ old('sector', $startup->sector ?? '') == 'Food & Beverage' ? 'selected' : '' }}>Food & Beverage</option>
                            <option value="Manufacturing" {{ old('sector', $startup->sector ?? '') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                            <option value="Energy" {{ old('sector', $startup->sector ?? '') == 'Energy' ? 'selected' : '' }}>Energy</option>
                            <option value="Real Estate" {{ old('sector', $startup->sector ?? '') == 'Real Estate' ? 'selected' : '' }}>Real Estate</option>
                            <option value="Transportation" {{ old('sector', $startup->sector ?? '') == 'Transportation' ? 'selected' : '' }}>Transportation</option>
                            <option value="Media & Entertainment" {{ old('sector', $startup->sector ?? '') == 'Media & Entertainment' ? 'selected' : '' }}>Media & Entertainment</option>
                            <option value="Agriculture" {{ old('sector', $startup->sector ?? '') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                            <option value="Other" {{ old('sector', $startup->sector ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('sector')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">✅ Location</h2>
                <div class="border-b border-gray-200 mb-4"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Headquarters Location -->
                    <div>
                        <label for="headquarters_location" class="block text-sm font-medium text-gray-700 mb-1">Headquarters Location</label>
                        <input type="text" name="headquarters_location" id="headquarters_location" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('headquarters_location', $startup->headquarters_location ?? '') }}" placeholder="City, State, Country">
                        @error('headquarters_location')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Operating Regions -->
                    <div>
                        <label for="operating_regions" class="block text-sm font-medium text-gray-700 mb-1">Operating Regions</label>
                        <input type="text" name="operating_regions" id="operating_regions" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('operating_regions', $startup->operating_regions ?? '') }}" placeholder="e.g. East Africa, North America, Global">
                        @error('operating_regions')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">✅ Team Information</h2>
                <div class="border-b border-gray-200 mb-4"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Team Size -->
                    <div>
                        <label for="team_size" class="block text-sm font-medium text-gray-700 mb-1">Team Size</label>
                        <input type="number" name="team_size" id="team_size" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('team_size', $startup->team_size ?? '') }}" min="1">
                        @error('team_size')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- LinkedIn URL -->
                    <div>
                        <label for="linkedin_url" class="block text-sm font-medium text-gray-700 mb-1">LinkedIn URL</label>
                        <input type="url" name="linkedin_url" id="linkedin_url" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('linkedin_url', $startup->linkedin_url ?? '') }}" placeholder="https://linkedin.com/in/yourprofile">
                        @error('linkedin_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">✅ Problem & Solution</h2>
                <div class="border-b border-gray-200 mb-4"></div>
                <div class="space-y-6">
                    <!-- Problem Statement -->
                    <div>
                        <label for="problem_statement" class="block text-sm font-medium text-gray-700 mb-1">What problem are you solving?</label>
                        <textarea name="problem_statement" id="problem_statement" rows="3" 
                                  class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                  placeholder="Describe the problem your startup is addressing...">{{ old('problem_statement', $startup->problem_statement ?? '') }}</textarea>
                        @error('problem_statement')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Solution -->
                    <div>
                        <label for="solution" class="block text-sm font-medium text-gray-700 mb-1">What's your solution?</label>
                        <textarea name="solution" id="solution" rows="3" 
                                  class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                  placeholder="Describe your solution to the problem...">{{ old('solution', $startup->solution ?? '') }}</textarea>
                        @error('solution')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Innovation Differentiator -->
                    <div>
                        <label for="innovation_differentiator" class="block text-sm font-medium text-gray-700 mb-1">What makes it innovative or different?</label>
                        <textarea name="innovation_differentiator" id="innovation_differentiator" rows="3" 
                                  class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                  placeholder="Describe what makes your solution unique...">{{ old('innovation_differentiator', $startup->innovation_differentiator ?? '') }}</textarea>
                        @error('innovation_differentiator')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">✅ Market & Traction</h2>
                <div class="border-b border-gray-200 mb-4"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Target Market Size -->
                    <div>
                        <label for="target_market_size" class="block text-sm font-medium text-gray-700 mb-1">Target Market Size</label>
                        <input type="text" name="target_market_size" id="target_market_size" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('target_market_size', $startup->target_market_size ?? '') }}" placeholder="e.g. $10M, 500,000 users">
                        @error('target_market_size')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Customers -->
                    <div>
                        <label for="current_customers" class="block text-sm font-medium text-gray-700 mb-1">Current Users or Customers</label>
                        <input type="text" name="current_customers" id="current_customers" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('current_customers', $startup->current_customers ?? '') }}" placeholder="e.g. 100 paying customers, 5,000 users">
                        @error('current_customers')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Monthly Revenue -->
                    <div>
                        <label for="monthly_revenue" class="block text-sm font-medium text-gray-700 mb-1">Monthly Revenue (optional)</label>
                        <input type="text" name="monthly_revenue" id="monthly_revenue" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('monthly_revenue', $startup->monthly_revenue ?? '') }}" placeholder="e.g. $5,000">
                        @error('monthly_revenue')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Key Metrics -->
                    <div>
                        <label for="key_metrics" class="block text-sm font-medium text-gray-700 mb-1">Key Metrics</label>
                        <input type="text" name="key_metrics" id="key_metrics" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('key_metrics', $startup->key_metrics ?? '') }}" placeholder="e.g. downloads, active users, etc.">
                        @error('key_metrics')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Partnerships -->
                    <div>
                        <label for="partnerships" class="block text-sm font-medium text-gray-700 mb-1">Partnerships or Collaborations</label>
                        <input type="text" name="partnerships" id="partnerships" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('partnerships', $startup->partnerships ?? '') }}" placeholder="e.g. Microsoft, Local University">
                        @error('partnerships')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Achievements -->
                    <div>
                        <label for="achievements" class="block text-sm font-medium text-gray-700 mb-1">Achievements / Awards</label>
                        <input type="text" name="achievements" id="achievements" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('achievements', $startup->achievements ?? '') }}" placeholder="e.g. Winner of Startup Competition 2023">
                        @error('achievements')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">✅ Technology & Operations</h2>
                <div class="border-b border-gray-200 mb-4"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Technology Stack -->
                    <div>
                        <label for="technology_stack" class="block text-sm font-medium text-gray-700 mb-1">Technology Stack Used</label>
                        <input type="text" name="technology_stack" id="technology_stack" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('technology_stack', $startup->technology_stack ?? '') }}" placeholder="e.g. React, Node.js, AWS">
                        @error('technology_stack')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Operational Model -->
                    <div>
                        <label for="operational_model" class="block text-sm font-medium text-gray-700 mb-1">Operational Model / Workflow</label>
                        <input type="text" name="operational_model" id="operational_model" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('operational_model', $startup->operational_model ?? '') }}" placeholder="e.g. Direct-to-consumer, SaaS">
                        @error('operational_model')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- IP / Patents -->
                    <div>
                        <label for="ip_patents" class="block text-sm font-medium text-gray-700 mb-1">IP / Patents (if any)</label>
                        <input type="text" name="ip_patents" id="ip_patents" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('ip_patents', $startup->ip_patents ?? '') }}" placeholder="e.g. 2 patents pending, proprietary algorithm">
                        @error('ip_patents')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">✅ Funding & Financials</h2>
                <div class="border-b border-gray-200 mb-4"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Have you raised any funds? -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Have you raised any funds?</label>
                        <div class="flex items-center space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="has_raised_funds" value="1" class="form-radio" 
                                       {{ old('has_raised_funds', $startup->has_raised_funds ?? '') == '1' ? 'checked' : '' }}>
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="has_raised_funds" value="0" class="form-radio" 
                                       {{ old('has_raised_funds', $startup->has_raised_funds ?? '') == '0' ? 'checked' : '' }}>
                                <span class="ml-2">No</span>
                            </label>
                        </div>
                        @error('has_raised_funds')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount Raised -->
                    <div>
                        <label for="amount_raised" class="block text-sm font-medium text-gray-700 mb-1">Amount Raised (if any)</label>
                        <input type="text" name="amount_raised" id="amount_raised" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('amount_raised', $startup->amount_raised ?? '') }}" placeholder="e.g. $50,000">
                        @error('amount_raised')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Monthly Burn Rate -->
                    <div>
                        <label for="monthly_burn_rate" class="block text-sm font-medium text-gray-700 mb-1">Current Monthly Burn Rate</label>
                        <input type="text" name="monthly_burn_rate" id="monthly_burn_rate" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('monthly_burn_rate', $startup->monthly_burn_rate ?? '') }}" placeholder="e.g. $10,000">
                        @error('monthly_burn_rate')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Funding Needed -->
                    <div>
                        <label for="funding_needed" class="block text-sm font-medium text-gray-700 mb-1">Funding Needed (if seeking)</label>
                        <input type="text" name="funding_needed" id="funding_needed" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('funding_needed', $startup->funding_needed ?? '') }}" placeholder="e.g. $100,000">
                        @error('funding_needed')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Funding Use -->
                <div class="mt-6">
                    <label for="funding_use" class="block text-sm font-medium text-gray-700 mb-1">What will the funding be used for?</label>
                    <textarea name="funding_use" id="funding_use" rows="3" 
                              class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                              placeholder="Describe how you plan to use the funding...">{{ old('funding_use', $startup->funding_use ?? '') }}</textarea>
                    @error('funding_use')


            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">✅ Documents & Media</h2>
                <div class="border-b border-gray-200 mb-4"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Pitch Deck -->
                    <div>
                        <label for="pitch_deck" class="block text-sm font-medium text-gray-700 mb-1">Upload Pitch Deck (PDF)</label>
                        <input type="file" name="pitch_deck" id="pitch_deck" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               accept=".pdf">
                        @if(isset($startup) && $startup->pitch_deck)
                            <p class="text-sm text-gray-600 mt-1">Current file: <a href="{{ asset($startup->pitch_deck) }}" target="_blank" class="text-blue-500 hover:underline">View Pitch Deck</a></p>
                        @endif
                        <p class="text-xs text-gray-500 mt-1">Upload a PDF file. Max 10MB.</p>
                        @error('pitch_deck')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Demo Video -->
                    <div>
                        <label for="demo_video" class="block text-sm font-medium text-gray-700 mb-1">Product Demo Video / Link</label>
                        <input type="text" name="demo_video" id="demo_video" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ old('demo_video', $startup->demo_video ?? '') }}" placeholder="e.g. https://youtube.com/watch?v=...">
                        @error('demo_video')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company Registration -->
                    <div>
                        <label for="company_registration" class="block text-sm font-medium text-gray-700 mb-1">Company Registration Certificate (if available)</label>
                        <input type="file" name="company_registration" id="company_registration" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               accept=".pdf,.jpg,.jpeg,.png">
                        @if(isset($startup) && $startup->company_registration)
                            <p class="text-sm text-gray-600 mt-1">Current file: <a href="{{ asset($startup->company_registration) }}" target="_blank" class="text-blue-500 hover:underline">View Certificate</a></p>
                        @endif
                        <p class="text-xs text-gray-500 mt-1">Upload a PDF or image file. Max 5MB.</p>
                        @error('company_registration')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">✅ Goals & Needs</h2>
                <div class="border-b border-gray-200 mb-4"></div>
                <div class="space-y-6">
                    <!-- Current Challenges -->
                    <div>
                        <label for="current_challenges" class="block text-sm font-medium text-gray-700 mb-1">Current Challenges</label>
                        <textarea name="current_challenges" id="current_challenges" rows="3" 
                                  class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                  placeholder="Describe the challenges your startup is currently facing...">{{ old('current_challenges', $startup->current_challenges ?? '') }}</textarea>
                        @error('current_challenges')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Support Needed -->
                    <div>
                        <label for="support_needed" class="block text-sm font-medium text-gray-700 mb-1">What support are you looking for?</label>
                        <textarea name="support_needed" id="support_needed" rows="3" 
                                  class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                  placeholder="e.g. Mentorship, Technical support, Funding, Partnerships, Talent/Recruitment">{{ old('support_needed', $startup->support_needed ?? '') }}</textarea>
                        @error('support_needed')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Future Vision -->
                    <div>
                        <label for="future_vision" class="block text-sm font-medium text-gray-700 mb-1">Future Vision (2–5 years)</label>
                        <textarea name="future_vision" id="future_vision" rows="3" 
                                  class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                  placeholder="Describe your vision for the startup in the next 2-5 years...">{{ old('future_vision', $startup->future_vision ?? '') }}</textarea>
                        @error('future_vision')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">✅ Industry & Category</h2>
                <div class="border-b border-gray-200 mb-4"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Sector -->
                    <div>
                        <label for="sector" class="block text-sm font-medium text-gray-700 mb-1">Industry Sector *</label>
                        <select name="sector" id="sector" 
                                class="form-select w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                required>
                            <option value="" disabled {{ old('sector', $startup->sector ?? '') ? '' : 'selected' }}>Select a sector</option>
                            <option value="Fintech" {{ old('sector', $startup->sector ?? '') == 'Fintech' ? 'selected' : '' }}>Fintech</option>
                            <option value="HealthTech" {{ old('sector', $startup->sector ?? '') == 'HealthTech' ? 'selected' : '' }}>HealthTech</option>
                            <option value="EdTech" {{ old('sector', $startup->sector ?? '') == 'EdTech' ? 'selected' : '' }}>EdTech</option>
                            <option value="AgriTech" {{ old('sector', $startup->sector ?? '') == 'AgriTech' ? 'selected' : '' }}>AgriTech</option>
                            <option value="Technology" {{ old('sector', $startup->sector ?? '') == 'Technology' ? 'selected' : '' }}>Technology</option>
                            <option value="Agriculture" {{ old('sector', $startup->sector ?? '') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                            <option value="Healthcare" {{ old('sector', $startup->sector ?? '') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                            <option value="Education" {{ old('sector', $startup->sector ?? '') == 'Education' ? 'selected' : '' }}>Education</option>
                            <option value="Finance" {{ old('sector', $startup->sector ?? '') == 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Retail" {{ old('sector', $startup->sector ?? '') == 'Retail' ? 'selected' : '' }}>Retail</option>
                            <option value="Manufacturing" {{ old('sector', $startup->sector ?? '') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                            <option value="Energy" {{ old('sector', $startup->sector ?? '') == 'Energy' ? 'selected' : '' }}>Energy</option>
                            <option value="Transportation" {{ old('sector', $startup->sector ?? '') == 'Transportation' ? 'selected' : '' }}>Transportation</option>
                            <option value="Other" {{ old('sector', $startup->sector ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('sector')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Business Model -->
                    <div>
                        <label for="business_model" class="block text-sm font-medium text-gray-700 mb-1">Business Model</label>
                        <select name="business_model" id="business_model" 
                                class="form-select w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="" disabled {{ old('business_model', $startup->business_model ?? '') ? '' : 'selected' }}>Select business model</option>
                            <option value="B2B" {{ old('business_model', $startup->business_model ?? '') == 'B2B' ? 'selected' : '' }}>B2B (Business to Business)</option>
                            <option value="B2C" {{ old('business_model', $startup->business_model ?? '') == 'B2C' ? 'selected' : '' }}>B2C (Business to Consumer)</option>
                            <option value="B2G" {{ old('business_model', $startup->business_model ?? '') == 'B2G' ? 'selected' : '' }}>B2G (Business to Government)</option>
                            <option value="C2C" {{ old('business_model', $startup->business_model ?? '') == 'C2C' ? 'selected' : '' }}>C2C (Consumer to Consumer)</option>
                            <option value="B2B2C" {{ old('business_model', $startup->business_model ?? '') == 'B2B2C' ? 'selected' : '' }}>B2B2C (Business to Business to Consumer)</option>
                            <option value="Other" {{ old('business_model', $startup->business_model ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('business_model')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
             
             <!-- Form Submission Buttons -->
             <div class="flex justify-end space-x-3 pt-4">
                 <a href="{{ route('entrepreneur.startup-profile') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                     Cancel
                 </a>
                 <button type="submit" class="px-4 py-2 bg-[#b81d8f] text-white rounded-md hover:bg-[#a01a7d] transition">
                      {{ isset($startup) ? 'Update Profile' : 'Create Profile' }}
                  </button>
              </div>
         </form>
     </div>
</div>
 @endsection