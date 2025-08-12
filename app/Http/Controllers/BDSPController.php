<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pairing;
use App\Models\MentorshipSession;
use App\Notifications\SessionScheduledNotification;
use App\Notifications\AdminSessionScheduledNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BDSPController extends Controller
{
    public function dashboard()
    {
        $bdsp = Auth::user();
        
        // Get paired entrepreneurs (mentees)
        $pairedMentees = $this->getPairedMentees($bdsp->id);
        
        // Get upcoming sessions
        $upcomingSessions = $this->getUpcomingSessions($bdsp->id);
        
        // Get stats
        $stats = $this->getStats($bdsp->id);
        
        // Get recent resources for quick sharing
        $recentResources = $bdsp->resources()->latest()->take(3)->get();
        
        return view('dashboard.bdsp', compact('pairedMentees', 'upcomingSessions', 'stats', 'recentResources'));
    }
    
    private function getPairedMentees($bdspId)
    {
        return Pairing::where('pairing_type', 'bdsp_entrepreneur')
            ->where(function ($query) use ($bdspId) {
                $query->where('user_one_id', $bdspId)
                      ->orWhere('user_two_id', $bdspId);
            })
            ->with(['userOne', 'userTwo'])
            ->get()
            ->map(function ($pairing) use ($bdspId) {
                // Return the entrepreneur (not the BDSP)
                return $pairing->user_one_id == $bdspId ? $pairing->userTwo : $pairing->userOne;
            });
    }
    
    private function getUpcomingSessions($bdspId)
    {
        // Get sessions where BDSP is involved (either scheduled by them or for them)
        return MentorshipSession::where(function ($query) use ($bdspId) {
            $query->where('scheduled_by', $bdspId)
                  ->orWhere('scheduled_for', $bdspId);
        })
        ->where('date_time', '>=', now())
        ->where('status', '!=', 'cancelled')
        ->with(['pairing.userOne', 'pairing.userTwo', 'scheduledBy', 'scheduledFor'])
        ->orderBy('date_time', 'asc')
        ->get()
        ->map(function ($session) use ($bdspId) {
            // Determine the other party (not the BDSP)
            $otherUser = $session->scheduled_by == $bdspId ? $session->scheduledFor : $session->scheduledBy;
            $session->other_user = $otherUser;
            return $session;
        });
    }
    
    private function getStats($bdspId)
    {
        $pairedMentees = $this->getPairedMentees($bdspId);
        $upcomingSessions = $this->getUpcomingSessions($bdspId);
        
        // Get sessions this month
        $sessionsThisMonth = MentorshipSession::where(function ($query) use ($bdspId) {
            $query->where('scheduled_by', $bdspId)
                  ->orWhere('scheduled_for', $bdspId);
        })
        ->whereMonth('date_time', now()->month)
        ->whereYear('date_time', now()->year)
        ->count();
        
        // Get actual resource count
        $resourcesUploaded = \App\Models\Resource::where('bdsp_id', $bdspId)->count();
        
        // Get actual average rating from feedback
        $avgRating = \App\Models\Feedback::where('target_type', 'user')
            ->where('target_id', $bdspId)
            ->avg('rating') ?? 4.8;
        
        return [
            'active_mentees' => $pairedMentees->count(),
            'sessions_this_month' => $sessionsThisMonth,
            'resources_uploaded' => $resourcesUploaded,
            'avg_rating' => round($avgRating, 1),
        ];
    }
    
    public function mentees()
    {
        $bdsp = Auth::user();
        $pairedMentees = $this->getPairedMentees($bdsp->id);
        
        // Get all sessions for this BDSP
        $allSessions = MentorshipSession::where(function ($query) use ($bdsp) {
            $query->where('scheduled_by', $bdsp->id)
                  ->orWhere('scheduled_for', $bdsp->id);
        })
        ->with(['pairing.userOne', 'pairing.userTwo', 'scheduledBy', 'scheduledFor'])
        ->orderBy('date_time', 'desc')
        ->get()
        ->map(function ($session) use ($bdsp) {
            // Determine the other party (not the BDSP)
            $otherUser = $session->scheduled_by == $bdsp->id ? $session->scheduledFor : $session->scheduledBy;
            $session->other_user = $otherUser;
            return $session;
        });
        
        // Get sessions by status
        $scheduledSessions = $allSessions->where('status', 'pending')->where('date_time', '>=', now());
        $completedSessions = $allSessions->where('status', 'completed');
        
        // Calculate stats
        $totalSessions = $allSessions->count();
        $scheduledCount = $scheduledSessions->count();
        $completedCount = $completedSessions->count();
        $avgRating = 4.8; // This would come from feedback table in real implementation
        
        return view('bdsp.mentees', compact(
            'pairedMentees', 
            'allSessions', 
            'scheduledSessions', 
            'completedSessions',
            'totalSessions',
            'scheduledCount',
            'completedCount',
            'avgRating'
        ));
    }
    
    public function scheduleSessionPage()
    {
        $bdsp = Auth::user();
        $pairedMentees = $this->getPairedMentees($bdsp->id);
        
        // Get recent sessions (last 10)
        $recentSessions = MentorshipSession::where(function ($query) use ($bdsp) {
            $query->where('scheduled_by', $bdsp->id)
                  ->orWhere('scheduled_for', $bdsp->id);
        })
        ->with(['pairing.userOne', 'pairing.userTwo', 'scheduledBy', 'scheduledFor'])
        ->orderBy('date_time', 'desc')
        ->limit(10)
        ->get();
        
        return view('dashboard.bdsp-schedule-session', compact('pairedMentees', 'recentSessions'));
    }

    public function scheduleSession(Request $request)
    {
        \Log::info('BDSP Session Creation Request:', $request->all());
        
        try {
            $request->validate([
                'mentee_id' => 'required|exists:users,id',
                'session_date' => 'required|date|after_or_equal:today',
                'session_time' => 'required',
                'session_type' => 'required|in:1-on-1,group',
                'topic' => 'required|string|max:255',
                'notes' => 'nullable|string',
                'session_link' => 'nullable|url',
            ]);
            
            \Log::info('Validation passed');
            
            // Check if the mentee is actually paired with this BDSP
            $bdsp = Auth::user();
            \Log::info('BDSP User:', ['id' => $bdsp->id, 'name' => $bdsp->name]);
            
            $isPaired = Pairing::where('pairing_type', 'bdsp_entrepreneur')
                ->where('user_one_id', $bdsp->id)
                ->where('user_two_id', $request->mentee_id)
                ->exists();
                
            if (!$isPaired) {
                $isPaired = Pairing::where('pairing_type', 'bdsp_entrepreneur')
                    ->where('user_one_id', $request->mentee_id)
                    ->where('user_two_id', $bdsp->id)
                    ->exists();
            }
            
            \Log::info('Pairing check result:', ['is_paired' => $isPaired]);
                
            if (!$isPaired) {
                return response()->json(['error' => 'You can only schedule sessions with your paired mentees.'], 403);
            }
            
            // Get the pairing
            $pairing = Pairing::where('pairing_type', 'bdsp_entrepreneur')
                ->where('user_one_id', $bdsp->id)
                ->where('user_two_id', $request->mentee_id)
                ->first();
                
            if (!$pairing) {
                $pairing = Pairing::where('pairing_type', 'bdsp_entrepreneur')
                    ->where('user_one_id', $request->mentee_id)
                    ->where('user_two_id', $bdsp->id)
                    ->first();
            }
            
            \Log::info('Pairing found:', ['pairing_id' => $pairing->id ?? 'null']);
            
            // Create the session
            $sessionDateTime = $request->session_date . ' ' . $request->session_time;
            
            $session = MentorshipSession::create([
                'pairing_id' => $pairing->id,
                'scheduled_by' => $bdsp->id,
                'scheduled_for' => $request->mentee_id,
                'date_time' => $sessionDateTime,
                'duration' => 60, // Default 60 minutes
                'topic' => $request->topic,
                'notes' => $request->notes,
                'meeting_link' => $request->session_link,
                'status' => 'pending',
            ]);
            
            \Log::info('Session created successfully:', ['session_id' => $session->id]);
            
            // Send notification to the mentee
            // $mentee = User::find($request->mentee_id);
            // $mentee->notify(new SessionScheduledNotification($session, $bdsp));
            
            // Send notification to admin
            // $adminUsers = User::where('role', 'admin')->get();
            // foreach ($adminUsers as $admin) {
            //     $admin->notify(new AdminSessionScheduledNotification($session, $bdsp, $mentee));
            // }
            
            \Log::info('Notifications skipped for testing');
            
            return response()->json([
                'success' => true, 
                'message' => 'Session scheduled successfully!',
                'session' => $session
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', ['errors' => $e->errors()]);
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Session creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'Failed to schedule session: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cancelSession(MentorshipSession $session)
    {
        $bdsp = Auth::user();
        
        // Check if the BDSP is involved in this session
        if ($session->scheduled_by !== $bdsp->id && $session->scheduled_for !== $bdsp->id) {
            return response()->json(['error' => 'You can only cancel sessions you are involved in.'], 403);
        }
        
        $session->update(['status' => 'cancelled']);
        
        return response()->json([
            'success' => true,
            'message' => 'Session cancelled successfully!'
        ]);
    }

    public function completeSession(MentorshipSession $session)
    {
        // Check if the current user is authorized to complete this session
        if ($session->scheduled_by !== Auth::id() && $session->scheduled_for !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to complete this session.');
        }

        $session->status = 'completed';
        $session->save();

        return redirect()->back()->with('success', 'Session marked as completed.');
    }

    public function rescheduleSession(Request $request, MentorshipSession $session)
    {
        $bdsp = Auth::user();
        
        // Check if the BDSP is involved in this session
        if ($session->scheduled_by !== $bdsp->id && $session->scheduled_for !== $bdsp->id) {
            return response()->json(['error' => 'You can only reschedule sessions you are involved in.'], 403);
        }
        
        // Validate the request
        $request->validate([
            'new_date_time' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);
        
        // Update the session
        $session->update([
            'date_time' => $request->new_date_time,
            'notes' => $request->notes ?? $session->notes,
            'status' => 'pending', // Reset to pending for the new date
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Session rescheduled successfully!'
        ]);
    }

    public function reports()
    {
        $bdsp = Auth::user();
        
        // Get paired mentees
        $pairedMentees = $this->getPairedMentees($bdsp->id);
        
        // Get sessions count
        $sessionsCount = MentorshipSession::where(function($q) use ($bdsp) {
            $q->where('scheduled_by', $bdsp->id)->orWhere('scheduled_for', $bdsp->id);
        })->count();
        
        // Get feedback received
        $feedbackReceived = \App\Models\Feedback::where('target_type', 'user')
            ->where('target_id', $bdsp->id)
            ->get();
        $avgRating = $feedbackReceived->count() > 0 ? round($feedbackReceived->avg('rating'), 1) : 0;
        
        // Get resources count
        $resourcesCount = \App\Models\Resource::where('user_id', $bdsp->id)->count();
        
        // Get recent feedback for display
        $recentFeedback = \App\Models\Feedback::where('target_type', 'user')
            ->where('target_id', $bdsp->id)
            ->with('user')
            ->latest()
            ->take(6)
            ->get();
        
        // Get resources for engagement section
        $resources = \App\Models\Resource::where('user_id', $bdsp->id)->get();
        
        return view('bdsp.reports', compact(
            'pairedMentees',
            'sessionsCount', 
            'avgRating',
            'resourcesCount',
            'recentFeedback',
            'resources'
        ));
    }
} 