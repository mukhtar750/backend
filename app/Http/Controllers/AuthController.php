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
            } elseif ($user->role === 'mentor') {
                return redirect()->route('dashboard.mentor');
            } elseif ($user->role === 'mentee') {
                return redirect()->route('dashboard.mentee');
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
        $user = auth()->user();
        $name = $user->name;
        // Example logic for milestone, days left, and points
        $milestone = 'Pitch Deck Completion'; // Replace with real milestone logic
        $daysLeft = '14 days'; // Replace with real calculation
        $points = '1,250 pts'; // Replace with real calculation
        $pairings = \App\Models\Pairing::with(['userOne', 'userTwo'])
            ->where('user_one_id', $user->id)
            ->orWhere('user_two_id', $user->id)
            ->get();
        return view('dashboard.entrepreneur', compact('name', 'milestone', 'daysLeft', 'points', 'pairings'));
    }

    public function menteeDashboard()
    {
        $mentee = auth()->user();
        // Find mentor pairing
        $mentorPairing = \App\Models\Pairing::where('pairing_type', 'mentor_mentee')
            ->where(function ($q) use ($mentee) {
                $q->where('user_one_id', $mentee->id)->orWhere('user_two_id', $mentee->id);
            })
            ->with(['userOne', 'userTwo'])
            ->first();
        $mentor = null;
        if ($mentorPairing) {
            $mentor = $mentorPairing->user_one_id == $mentee->id ? $mentorPairing->userTwo : $mentorPairing->userOne;
        }
        // Get upcoming sessions for this mentee
        $upcomingSessions = \App\Models\MentorshipSession::where(function ($q) use ($mentee) {
                $q->where('scheduled_by', $mentee->id)
                  ->orWhere('scheduled_for', $mentee->id);
            })
            ->where('date_time', '>=', now())
            ->orderBy('date_time')
            ->with(['pairing.userOne', 'pairing.userTwo', 'scheduledBy', 'scheduledFor'])
            ->get();
        // Get past sessions for this mentee
        $pastSessions = \App\Models\MentorshipSession::where(function ($q) use ($mentee) {
                $q->where('scheduled_by', $mentee->id)
                  ->orWhere('scheduled_for', $mentee->id);
            })
            ->where('date_time', '<', now())
            ->orderByDesc('date_time')
            ->with(['pairing.userOne', 'pairing.userTwo', 'scheduledBy', 'scheduledFor'])
            ->get();
        // Get recent messages: get mentee's conversations, take latest message from each, sort and limit
        $conversations = $mentee->getConversations();
        $messages = $conversations->map(function ($conv) {
            return $conv->latestMessage;
        })->filter()->sortByDesc('created_at')->take(5);
        return view('dashboard.mentee', compact('mentee', 'mentor', 'upcomingSessions', 'pastSessions', 'messages'));
    }
}