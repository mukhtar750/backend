<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StartupController extends Controller
{
    /**
     * Display the entrepreneur's startup profile
     */
    public function index()
    {
        $user = Auth::user();
        $startup = Startup::where('founder_id', $user->id)->first();
        
        return view('entrepreneur.startup-profile', compact('startup'));
    }
    
    /**
     * Show the form for creating a new startup profile
     */
    public function create()
    {
        // Check if user already has a startup profile
        $user = Auth::user();
        $existingStartup = Startup::where('founder_id', $user->id)->first();
        
        if ($existingStartup) {
            return redirect()->route('entrepreneur.startup-profile.edit', $existingStartup->id)
                ->with('info', 'You already have a startup profile. You can edit it here.');
        }
        
        return view('entrepreneur.startup-profile-form');
    }
    
    /**
     * Show the form for editing the startup profile
     */
    public function edit(Startup $startup)
    {
        // Check if the authenticated user is the founder of this startup
        if (Auth::id() !== $startup->founder_id) {
            return redirect()->back()->with('error', 'You are not authorized to edit this startup profile.');
        }
        
        return view('entrepreneur.startup-profile-form', compact('startup'));
    }
    
    /**
     * Store a new startup profile
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'sector' => 'required|string|max:100',
                'funding_stage' => 'required|string|max:50',
                'website' => 'nullable|url|max:255',
                'year_founded' => 'nullable|integer|min:1900|max:' . date('Y'),
                'team_size' => 'nullable|integer|min:1',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'tagline' => 'nullable|string|max:255',
                'business_model' => 'nullable|string|max:100',
                'headquarters_location' => 'nullable|string|max:255',
                'operating_regions' => 'nullable|string|max:255',
                'linkedin_url' => 'nullable|url|max:255',
                'problem_statement' => 'nullable|string',
                'solution' => 'nullable|string',
                'innovation_differentiator' => 'nullable|string',
                'target_market_size' => 'nullable|string|max:255',
                'current_customers' => 'nullable|string|max:255',
                'monthly_revenue' => 'nullable|string|max:255',
                'key_metrics' => 'nullable|string',
                'partnerships' => 'nullable|string',
                'achievements' => 'nullable|string',
                'technology_stack' => 'nullable|string',
                'operational_model' => 'nullable|string',
                'ip_patents' => 'nullable|string',
                'has_raised_funds' => 'nullable|boolean',
                'amount_raised' => 'nullable|string|max:255',
                'monthly_burn_rate' => 'nullable|string|max:255',
                'funding_needed' => 'nullable|string|max:255',
                'funding_use' => 'nullable|string',
                'pitch_deck' => 'nullable|file|mimes:pdf|max:10240',
                'demo_video' => 'nullable|string|max:255',
                'company_registration' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                'current_challenges' => 'nullable|string',
                'support_needed' => 'nullable|string',
                'future_vision' => 'nullable|string',
            ]);

            $startup = new Startup();
            $startup->name = $validatedData['name'];
            $startup->description = $validatedData['description'] ?? null;
            $startup->sector = $validatedData['sector'];
            $startup->funding_stage = $validatedData['funding_stage'];
            $startup->website = $validatedData['website'] ?? null;
            $startup->year_founded = $validatedData['year_founded'] ?? null;
            $startup->team_size = $validatedData['team_size'] ?? null;
            $startup->founder_id = Auth::id();
            $startup->status = 'pending';
            $startup->tagline = $validatedData['tagline'] ?? null;
            $startup->business_model = $validatedData['business_model'] ?? null;
            $startup->headquarters_location = $validatedData['headquarters_location'] ?? null;
            $startup->operating_regions = $validatedData['operating_regions'] ?? null;
            $startup->linkedin_url = $validatedData['linkedin_url'] ?? null;
            $startup->problem_statement = $validatedData['problem_statement'] ?? null;
            $startup->solution = $validatedData['solution'] ?? null;
            $startup->innovation_differentiator = $validatedData['innovation_differentiator'] ?? null;
            $startup->target_market_size = $validatedData['target_market_size'] ?? null;
            $startup->current_customers = $validatedData['current_customers'] ?? null;
            $startup->monthly_revenue = $validatedData['monthly_revenue'] ?? null;
            $startup->key_metrics = $validatedData['key_metrics'] ?? null;
            $startup->partnerships = $validatedData['partnerships'] ?? null;
            $startup->achievements = $validatedData['achievements'] ?? null;
            $startup->technology_stack = $validatedData['technology_stack'] ?? null;
            $startup->operational_model = $validatedData['operational_model'] ?? null;
            $startup->ip_patents = $validatedData['ip_patents'] ?? null;
            $startup->has_raised_funds = $validatedData['has_raised_funds'] ?? null;
            $startup->amount_raised = $validatedData['amount_raised'] ?? null;
            $startup->monthly_burn_rate = $validatedData['monthly_burn_rate'] ?? null;
            $startup->funding_needed = $validatedData['funding_needed'] ?? null;
            $startup->funding_use = $validatedData['funding_use'] ?? null;
            $startup->demo_video = $validatedData['demo_video'] ?? null;
            $startup->current_challenges = $validatedData['current_challenges'] ?? null;
            $startup->support_needed = $validatedData['support_needed'] ?? null;
            $startup->future_vision = $validatedData['future_vision'] ?? null;

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('startup_logos', 'public');
                $startup->logo = $path;
            }
            if ($request->hasFile('pitch_deck')) {
                $path = $request->file('pitch_deck')->store('pitch_decks', 'public');
                $startup->pitch_deck = $path;
            }
            if ($request->hasFile('company_registration')) {
                $path = $request->file('company_registration')->store('company_registrations', 'public');
                $startup->company_registration = $path;
            }

            if ($startup->save()) {
                // TODO: Notify admin for approval
                // TODO: Create teaser for investors
                return redirect()->route('entrepreneur.startup-profile')->with('success', 'Startup profile created successfully!');
            } else {
                \Log::error('Failed to save startup.');
                return redirect()->back()->withInput()->withErrors(['error' => 'Failed to save startup.']);
            }
        } catch (\Exception $e) {
            \Log::error('An unexpected error occurred:', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->withErrors(['error' => 'An unexpected error occurred.']);
        }
    }
    
    /**
     * Update the startup profile
     */
    public function update(Request $request, Startup $startup)
    {
        // Check if the authenticated user is the founder of this startup
        if (Auth::id() !== $startup->founder_id) {
            return redirect()->back()->with('error', 'You are not authorized to update this startup profile.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sector' => 'required|string|max:100',
            'funding_stage' => 'required|string|max:50',
            'website' => 'nullable|url|max:255',
            'year_founded' => 'nullable|integer|min:1900|max:' . date('Y'),
            'team_size' => 'nullable|integer|min:1',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tagline' => 'nullable|string|max:255',
            'business_model' => 'nullable|string|max:100',
            'headquarters_location' => 'nullable|string|max:255',
            'operating_regions' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'problem_statement' => 'nullable|string',
            'solution' => 'nullable|string',
            'innovation_differentiator' => 'nullable|string',
            'target_market_size' => 'nullable|string|max:255',
            'current_customers' => 'nullable|string|max:255',
            'monthly_revenue' => 'nullable|string|max:255',
            'key_metrics' => 'nullable|string',
            'partnerships' => 'nullable|string',
            'achievements' => 'nullable|string',
            'technology_stack' => 'nullable|string',
            'operational_model' => 'nullable|string',
            'ip_patents' => 'nullable|string',
            'has_raised_funds' => 'nullable|boolean',
            'amount_raised' => 'nullable|string|max:255',
            'monthly_burn_rate' => 'nullable|string|max:255',
            'funding_needed' => 'nullable|string|max:255',
            'funding_use' => 'nullable|string',
            'pitch_deck' => 'nullable|file|mimes:pdf|max:10240',
            'demo_video' => 'nullable|string|max:255',
            'company_registration' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'current_challenges' => 'nullable|string',
            'support_needed' => 'nullable|string',
            'future_vision' => 'nullable|string',
        ]);
        
        $startup->name = $request->name;
        $startup->description = $request->description;
        $startup->sector = $request->sector;
        $startup->funding_stage = $request->funding_stage;
        $startup->website = $request->website;
        $startup->year_founded = $request->year_founded;
        $startup->team_size = $request->team_size;
        
        // If the startup was previously approved or rejected, set it back to pending
        if ($startup->status == 'active' || $startup->status == 'rejected') {
            $startup->status = 'pending';
        }
        
        // Basic Information
        $startup->tagline = $request->tagline;
        
        // Industry & Category
        $startup->business_model = $request->business_model;
        
        // Location
        $startup->headquarters_location = $request->headquarters_location;
        $startup->operating_regions = $request->operating_regions;
        
        // Team Information
        $startup->linkedin_url = $request->linkedin_url;
        
        // Problem & Solution
        $startup->problem_statement = $request->problem_statement;
        $startup->solution = $request->solution;
        $startup->innovation_differentiator = $request->innovation_differentiator;
        
        // Market & Traction
        $startup->target_market_size = $request->target_market_size;
        $startup->current_customers = $request->current_customers;
        $startup->monthly_revenue = $request->monthly_revenue;
        $startup->key_metrics = $request->key_metrics;
        $startup->partnerships = $request->partnerships;
        $startup->achievements = $request->achievements;
        
        // Technology & Operations
        $startup->technology_stack = $request->technology_stack;
        $startup->operational_model = $request->operational_model;
        $startup->ip_patents = $request->ip_patents;
        
        // Funding & Financials
        $startup->has_raised_funds = $request->has_raised_funds;
        $startup->amount_raised = $request->amount_raised;
        $startup->monthly_burn_rate = $request->monthly_burn_rate;
        $startup->funding_needed = $request->funding_needed;
        $startup->funding_use = $request->funding_use;
        
        // Documents & Media
        $startup->demo_video = $request->demo_video;
        
        // Goals & Needs
        $startup->current_challenges = $request->current_challenges;
        $startup->support_needed = $request->support_needed;
        $startup->future_vision = $request->future_vision;
        
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($startup->logo && Storage::exists('public/' . str_replace('storage/', '', $startup->logo))) {
                Storage::delete('public/' . str_replace('storage/', '', $startup->logo));
            }
            
            $path = $request->file('logo')->store('startup_logos', 'public');
            $startup->logo = 'storage/' . $path;
        }
        
        if ($request->hasFile('pitch_deck')) {
            // Delete old pitch deck if exists
            if ($startup->pitch_deck && Storage::exists('public/' . str_replace('storage/', '', $startup->pitch_deck))) {
                Storage::delete('public/' . str_replace('storage/', '', $startup->pitch_deck));
            }
            
            $path = $request->file('pitch_deck')->store('startup_documents', 'public');
            $startup->pitch_deck = 'storage/' . $path;
        }
        
        if ($request->hasFile('company_registration')) {
            // Delete old company registration if exists
            if ($startup->company_registration && Storage::exists('public/' . str_replace('storage/', '', $startup->company_registration))) {
                Storage::delete('public/' . str_replace('storage/', '', $startup->company_registration));
            }
            
            $path = $request->file('company_registration')->store('startup_documents', 'public');
            $startup->company_registration = 'storage/' . $path;
        }
        
        if ($startup->save()) {
            \Log::info('Startup profile updated successfully for ID: ' . $startup->id);
            return redirect()->route('entrepreneur.startup-profile')->with('success', 'Startup profile updated successfully!');
        } else {
            \Log::error('Failed to update startup profile for ID: ' . $startup->id);
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update startup profile.']);
        }
    }
    
    /**
     * Admin method to approve a startup profile
     */
    public function approve(Startup $startup)
    {
        $startup->status = 'active';
        $startup->save();
        
        return redirect()->back()->with('success', 'Startup profile approved successfully!');
    }
    
    /**
     * Admin method to reject a startup profile
     */
    public function reject(Startup $startup)
    {
        $startup->status = 'rejected';
        $startup->save();
        
        return redirect()->back()->with('success', 'Startup profile rejected.');
    }
    
    /**
     * Delete a startup profile
     */
    public function destroy(Startup $startup)
    {
        // Check if the authenticated user is the founder or an admin
        if (Auth::id() !== $startup->founder_id && !Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this startup profile.');
        }
        
        // Delete logo if exists
        if ($startup->logo && Storage::exists('public/' . str_replace('storage/', '', $startup->logo))) {
            Storage::delete('public/' . str_replace('storage/', '', $startup->logo));
        }
        
        $startup->delete();
        
        return redirect()->back()->with('success', 'Startup profile deleted successfully!');
    }
    

    

}