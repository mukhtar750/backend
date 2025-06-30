<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvestorRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InvestorRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register-investor');
    }

    public function register(InvestorRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'investor',
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'type_of_investor' => $request->type_of_investor,
            'interest_areas' => $request->interest_areas,
            'company' => $request->company,
            'investor_linkedin' => $request->investor_linkedin,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard.investor')->with('success', 'Registration successful!');
    }
} 