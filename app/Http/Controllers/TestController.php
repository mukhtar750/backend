<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UserRegistrationNotification;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function createTestNotification()
    {
        $user = auth()->user();
        
        // Create a test user for notification
        $testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'entrepreneur',
        ]);
        
        // Send notification to current user
        $user->notify(new UserRegistrationNotification($testUser));
        
        return response()->json(['success' => true, 'message' => 'Test notification created!']);
    }
} 