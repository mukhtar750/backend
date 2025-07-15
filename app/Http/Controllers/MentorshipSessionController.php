<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MentorshipSession;
use App\Models\Pairing;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MentorshipSessionController extends Controller
{
    // List sessions for the logged-in user (as scheduled_by or scheduled_for)
    public function index()
    {
        $user = Auth::user();
        $sessions = MentorshipSession::with(['pairing.userOne', 'pairing.userTwo', 'scheduledBy', 'scheduledFor'])
            ->where('scheduled_by', $user->id)
            ->orWhere('scheduled_for', $user->id)
            ->orderBy('date_time', 'desc')
            ->get();
        return view('dashboard.partials.entrepreneur.mentorship-sessions', compact('sessions'));
    }

    // Show a single session
    public function show(MentorshipSession $mentorship_session)
    {
        $this->authorize('view', $mentorship_session);
        return view('dashboard.partials.entrepreneur.mentorship-session-detail', compact('mentorship_session'));
    }

    // Book a new session
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'pairing_id' => 'required|exists:pairings,id',
            'date_time' => 'required|date|after:now',
            'duration' => 'required|integer|min:15|max:240',
            'topic' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'meeting_link' => 'required|url|max:255', // Now required
        ]);
        $pairing = Pairing::findOrFail($request->pairing_id);
        // Only enforce for non-admins
        if ($user->role !== 'admin' && $pairing->user_one_id !== $user->id && $pairing->user_two_id !== $user->id) {
            abort(403, 'You are not part of this pairing.');
        }
        // Determine scheduled_for
        if ($user->role === 'admin') {
            $scheduledBy = $user->id;
            $scheduledFor = $pairing->user_one_id; // Default to user_one, could be improved later
        } else {
            $scheduledBy = $user->id;
            $scheduledFor = $pairing->user_one_id === $user->id ? $pairing->user_two_id : $pairing->user_one_id;
        }
        $session = MentorshipSession::create([
            'pairing_id' => $pairing->id,
            'scheduled_by' => $scheduledBy,
            'scheduled_for' => $scheduledFor,
            'date_time' => $request->date_time,
            'duration' => $request->duration,
            'topic' => $request->topic,
            'notes' => $request->notes,
            'meeting_link' => $request->meeting_link, // Save meeting_link
            'status' => 'pending',
        ]);
        // TODO: Notify the other user
        return redirect()->back()->with('success', 'Session booked and awaiting confirmation.');
    }

    // Confirm a session (by the invited user)
    public function confirm(MentorshipSession $mentorship_session)
    {
        $user = Auth::user();
        if ($mentorship_session->scheduled_for !== $user->id) {
            abort(403, 'Only the invited user can confirm this session.');
        }
        $mentorship_session->status = 'confirmed';
        $mentorship_session->save();
        // TODO: Notify both users
        return redirect()->back()->with('success', 'Session confirmed.');
    }

    // Cancel a session (by either party)
    public function cancel(MentorshipSession $mentorship_session)
    {
        $user = Auth::user();
        if ($mentorship_session->scheduled_by !== $user->id && $mentorship_session->scheduled_for !== $user->id) {
            abort(403, 'You are not allowed to cancel this session.');
        }
        $mentorship_session->status = 'cancelled';
        $mentorship_session->save();
        // TODO: Notify both users
        return redirect()->back()->with('success', 'Session cancelled.');
    }

    // Mark a session as complete (by either party)
    public function complete(MentorshipSession $mentorship_session)
    {
        $user = Auth::user();
        if ($mentorship_session->scheduled_by !== $user->id && $mentorship_session->scheduled_for !== $user->id) {
            abort(403, 'You are not allowed to complete this session.');
        }
        $mentorship_session->status = 'completed';
        $mentorship_session->save();
        // TODO: Notify both users
        return redirect()->back()->with('success', 'Session marked as completed.');
    }
}
