<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\IdeaInterest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaInterestController extends Controller
{
    /**
     * Express interest in developing an idea
     */
    public function store(Request $request, Idea $idea)
    {
        // Check if user already expressed interest
        $existingInterest = IdeaInterest::where('idea_id', $idea->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingInterest) {
            return back()->with('error', 'You have already expressed interest in this idea.');
        }

        $data = $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        $interest = IdeaInterest::create([
            'idea_id' => $idea->id,
            'user_id' => Auth::id(),
            'message' => $data['message'] ?? null,
            'status' => 'pending'
        ]);

        // Update interest count on the idea
        $idea->increment('interest_count');

        return back()->with('success', 'Interest expressed successfully! The idea owner will be notified.');
    }

    /**
     * Remove interest in developing an idea
     */
    public function destroy(Idea $idea)
    {
        $interest = IdeaInterest::where('idea_id', $idea->id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$interest) {
            return back()->with('error', 'No interest found to remove.');
        }

        $interest->delete();

        // Update interest count on the idea
        $idea->decrement('interest_count');

        return back()->with('success', 'Interest removed successfully.');
    }

    /**
     * Admin: Accept user interest
     */
    public function accept(IdeaInterest $interest)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $interest->update(['status' => 'accepted']);
        return back()->with('success', 'Interest accepted.');
    }

    /**
     * Admin: Decline user interest
     */
    public function decline(IdeaInterest $interest)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $interest->update(['status' => 'declined']);
        return back()->with('success', 'Interest declined.');
    }
}
