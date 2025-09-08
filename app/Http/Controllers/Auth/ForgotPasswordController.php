<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }
    
    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }
        
        // Create password reset token
        $token = Str::random(64);
        
        // Store token in database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );
        
        // Send email with reset link
        $resetUrl = url(route('password.reset', ['token' => $token, 'email' => $request->email], false));
        
        // Send the actual email
        Mail::send('auth.emails.password', ['token' => $token, 'resetUrl' => $resetUrl], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Your Password');
        });
        
        // Also log the reset URL
        \Illuminate\Support\Facades\Log::info('Password Reset Link: ' . $resetUrl);
        
        return back()->with('status', 'We have emailed your password reset link!');
    }
}