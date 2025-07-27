<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Startup;
use App\Models\StartupInfoRequest;
use App\Models\User;
use App\Notifications\StartupInfoRequestNotification;
use Illuminate\Support\Facades\Auth;

class InvestorController extends Controller
{
    /**
     * Request access to a startup's full profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $startupId
     * @return \Illuminate\Http\Response
     */
    public function requestAccess(Request $request, $startupId)
    {
        \Log::info('RequestAccess method called:', ['startup_id' => $startupId, 'user_id' => Auth::id(), 'user_role' => Auth::user()->role]);
        
        // Verify the user is an investor
        if (Auth::user()->role !== 'investor') {
            \Log::info('User is not an investor, redirecting');
            return redirect()->back()->with('error', 'Only investors can request access to startup profiles.');
        }
        
        \Log::info('User is investor, proceeding');
        
        // Find the startup
        $startup = Startup::findOrFail($startupId);
        \Log::info('Startup found:', ['startup_id' => $startup->id, 'startup_name' => $startup->name]);
        
        // Check if the startup is active or approved
        if (!in_array($startup->status, ['active', 'approved'])) {
            \Log::info('Startup is not active or approved:', ['status' => $startup->status]);
            return redirect()->back()->with('error', 'This startup profile is not currently available for requests.');
        }
        
        \Log::info('Startup is available for requests, checking existing requests');
            
        // Check if the investor has already requested access
        $existingRequest = StartupInfoRequest::where('investor_id', Auth::id())
            ->where('startup_id', $startupId)
            ->first();
            
        \Log::info('Existing request check:', ['exists' => $existingRequest ? 'yes' : 'no', 'status' => $existingRequest ? $existingRequest->status : 'none']);
            
        if ($existingRequest) {
            if ($existingRequest->status === 'pending') {
                return redirect()->back()->with('info', 'You have already requested access to this startup profile. Your request is pending.');
            } elseif ($existingRequest->status === 'approved') {
                return redirect()->back()->with('info', 'You already have access to this startup profile.');
            } elseif ($existingRequest->status === 'rejected') {
                // Update the existing rejected request to pending
                $existingRequest->status = 'pending';
                $existingRequest->request_message = $request->message ?? null;
                $existingRequest->save();
                
                // Notify admins
                $admins = User::where('role', 'admin')->get();
                \Log::info('Found admins for re-request notification:', ['count' => $admins->count(), 'admin_ids' => $admins->pluck('id')]);
                
                foreach ($admins as $admin) {
                    \Log::info('Sending re-request notification to admin:', ['admin_id' => $admin->id, 'admin_name' => $admin->name]);
                    $admin->notify(new StartupInfoRequestNotification($existingRequest));
                }
                
                return redirect()->back()->with('success', 'Your access request has been resubmitted.');
            }
        }
        
        // Create a new access request
        $infoRequest = StartupInfoRequest::create([
            'startup_id' => $startupId,
            'investor_id' => Auth::id(),
            'status' => 'pending',
            'request_message' => $request->message ?? null,
        ]);
        
        // Notify admins
        $admins = User::where('role', 'admin')->get();
        \Log::info('Found admins for notification:', ['count' => $admins->count(), 'admin_ids' => $admins->pluck('id')]);
        
        foreach ($admins as $admin) {
            \Log::info('Sending notification to admin:', ['admin_id' => $admin->id, 'admin_name' => $admin->name]);
            $admin->notify(new StartupInfoRequestNotification($infoRequest));
        }
        
        return redirect()->back()->with('success', 'Your request for access has been submitted. You will be notified when the admin responds.');
    }
    
