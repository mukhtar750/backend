<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:bdsp,entrepreneur,investor',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_approved' => false,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please wait for admin approval.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return redirect()->back()->withErrors(['email' => 'Invalid login credentials'])->withInput();
        }

        $user = Auth::user();

        if (!$user->is_approved) {
            Auth::logout();
            return redirect()->back()->withErrors(['email' => 'Your account is awaiting admin approval.'])->withInput();
        }

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            // Redirect based on specific role
            if ($user->role === 'investor') {
                return redirect()->route('dashboard.investor');
            } elseif ($user->role === 'bdsp') {
                return redirect()->route('dashboard.bdsp');
            } elseif ($user->role === 'entrepreneur') {
                return redirect()->route('dashboard.entrepreneur');
            } else {
                // Fallback for other roles or if role is not explicitly handled
                return redirect()->route('dashboard');
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}