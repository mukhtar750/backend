<?php

namespace App\Http\Controllers;

use App\Http\Requests\BDSPRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BDSPRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register-bdsp');
    }

    public function register(BDSPRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'bdsp',
            'password' => Hash::make($request->password),
            'services_provided' => $request->services_provided,
            'years_of_experience' => $request->years_of_experience,
            'organization' => $request->organization,
            'certifications' => $request->certifications,
            'bdsp_linkedin' => $request->bdsp_linkedin,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard.bdsp')->with('success', 'Registration successful!');
    }
} 