    /**
     * Display a listing of startups for investors
     *
     * @return \Illuminate\Http\Response
     */
    public function startupProfiles()
    {
        // Verify the user is an investor
        if (Auth::user()->role !== 'investor') {
            return redirect()->route('dashboard');
        }
        
        // Get all startups (not just active ones) for debugging
        $allStartups = Startup::with('founder')->get();
        \Log::info('All startups found:', ['count' => $allStartups->count(), 'startups' => $allStartups->pluck('name', 'status')]);
        
        // Get all active startups with founder information
        $startups = Startup::where('status', 'active')
            ->with('founder')
            ->orderBy('created_at', 'desc')
            ->get();
        
        \Log::info('Active startups found:', ['count' => $startups->count()]);
        
        // If no active startups, let's show all startups for debugging
        if ($startups->isEmpty()) {
            $startups = Startup::with('founder')
                ->orderBy('created_at', 'desc')
                ->get();
            \Log::info('Showing all startups instead of just active ones:', ['count' => $startups->count()]);
        }
        
        // Get the investor's access requests
        $accessRequests = StartupInfoRequest::where('investor_id', Auth::id())->get()
            ->keyBy('startup_id');
        
        // Transform startups data for the frontend
        $startupsData = $startups->map(function($startup) use ($accessRequests) {
            return [
                'id' => $startup->id,
                'name' => $startup->name,
                'sector' => $startup->sector,
                'tagline' => $startup->tagline,
                'logo' => $startup->logo ? asset('storage/' . $startup->logo) : 'https://logo.clearbit.com/placeholder.com',
                'stage' => $startup->funding_stage,
                'location' => $startup->headquarters_location,
                'stats' => $this->getStartupStats($startup),
                'teaser' => true,
                'description' => $startup->description,
                'team' => [
                    [
                        'name' => $startup->founder->name ?? 'Unknown',
                        'role' => 'Founder',
                        'photo' => 'https://i.pravatar.cc/40?img=' . ($startup->founder->id ?? 1)
                    ]
                ],
                'pitchdeck' => !empty($startup->pitch_deck),
                'funding_needed' => $startup->funding_needed,
                'monthly_revenue' => $startup->monthly_revenue,
                'team_size' => $startup->team_size,
                'year_founded' => $startup->year_founded,
                'has_access' => isset($accessRequests[$startup->id]) && $accessRequests[$startup->id]->status === 'approved',
                'request_status' => isset($accessRequests[$startup->id]) ? $accessRequests[$startup->id]->status : null,
                'updated_at' => $startup->updated_at->diffForHumans(),
                'status' => $startup->status // Add status for debugging
            ];
        });
        
        \Log::info('Startups data prepared:', ['count' => $startupsData->count(), 'data' => $startupsData->toArray()]);
        
        return view('dashboard.investor-startup-profiles', compact('startupsData', 'accessRequests'));
    }
    
    /**
     * View a specific startup profile
     *
     * @param  int  $startupId
     * @return \Illuminate\Http\Response
     */
    public function viewStartup($startupId)
    {
        // Verify the user is an investor
        if (Auth::user()->role !== 'investor') {
            return redirect()->route('dashboard');
        }
        
        // Find the startup
        $startup = Startup::findOrFail($startupId);
        
        // Check if the startup is active
        if ($startup->status !== 'active') {
            return redirect()->route('investor.startup_profiles')
                ->with('error', 'This startup profile is not currently active.');
        }
        
        // Check if the investor has access to the full profile
        $hasAccess = StartupInfoRequest::where('investor_id', Auth::id())
            ->where('startup_id', $startupId)
            ->where('status', 'approved')
            ->exists();
        
        return view('investor.view-startup', compact('startup', 'hasAccess'));
    }

    /**
     * Get startup statistics for display
     */
    private function getStartupStats($startup)
    {
        if ($startup->current_customers) {
            return $startup->current_customers . ' customers';
        } elseif ($startup->team_size) {
            return $startup->team_size . ' team members';
        } elseif ($startup->year_founded) {
            return 'Founded ' . $startup->year_founded;
        } else {
            return 'Active startup';
        }
    }
    
    /**
     * Display investor dashboard with real data
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // Verify the user is an investor
        if (Auth::user()->role !== 'investor') {
            return redirect()->route('dashboard');
        }
        
        // Get approved startups for display
        $approvedStartups = Startup::where('status', 'active')
            ->with('founder')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        
        // Calculate dashboard statistics
        $startupsCount = Startup::where('status', 'active')->count();
        $pitchesCount = \App\Models\PitchEvent::where('status', 'published')
            ->where('event_date', '>=', now())
            ->count();
        
        // Get investor's access requests
        $accessRequests = StartupInfoRequest::where('investor_id', Auth::id())->get();
        $approvedRequests = $accessRequests->where('status', 'approved')->count();
        $pendingRequests = $accessRequests->where('status', 'pending')->count();
        
        return view('dashboard.investor', compact(
            'approvedStartups',
            'startupsCount',
            'pitchesCount',
            'approvedRequests',
            'pendingRequests'
        ));
    }
}