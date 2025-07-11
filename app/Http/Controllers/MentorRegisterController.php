<?php

namespace App\Http\Controllers;

use App\Http\Requests\MentorRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MentorRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register-mentor');
    }

    public function register(MentorRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'mentor',
            'password' => Hash::make($request->password),
            'bio' => $request->bio,
            'expertise' => $request->expertise,
            'years_of_experience' => $request->years_of_experience,
            'linkedin' => $request->linkedin,
            'is_approved' => false,
        ]);

        return redirect()->route('registration.success')->with('success', 'Registration successful! Please wait for admin approval.');
    }
} 