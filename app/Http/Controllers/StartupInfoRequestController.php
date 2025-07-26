<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Startup;
use App\Models\StartupInfoRequest;
use App\Models\User;
use App\Notifications\StartupInfoRequestNotification;
use App\Notifications\StartupInfoRequestApprovedNotification;
use App\Notifications\StartupInfoRequestRejectedNotification;

class StartupInfoRequestController extends Controller
{
    /**
     * Store a new startup info request
     */
    public function store(Request $request, Startup $startup)
    {
        // Ensure user is an investor
        if (Auth::user()->role !== 'investor') {
            return redirect()->back()->with('error', 'Only investors can request startup information.');
        }

        // Check if startup is approved
        if ($startup->status !== 'approved') {
            return redirect()->back()->with('error', 'This startup profile is not available for viewing.');
        }

        // Check if request already exists
        $existingRequest = StartupInfoRequest::where('startup_id', $startup->id)
            ->where('investor_id', Auth::id())
            ->first();

        if ($existingRequest) {
            if ($existingRequest->status === 'pending') {
                return redirect()->back()->with('info', 'You already have a pending request for this startup.');
            } elseif ($existingRequest->status === 'approved') {
                return redirect()->route('investor.startup-profile', $startup->id);
            } else {
                return redirect()->back()->with('error', 'Your previous request for this startup was rejected.');
            }
        }

        // Create new request
        $infoRequest = StartupInfoRequest::create([
            'startup_id' => $startup->id,
            'investor_id' => Auth::id(),
            'request_message' => $request->input('request_message'),
            'status' => 'pending',
        ]);

        // Notify admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new StartupInfoRequestNotification($infoRequest));
        }

        return redirect()->back()->with('success', 'Your request has been submitted and is pending admin approval.');
    }

    /**
     * Approve a startup info request (admin only)
     */
    public function approve(Request $request, StartupInfoRequest $infoRequest)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $infoRequest->update([
            'status' => 'approved',
            'admin_notes' => $request->input('admin_notes'),
            'approved_at' => now(),
        ]);

        // Notify investor
        $infoRequest->investor->notify(new StartupInfoRequestApprovedNotification($infoRequest));

        return redirect()->back()->with('success', 'Startup info request approved successfully.');
    }

    /**
     * Reject a startup info request (admin only)
     */
    public function reject(Request $request, StartupInfoRequest $infoRequest)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $infoRequest->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('admin_notes'),
            'rejected_at' => now(),
        ]);

        // Notify investor
        $infoRequest->investor->notify(new StartupInfoRequestRejectedNotification($infoRequest));

        return redirect()->back()->with('success', 'Startup info request rejected successfully.');
    }

    /**
     * Show startup profile to approved investor
     */
    public function show(Startup $startup)
    {
        if (Auth::user()->role !== 'investor') {
            return redirect()->back()->with('error', 'Only investors can view startup profiles.');
        }

        // Check if investor has approved access
        $infoRequest = StartupInfoRequest::where('startup_id', $startup->id)
            ->where('investor_id', Auth::id())
            ->where('status', 'approved')
            ->first();

        if (!$infoRequest) {
            return redirect()->back()->with('error', 'You do not have access to this startup profile.');
        }

        return view('investor.startup-profile', compact('startup'));
    }
}
