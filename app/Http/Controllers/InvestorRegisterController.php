<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvestorRegisterRequest;
use App\Models\User;
use App\Notifications\UserRegistrationNotification;
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

        // Send notification to all admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new UserRegistrationNotification($user));
        }

        return redirect()->route('registration.success')->with('success', 'Registration successful! Please wait for admin approval.');
    }
} 