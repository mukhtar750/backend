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
            'mentor_id' => 'required|exists:users,id',
            'topic' => 'required|string|max:255',
            'date_time' => 'required|date|after:now',
            'session_type' => 'required|string|max:32',
            'notes' => 'nullable|string',
        ]);
        $mentorId = $request->mentor_id;
        $entrepreneurId = $user->id;
        // Check for existing pairing
        $pairing = \App\Models\Pairing::where('pairing_type', 'mentor_entrepreneur')
            ->where(function($q) use ($mentorId, $entrepreneurId) {
                $q->where('user_one_id', $mentorId)->where('user_two_id', $entrepreneurId)
                  ->orWhere(function($q2) use ($mentorId, $entrepreneurId) {
                      $q2->where('user_one_id', $entrepreneurId)->where('user_two_id', $mentorId);
                  });
            })->first();
        if (!$pairing) {
            $pairing = \App\Models\Pairing::create([
                'user_one_id' => $mentorId,
                'user_two_id' => $entrepreneurId,
                'pairing_type' => 'mentor_entrepreneur',
            ]);
        }
        $session = \App\Models\MentorshipSession::create([
            'pairing_id' => $pairing->id,
            'scheduled_by' => $entrepreneurId,
            'scheduled_for' => $mentorId,
            'date_time' => $request->date_time,
            'duration' => 60,
            'topic' => $request->topic,
            'notes' => $request->notes,
            'meeting_link' => null,
            'status' => 'pending',
        ]);
        // TODO: Notify admin for approval
        return response()->json(['success' => true, 'message' => 'Session requested and pending admin approval.']);
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
