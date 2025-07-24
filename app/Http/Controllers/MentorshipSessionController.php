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

    public function create()
    {
        // You can pass mentees or other data here if needed
        return view('mentor.sessions.create');
    }

    public function mentorScheduleSessionPage()
    {
        $mentor = auth()->user();
        // Get all pairings where this user is a mentor
        $pairings = \App\Models\Pairing::whereIn('pairing_type', ['mentor_mentee', 'mentor_entrepreneur'])
            ->where(function ($q) use ($mentor) {
                $q->where('user_one_id', $mentor->id)->orWhere('user_two_id', $mentor->id);
            })
            ->with(['userOne', 'userTwo'])
            ->get();
        $pairedMentees = $pairings->map(function ($pairing) use ($mentor) {
            return $pairing->user_one_id == $mentor->id ? $pairing->userTwo : $pairing->userOne;
        });
        // Get recent sessions (last 10)
        $recentSessions = \App\Models\MentorshipSession::where(function ($query) use ($mentor) {
            $query->where('scheduled_by', $mentor->id)
                  ->orWhere('scheduled_for', $mentor->id);
        })
        ->with(['pairing.userOne', 'pairing.userTwo', 'scheduledBy', 'scheduledFor'])
        ->orderBy('date_time', 'desc')
        ->limit(10)
        ->get();
        return view('mentor.sessions.create', compact('pairedMentees', 'recentSessions'));
    }

    public function mentorScheduleSession(Request $request)
    {
        $request->validate([
            'mentee_id' => 'required|exists:users,id',
            'session_date' => 'required|date|after_or_equal:today',
            'session_time' => 'required',
            'session_type' => 'required|in:1-on-1,group',
            'topic' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'session_link' => 'nullable|url',
        ]);
        $mentor = auth()->user();
        // Check if the mentee is actually paired with this mentor
        $isPaired = \App\Models\Pairing::whereIn('pairing_type', ['mentor_mentee', 'mentor_entrepreneur'])
            ->where(function ($q) use ($mentor, $request) {
                $q->where(function ($q2) use ($mentor, $request) {
                    $q2->where('user_one_id', $mentor->id)->where('user_two_id', $request->mentee_id);
                })->orWhere(function ($q2) use ($mentor, $request) {
                    $q2->where('user_one_id', $request->mentee_id)->where('user_two_id', $mentor->id);
                });
            })
            ->exists();
        if (!$isPaired) {
            return response()->json(['error' => 'You can only schedule sessions with your paired mentees or entrepreneurs.'], 403);
        }
        // Get the pairing
        $pairing = \App\Models\Pairing::whereIn('pairing_type', ['mentor_mentee', 'mentor_entrepreneur'])
            ->where(function ($q) use ($mentor, $request) {
                $q->where(function ($q2) use ($mentor, $request) {
                    $q2->where('user_one_id', $mentor->id)->where('user_two_id', $request->mentee_id);
                })->orWhere(function ($q2) use ($mentor, $request) {
                    $q2->where('user_one_id', $request->mentee_id)->where('user_two_id', $mentor->id);
                });
            })
            ->first();
        $sessionDateTime = $request->session_date . ' ' . $request->session_time;
        $session = \App\Models\MentorshipSession::create([
            'pairing_id' => $pairing->id,
            'scheduled_by' => $mentor->id,
            'scheduled_for' => $request->mentee_id,
            'date_time' => $sessionDateTime,
            'duration' => 60,
            'topic' => $request->topic,
            'notes' => $request->notes,
            'meeting_link' => $request->session_link,
            'status' => 'pending',
        ]);
        \Log::info('Mentor scheduled session:', $session->toArray());
        return response()->json(['success' => true, 'session_id' => $session->id]);
    }

    // Admin schedules a session between two paired users
    public function adminStore(Request $request)
    {
        $request->validate([
            'pairing_id' => 'required|exists:pairings,id',
            'date_time' => 'required|date|after:now',
            'duration' => 'required|integer|min:15|max:240',
            'topic' => 'nullable|string|max:255',
            'meeting_link' => 'nullable|url',
            'notes' => 'nullable|string',
        ]);
        $pairing = \App\Models\Pairing::with(['userOne', 'userTwo'])->findOrFail($request->pairing_id);
        // Decide who is scheduled_by and scheduled_for (default: userOne is mentor, userTwo is mentee)
        $scheduledBy = $pairing->user_one_id;
        $scheduledFor = $pairing->user_two_id;
        $session = \App\Models\MentorshipSession::create([
            'pairing_id' => $pairing->id,
            'scheduled_by' => $scheduledBy,
            'scheduled_for' => $scheduledFor,
            'date_time' => $request->date_time,
            'duration' => $request->duration,
            'topic' => $request->topic,
            'meeting_link' => $request->meeting_link,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);
        // Optionally notify both users here
        return redirect()->back()->with('success', 'Session scheduled successfully!');
    }
}
