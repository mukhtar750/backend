<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    // Store feedback from user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'target_type' => 'required|string', // e.g., 'platform', 'bdsp', 'mentor', 'training'
            'target_id' => 'nullable|integer',
            'category' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'comments' => 'nullable|string',
        ]);
        $feedback = Feedback::create([
            'user_id' => Auth::id(),
            'target_type' => $validated['target_type'],
            'target_id' => $validated['target_id'] ?? null,
            'category' => $validated['category'] ?? null,
            'rating' => $validated['rating'] ?? null,
            'comments' => $validated['comments'] ?? null,
            'status' => 'pending',
        ]);
        return back()->with('success', 'Thank you for your feedback!');
    }

    // Show feedback dashboard for entrepreneur
    public function index()
    {
        $user = Auth::user();
        // Feedback given by the user
        $feedbackGiven = \App\Models\Feedback::where('user_id', $user->id)->latest()->get();
        // Feedback received (if user is a mentor, bdsp, etc.)
        $feedbackReceived = \App\Models\Feedback::where('target_type', $user->role)
            ->where('target_id', $user->id)
            ->latest()->get();
        // Stats
        $stats = [
            'given_count' => $feedbackGiven->count(),
            'received_count' => $feedbackReceived->count(),
            'avg_rating_given' => $feedbackGiven->avg('rating'),
            'avg_rating_received' => $feedbackReceived->avg('rating'),
        ];
        return view('dashboard.entrepreneur-feedback', compact('feedbackGiven', 'feedbackReceived', 'stats'));
    }
}
