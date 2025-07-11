<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenteeRegisterRequest;
use App\Models\User;
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
            'bio' => $request->bio,
            'interests' => $request->interests,
            'goals' => $request->goals,
            'linkedin' => $request->linkedin,
            'is_approved' => false,
        ]);

        return redirect()->route('registration.success')->with('success', 'Registration successful! Please wait for admin approval.');
    }
} 