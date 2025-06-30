<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Dummy data for demonstration
        $totalUsers = 1200;
        $activePrograms = 45;
        $pitchEvents = 12;
        $successRate = 85;

        $recentActivity = [
            ['color' => 'green', 'text' => 'John Doe registered as Entrepreneur', 'time' => '2 hours ago'],
            ['color' => 'blue', 'text' => 'New program "Startup Accelerator" launched', 'time' => '1 day ago'],
            ['color' => 'purple', 'text' => 'Pitch event "Innovation Summit" announced', 'time' => '3 days ago'],
        ];

        $upcomingEvents = [
            ['title' => 'Investor Meetup', 'time' => '2025-07-10 10:00 AM', 'participants' => '25 Investors'],
            ['title' => 'Webinar: Funding Your Startup', 'time' => '2025-07-15 02:00 PM', 'participants' => '150 Attendees'],
        ];

        return view('admin.dashboard', compact('totalUsers', 'activePrograms', 'pitchEvents', 'successRate', 'recentActivity', 'upcomingEvents'));
    }

    public function userManagement()
    {
        $allUsers = User::all(); // Fetch all users
        $users = User::where('is_approved', false)->get(); // Pending users
        return view('admin.user-management', compact('allUsers', 'users'));
    }

    public function editUser($id)
    {
        // Placeholder for edit user functionality
        return redirect()->back()->with('info', 'Edit user functionality coming soon.');
    }

    public function approve($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user->is_approved = true;
        $user->save();

        return redirect()->back()->with('success', 'User approved successfully.');
    }

    public function reject($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user->is_approved = false;
        $user->save();

        return redirect()->back()->with('success', 'User rejected successfully.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
