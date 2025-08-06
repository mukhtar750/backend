<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StartupApprovedNotification;
use App\Notifications\StartupRejectedNotification;

class AdminStartupController extends Controller
{
    // Show full startup profile
    public function show(Startup $startup)
    {
        $startup->load('founder');
        return view('admin.startups.show', compact('startup'));
    }

    // Approve startup profile
    public function approve(Startup $startup)
    {
        $startup->status = 'approved';
        $startup->save();
        // Notify founder
        if ($startup->founder) {
            $startup->founder->notify(new StartupApprovedNotification($startup));
        }
        return redirect()->back()->with('success', 'Startup profile approved.');
    }

    // Reject startup profile
    public function reject(Startup $startup)
    {
        $startup->status = 'rejected';
        $startup->save();
        // Notify founder
        if ($startup->founder) {
            $startup->founder->notify(new StartupRejectedNotification($startup));
        }
        return redirect()->back()->with('success', 'Startup profile rejected.');
    }

    // Delete startup profile
    public function destroy(Startup $startup)
    {
        $startup->delete();
        return redirect()->back()->with('success', 'Startup profile deleted successfully.');
    }

    // Toggle anonymous teaser setting
    public function toggleAnonymousTeaser(Startup $startup)
    {
        $startup->anonymous_teaser = !$startup->anonymous_teaser;
        $startup->save();
        
        $message = $startup->anonymous_teaser 
            ? 'Anonymous teaser mode enabled for ' . $startup->name . '. Startup name will be hidden from investors.'
            : 'Anonymous teaser mode disabled for ' . $startup->name . '. Startup name is now visible to investors.';
        
        return redirect()->back()->with('success', $message);
    }
}
