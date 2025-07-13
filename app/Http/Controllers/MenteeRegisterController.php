<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenteeRegisterRequest;
use App\Models\User;
use App\Notifications\UserRegistrationNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MenteeRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register-mentee');
    }

    public function register(MenteeRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'mentee',
            'password' => Hash::make($request->password),
            'linkedin' => $request->linkedin,
            'interests' => $request->interests,
            'goals' => $request->goals,
        ]);

        // Send notification to all admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new UserRegistrationNotification($user));
        }

        return redirect()->route('registration.success')->with('success', 'Registration successful! Please wait for admin approval.');
    }
} 