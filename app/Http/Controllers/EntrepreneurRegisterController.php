<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntrepreneurRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EntrepreneurRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register-entrepreneur');
    }

    public function register(EntrepreneurRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'entrepreneur',
            'password' => Hash::make($request->password),
            'business_name' => $request->business_name,
            'sector' => $request->sector,
            'cac_number' => $request->cac_number,
            'funding_stage' => $request->funding_stage,
            'website' => $request->website,
            'entrepreneur_phone' => $request->entrepreneur_phone,
            'entrepreneur_linkedin' => $request->entrepreneur_linkedin,
        ]);

        return redirect()->route('registration.success')->with('success', 'Registration successful! Please wait for admin approval.');
    }
} 