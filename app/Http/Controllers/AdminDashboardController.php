<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Replace these with real queries as needed
        $totalUsers = User::count();
        $activePrograms = 8; // Dummy data
        $pitchEvents = 15;   // Dummy data
        $successRate = 78;   // Dummy data
        $recentActivity = [
            ['text' => 'New entrepreneur profile pending approval', 'time' => '2 minutes ago', 'color' => 'purple'],
            ['text' => 'Business Plan Workshop completed', 'time' => '1 hour ago', 'color' => 'green'],
            ['text' => 'Pitch event scheduled for next week', 'time' => '3 hours ago', 'color' => 'blue'],
            ['text' => '5 new feedback submissions received', 'time' => '1 day ago', 'color' => 'orange'],
        ];
        $upcomingEvents = [
            ['title' => 'Digital Marketing Workshop', 'time' => 'Tomorrow 10:00 AM', 'participants' => 25],
            ['title' => 'Investor Pitch Day', 'time' => 'Friday 2:00 PM', 'participants' => 12],
            ['title' => 'Mentorship Matching Session', 'time' => 'Next Monday 9:00 AM', 'participants' => 18],
        ];
        return view('admin.dashboard', compact('totalUsers', 'activePrograms', 'pitchEvents', 'successRate', 'recentActivity', 'upcomingEvents'));
    }
} 