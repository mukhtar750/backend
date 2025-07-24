<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\MentorshipSession;
use App\Models\Message;
use App\Models\Pairing;

class MentorDashboardController extends Controller
{
    public function index()
    {
        $mentor = Auth::user();
        // Get all pairings where this user is a mentor
        $pairings = Pairing::whereIn('pairing_type', ['mentor_mentee', 'mentor_entrepreneur'])
            ->where(function ($q) use ($mentor) {
                $q->where('user_one_id', $mentor->id)->orWhere('user_two_id', $mentor->id);
            })
            ->with(['userOne', 'userTwo'])
            ->get();
        // Collect the other user as the mentee
        $mentees = $pairings->map(function ($pairing) use ($mentor) {
            return $pairing->user_one_id == $mentor->id ? $pairing->userTwo : $pairing->userOne;
        });
        // Get upcoming sessions for this mentor
        $upcomingSessions = MentorshipSession::where(function ($q) use ($mentor) {
                $q->where('scheduled_by', $mentor->id)
                  ->orWhere('scheduled_for', $mentor->id);
            })
            ->where('date_time', '>=', now())
            ->orderBy('date_time')
            ->with(['pairing.userOne', 'pairing.userTwo', 'scheduledBy', 'scheduledFor'])
            ->get();
        // Get past sessions for this mentor
        $pastSessions = MentorshipSession::where(function ($q) use ($mentor) {
                $q->where('scheduled_by', $mentor->id)
                  ->orWhere('scheduled_for', $mentor->id);
            })
            ->where('date_time', '<', now())
            ->orderByDesc('date_time')
            ->with(['pairing.userOne', 'pairing.userTwo', 'scheduledBy', 'scheduledFor'])
            ->get();
        // Get recent messages: get mentor's conversations, take latest message from each, sort and limit
        $conversations = $mentor->getConversations();
        $messages = $conversations->map(function ($conv) {
            return $conv->latestMessage;
        })->filter()->sortByDesc('created_at')->take(5);
        // Example stats
        $stats = [
            'mentees' => $mentees->count(),
            'upcoming_sessions' => $upcomingSessions->count(),
            'unread_messages' => $messages->where('is_read', false)->count(),
        ];
        $notificationsCount = 0; // Placeholder, implement as needed
        return view('dashboard.mentor', compact('mentor', 'mentees', 'upcomingSessions', 'pastSessions', 'messages', 'stats', 'notificationsCount'));
    }
} 