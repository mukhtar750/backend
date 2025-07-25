<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Startup;
use App\Models\StartupAccessRequest;
use App\Models\User;
use App\Notifications\StartupAccessRequested;
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
        // Verify the user is an investor
        if (Auth::user()->role !== 'investor') {
            return redirect()->back()->with('error', 'Only investors can request access to startup profiles.');
        }
        
        // Find the startup
        $startup = Startup::findOrFail($startupId);
        
        // Check if the startup is active
        if ($startup->status !== 'active') {
            return redirect()->back()->with('error', 'This startup profile is not currently active.');
        }
        
        // Check if the investor has already requested access
        $existingRequest = StartupAccessRequest::where('investor_id', Auth::id())
            ->where('startup_id', $startupId)
            ->first();
            
        if ($existingRequest) {
            if ($existingRequest->status === 'pending') {
                return redirect()->back()->with('info', 'You have already requested access to this startup profile. Your request is pending.');
            } elseif ($existingRequest->status === 'approved') {
                return redirect()->back()->with('info', 'You already have access to this startup profile.');
            } elseif ($existingRequest->status === 'rejected') {
                // Update the existing rejected request to pending
                $existingRequest->status = 'pending';
                $existingRequest->message = $request->message ?? null;
                $existingRequest->save();
                
                // Notify the startup founder
                $startup->founder->notify(new StartupAccessRequested($existingRequest));
                
                return redirect()->back()->with('success', 'Your access request has been resubmitted.');
            }
        }
        
        // Create a new access request
        $accessRequest = new StartupAccessRequest();
        $accessRequest->investor_id = Auth::id();
        $accessRequest->startup_id = $startupId;
        $accessRequest->message = $request->message ?? null;
        $accessRequest->status = 'pending';
        $accessRequest->save();
        
        // Notify the startup founder
        $startup->founder->notify(new StartupAccessRequested($accessRequest));
        
        return redirect()->back()->with('success', 'Your request for access has been submitted. You will be notified when the founder responds.');
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
        
        // Get all active startups
        $startups = Startup::where('status', 'active')->get();
        
        // Get the investor's access requests
        $accessRequests = StartupAccessRequest::where('investor_id', Auth::id())->get()
            ->keyBy('startup_id');
        
        return view('investor.startup-profiles', compact('startups', 'accessRequests'));
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
        $hasAccess = StartupAccessRequest::where('investor_id', Auth::id())
            ->where('startup_id', $startupId)
            ->where('status', 'approved')
            ->exists();
        
        return view('investor.view-startup', compact('startup', 'hasAccess'));
    }
}