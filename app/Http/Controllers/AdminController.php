<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\PitchEventProposal;
use App\Notifications\AccountApprovedNotification;
use App\Notifications\AccountRejectedNotification;
use Illuminate\Http\Request;
use App\Models\Pairing;
use App\Models\TrainingSession;
use App\Models\Resource;
use App\Models\PitchEvent;
use App\Models\MentorshipSession;
use App\Models\Content;
use App\Models\Feedback;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Real data for admin dashboard
        $totalUsers = \App\Models\User::count();
        $activePrograms = \App\Models\TrainingSession::where('date_time', '>=', now())->count();
        $pitchEvents = \App\Models\PitchEvent::where('status', 'published')->count();
        $successRate = 85; // Could be calculated from actual data

        // Get recent mentorship sessions
        $recentSessions = \App\Models\MentorshipSession::with(['pairing.userOne', 'pairing.userTwo', 'scheduledBy', 'scheduledFor'])
            ->whereHas('pairing.userOne')
            ->whereHas('pairing.userTwo')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get all types of pending approvals
        $pendingUsers = \App\Models\User::where('status', 'Pending')->take(3)->get();
        $pendingResources = \App\Models\Resource::where('is_approved', false)->take(3)->get();
        $pendingContent = \App\Models\Content::where('status', 'pending')->take(3)->get();
        $pendingFeedback = \App\Models\Feedback::where('status', 'pending')->take(3)->get();

        // Calculate detailed counts for dashboard
        $approvalCounts = [
            'users' => \App\Models\User::where('status', 'Pending')->count(),
            'resources' => \App\Models\Resource::where('is_approved', false)->count(),
            'content' => \App\Models\Content::where('status', 'pending')->count(),
            'feedback' => \App\Models\Feedback::where('status', 'pending')->count(),
            'proposals' => \App\Models\PitchEventProposal::where('status', 'pending')->count(),
        ];
        $totalPending = array_sum($approvalCounts);

        // Get pending proposals for dashboard
        $pendingProposals = \App\Models\PitchEventProposal::with('investor')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Combine all pending items for the dashboard
        $pendingApprovals = collect();
        
        // Add users
        foreach ($pendingUsers as $user) {
            $pendingApprovals->push([
                'type' => 'user',
                'item' => $user,
                'title' => $user->name,
                'subtitle' => $user->email,
                'description' => $user->organization ?? 'N/A',
                'time' => $user->created_at->diffForHumans(),
                'approve_route' => route('admin.approve', $user->id),
                'review_route' => route('admin.editUser', $user->id),
                'approve_method' => 'PATCH',
                'approve_text' => 'Approve User'
            ]);
        }

        // Add resources
        foreach ($pendingResources as $resource) {
            $pendingApprovals->push([
                'type' => 'resource',
                'item' => $resource,
                'title' => $resource->name,
                'subtitle' => $resource->bdsp ? $resource->bdsp->name : 'N/A',
                'description' => Str::limit($resource->description, 60),
                'time' => $resource->created_at->diffForHumans(),
                'approve_route' => route('admin.resources.approve', $resource->id),
                'review_route' => route('admin.resources'),
                'approve_method' => 'PATCH',
                'approve_text' => 'Approve Resource'
            ]);
        }

        // Add content
        foreach ($pendingContent as $content) {
            $pendingApprovals->push([
                'type' => 'content',
                'item' => $content,
                'title' => $content->title,
                'subtitle' => $content->type,
                'description' => Str::limit($content->description, 60),
                'time' => $content->created_at->diffForHumans(),
                'approve_route' => route('admin.contents.approve', $content->id),
                'review_route' => route('admin.content_management'),
                'approve_method' => 'PATCH',
                'approve_text' => 'Approve Content'
            ]);
        }

        // Add feedback
        foreach ($pendingFeedback as $feedback) {
            $pendingApprovals->push([
                'type' => 'feedback',
                'item' => $feedback,
                'title' => 'Feedback from ' . ($feedback->user ? $feedback->user->name : 'Unknown'),
                'subtitle' => $feedback->category ?? 'General',
                'description' => Str::limit($feedback->comments, 60),
                'time' => $feedback->created_at->diffForHumans(),
                'approve_route' => route('admin.feedback.update', $feedback->id),
                'review_route' => route('admin.feedback'),
                'approve_method' => 'PATCH',
                'approve_text' => 'Review Feedback'
            ]);
        }

        // Add proposals
        foreach ($pendingProposals as $proposal) {
            $pendingApprovals->push([
                'type' => 'proposal',
                'item' => $proposal,
                'title' => $proposal->title,
                'subtitle' => $proposal->investor ? $proposal->investor->name : 'Unknown Investor',
                'description' => Str::limit($proposal->description, 60),
                'time' => $proposal->created_at->diffForHumans(),
                'approve_route' => route('admin.proposals.show', $proposal->id),
                'review_route' => route('admin.proposals.index'),
                'approve_method' => 'GET',
                'approve_text' => 'Review Proposal'
            ]);
        }

        // Sort by priority and creation time (newest first)
        $pendingApprovals = $pendingApprovals->sortBy(function ($item) {
            // Priority: 1=users (highest), 2=resources, 3=content, 4=feedback, 5=proposals (lowest)
            $priority = [
                'user' => 1,
                'resource' => 2,
                'content' => 3,
                'feedback' => 4,
                'proposal' => 5
            ];
            return $priority[$item['type']] . '-' . $item['time'];
        })->take(5);

        // Get upcoming trainings
        $upcomingTrainings = \App\Models\TrainingSession::where('date_time', '>=', now())
            ->orderBy('date_time', 'asc')
            ->take(5)
            ->get();

        $recentActivity = [
            ['color' => 'green', 'text' => 'John Doe registered as Entrepreneur', 'time' => '2 hours ago'],
            ['color' => 'blue', 'text' => 'New program "Startup Accelerator" launched', 'time' => '1 day ago'],
            ['color' => 'purple', 'text' => 'Pitch event "Innovation Summit" announced', 'time' => '3 days ago'],
        ];

        $upcomingEvents = [
            ['title' => 'Investor Meetup', 'time' => '2025-07-10 10:00 AM', 'participants' => '25 Investors'],
            ['title' => 'Webinar: Funding Your Startup', 'time' => '2025-07-15 02:00 PM', 'participants' => '150 Attendees'],
        ];

        return view('admin.dashboard', compact('totalUsers', 'activePrograms', 'pitchEvents', 'successRate', 'recentActivity', 'upcomingEvents', 'recentSessions', 'pendingApprovals', 'upcomingTrainings', 'approvalCounts', 'totalPending'));
    }

    public function userManagement()
    {
        $allUsers = User::all(); // Fetch all users
        $users = User::where('is_approved', false)->get(); // Pending users
        $pairings = \App\Models\Pairing::with(['userOne', 'userTwo'])->get(); // Fetch all pairings with related users
        
        // Fetch startups for the Startup Profiles tab, eager load founder
        $startups = \App\Models\Startup::with('founder')->get();
        
        // Get entrepreneurs with business details for startup profiles
        $entrepreneurs = User::where('role', 'entrepreneur')
            ->whereNotNull('business_name')
            ->get();
            
        // Fetch startup info requests for the Info Requests tab
        $startupInfoRequests = \App\Models\StartupInfoRequest::with(['investor', 'startup'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.user-management', compact('allUsers', 'users', 'pairings', 'startups', 'entrepreneurs', 'startupInfoRequests'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $roles = ['admin', 'entrepreneur', 'bdsp', 'mentor', 'mentee', 'investor'];
        return view('admin.edit-user', compact('user', 'roles'));
    }

public function deleteMentorshipSession(MentorshipSession $session)
    {
        $session->delete();
        return redirect()->back()->with('success', 'Mentorship session deleted successfully.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $original = $user->getOriginal();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:255',
            'role' => 'required|in:admin,entrepreneur,bdsp,mentor,mentee,investor',
            'is_approved' => 'required|boolean',
            // Entrepreneur
            'business_name' => 'nullable|string|max:255',
            'sector' => 'nullable|string|max:255',
            'cac_number' => 'nullable|string|max:255',
            'funding_stage' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'entrepreneur_linkedin' => 'nullable|string|max:255',
            // BDSP
            'services_provided' => 'nullable|array',
            'services_provided.*' => 'string|in:business_model_review,financial_forecasting,valuation_support,pitch_deck_development,investor_pitch_coaching,capital_raising_strategy,term_sheets,due_diligence_preparation,legal_regulatory_advice,market_sizing,investor_identification,esg_impact_readiness,governance_board_structuring,mentoring_experienced_founders,investor_networks_demo_days,exit_strategy_planning,ip_asset_protection,growth_strategy_post_investment,storytelling_vision_alignment,one_on_one_coaching',
            'years_of_experience' => 'nullable|string|max:255',
            'organization' => 'nullable|string|max:255',
            'certifications' => 'nullable|string|max:255',
            'bdsp_linkedin' => 'nullable|string|max:255',
            // Investor
            'company' => 'nullable|string|max:255',
            'type_of_investor' => 'nullable|string|max:255',
            'interest_areas' => 'nullable|string|max:255',
            'investor_linkedin' => 'nullable|string|max:255',
        ]);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->is_approved = $validated['is_approved'];
        // Phone (unified field)
        $user->phone = $validated['phone'] ?? null;
        // Entrepreneur fields
        $user->business_name = $validated['business_name'] ?? null;
        $user->sector = $validated['sector'] ?? null;
        $user->cac_number = $validated['cac_number'] ?? null;
        $user->funding_stage = $validated['funding_stage'] ?? null;
        $user->website = $validated['website'] ?? null;
        $user->entrepreneur_linkedin = $validated['entrepreneur_linkedin'] ?? null;
        // BDSP fields
        $user->services_provided = $validated['services_provided'] ?? null;
        $user->years_of_experience = $validated['years_of_experience'] ?? null;
        $user->organization = $validated['organization'] ?? null;
        $user->certifications = $validated['certifications'] ?? null;
        $user->bdsp_linkedin = $validated['bdsp_linkedin'] ?? null;
        // Investor fields
        $user->company = $validated['company'] ?? null;
        $user->type_of_investor = $validated['type_of_investor'] ?? null;
        $user->interest_areas = $validated['interest_areas'] ?? null;
        $user->investor_linkedin = $validated['investor_linkedin'] ?? null;
        $user->save();
        // Detect changes
        $changes = [];
        foreach ($validated as $field => $newValue) {
            $oldValue = $original[$field] ?? null;
            if ($oldValue != $newValue) {
                $changes[$field] = ['old' => $oldValue, 'new' => $newValue];
            }
        }
        
        // Only send UserUpdatedNotification if user is already approved
        // This prevents duplicate notifications when approving a user after updating their profile
        if (!empty($changes) && $user->is_approved) {
            $user->notify(new \App\Notifications\UserUpdatedNotification($changes));
        }
        return redirect()->route('admin.user-management')->with('success', 'User updated successfully.');
    }

    public function approve($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user->is_approved = true;
        $user->save();

        // Send approval notification to user
        $user->notify(new AccountApprovedNotification());

        return redirect()->back()->with('success', 'User approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user->is_approved = false;
        $user->save();

        // Get rejection reason from request (optional)
        $reason = $request->input('reason');

        // Send rejection notification to user with reason
        $user->notify(new AccountRejectedNotification($reason));

        return redirect()->back()->with('success', 'User rejected successfully.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    // Pairings Management
    public function createPairing()
    {
        // Fetch users by role for pairing selection
        $mentors = User::where('role', 'mentor')->where('is_approved', true)->get();
        $mentees = User::where('role', 'mentee')->where('is_approved', true)->get();
        $bdsp = User::where('role', 'bdsp')->where('is_approved', true)->get();
        $entrepreneurs = User::where('role', 'entrepreneur')->where('is_approved', true)->get();
        $investors = User::where('role', 'investor')->where('is_approved', true)->get();
        return view('admin.pairings.create', compact('mentors', 'mentees', 'bdsp', 'entrepreneurs', 'investors'));
    }

    public function storePairing(Request $request)
    {
\Illuminate\Support\Facades\Log::info('Pairing: Received request', $request->all());
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'pairing_type' => 'required|in:mentor_mentee,bdsp_entrepreneur,investor_entrepreneur,mentor_entrepreneur',
            'user_one_id' => 'required|exists:users,id|different:user_two_id',
            'user_two_id' => 'required|exists:users,id',
        ], [
            'user_one_id.different' => 'You cannot pair a user with themselves.',
        ]);
        if ($validator->fails()) {
\Illuminate\Support\Facades\Log::warning('Pairing: Validation failed', $validator->errors()->toArray());
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if (Pairing::isPaired($request->user_one_id, $request->user_two_id, $request->pairing_type)) {
            $msg = 'These users are already paired for this type.';
            \Illuminate\Support\Facades\Log::info('Pairing: Already paired', [
                'user_one_id' => $request->user_one_id,
                'user_two_id' => $request->user_two_id,
                'pairing_type' => $request->pairing_type
            ]);
            if ($request->expectsJson()) {
                return response()->json(['errors' => ['pairing' => [$msg]]], 422);
            }
            return redirect()->back()->with('error', $msg);
        }
        try {
            $pairing = Pairing::create([
                'user_one_id' => $request->user_one_id,
                'user_two_id' => $request->user_two_id,
                'pairing_type' => $request->pairing_type,
            ]);
\Illuminate\Support\Facades\Log::info('Pairing: Created successfully', ['pairing_id' => $pairing->id]);
            // Notify both users (except admin users)
            $userOne = \App\Models\User::find($request->user_one_id);
            $userTwo = \App\Models\User::find($request->user_two_id);
            
            // Only send notifications to non-admin users
            if ($userOne->role !== 'admin') {
                $userOne->notify(new \App\Notifications\UserPairedNotification($userTwo, $request->pairing_type));
            }
            if ($userTwo->role !== 'admin') {
                $userTwo->notify(new \App\Notifications\UserPairedNotification($userOne, $request->pairing_type));
            }
\Illuminate\Support\Facades\Log::info('Pairing: Notifications sent');
        } catch (\Exception $e) {
\Illuminate\Support\Facades\Log::error('Pairing: Exception occurred', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            if ($request->expectsJson()) {
                return response()->json(['errors' => ['exception' => [$e->getMessage()]]], 500);
            }
            return redirect()->back()->with('error', 'An error occurred while creating the pairing: ' . $e->getMessage());
        }
        if ($request->expectsJson()) {
            return response()->json(['success' => 'Pairing created successfully.']);
        }
        return redirect()->route('admin.user-management', ['tab' => 'pairings'])->with('success', 'Pairing created successfully.');
    }

    public function destroyPairing(Pairing $pairing)
    {
        $pairing->delete();
        return redirect()->route('admin.user-management', ['tab' => 'pairings'])->with('success', 'Pairing removed successfully.');
    }

    // Training Schedules Management
    public function trainingPrograms()
    {
        $sessions = TrainingSession::orderBy('date_time', 'desc')->get();
        return view('admin.training_programs.index', compact('sessions'));
    }

    public function createTraining()
    {
        $roles = ['entrepreneur', 'bdsp', 'mentor', 'mentee', 'investor'];
        return view('admin.training_programs.create', compact('roles'));
    }

    public function storeTraining(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_time' => 'required|date',
            'duration' => 'required|integer|min:1',
            'trainer' => 'required|string|max:255',
            'target_roles' => 'required|array|min:1',
            'target_roles.*' => 'in:entrepreneur,bdsp,mentor,mentee,investor',
            'meeting_link' => 'nullable|url',
        ]);
        $session = TrainingSession::create([
            'title' => $request->title,
            'description' => $request->description,
            'date_time' => $request->date_time,
            'duration' => $request->duration,
            'trainer' => $request->trainer,
            'target_roles' => json_encode($request->target_roles),
            'meeting_link' => $request->meeting_link,
        ]);
        // Notify users with matching roles
        $roles = $request->target_roles;
        $users = \App\Models\User::whereIn('role', $roles)->where('is_approved', true)->get();
        foreach ($users as $user) {
            $user->notify(new \App\Notifications\TrainingSessionNotification($session));
        }
        return redirect()->route('admin.training_programs')->with('success', 'Training session created successfully.');
    }

    public function editTraining($id)
    {
        $session = TrainingSession::findOrFail($id);
        $roles = ['entrepreneur', 'bdsp', 'mentor', 'mentee', 'investor'];
        return view('admin.training_programs.edit', compact('session', 'roles'));
    }

    public function updateTraining(Request $request, $id)
    {
        $session = TrainingSession::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_time' => 'required|date',
            'duration' => 'required|integer|min:1',
            'trainer' => 'required|string|max:255',
            'target_roles' => 'required|array|min:1',
            'target_roles.*' => 'in:entrepreneur,bdsp,mentor,mentee,investor',
            'meeting_link' => 'nullable|url',
        ]);
        $session->update([
            'title' => $request->title,
            'description' => $request->description,
            'date_time' => $request->date_time,
            'duration' => $request->duration,
            'trainer' => $request->trainer,
            'target_roles' => json_encode($request->target_roles),
            'meeting_link' => $request->meeting_link,
        ]);
        // TODO: Notify users of changes if needed
        return redirect()->route('admin.training_programs')->with('success', 'Training session updated successfully.');
    }

    public function destroyTraining($id)
    {
        $session = TrainingSession::findOrFail($id);
        $session->delete();
        return redirect()->route('admin.training_programs')->with('success', 'Training session deleted successfully.');
    }

    // Admin: View all mentorship sessions
    public function mentorshipSessions()
    {
        $sessions = \App\Models\MentorshipSession::with(['pairing.userOne', 'pairing.userTwo', 'scheduledBy', 'scheduledFor'])
            ->whereHas('pairing.userOne')
            ->whereHas('pairing.userTwo')
            ->orderBy('date_time', 'desc')
            ->get();
        return view('admin.mentorship_sessions.index', compact('sessions'));
    }
    
    public function clearAllSessions()
    {
        \App\Models\MentorshipSession::whereDoesntHave('pairing.userOne')
            ->orWhereDoesntHave('pairing.userTwo')
            ->delete();
            
        return back()->with('success', 'All orphaned mentorship sessions have been cleared.');
    }

    public function destroyMentorshipSession($id)
    {
        $session = \App\Models\MentorshipSession::findOrFail($id);
        $session->delete();
        return back()->with('success', 'Mentorship session deleted successfully.');
    }

    public function mentorship()
    {
        $pairings = \App\Models\Pairing::with(['userOne', 'userTwo'])->get();
        $sessions = \App\Models\MentorshipSession::with(['pairing.userOne', 'pairing.userTwo', 'scheduledBy', 'scheduledFor'])
            ->orderBy('date_time', 'desc')->get();
        return view('admin.mentorship', compact('pairings', 'sessions'));
    }

    public function feedback()
    {
        $allFeedback = \App\Models\Feedback::latest()->get();
        return view('admin.feedback', compact('allFeedback'));
    }

    public function updateFeedbackStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,resolved',
        ]);
        $feedback = \App\Models\Feedback::findOrFail($id);
        $feedback->status = $request->status;
        $feedback->save();
        return back()->with('success', 'Feedback status updated.');
    }

    public function destroyFeedback($id)
    {
        $feedback = \App\Models\Feedback::findOrFail($id);
        $feedback->delete();
        return back()->with('success', 'Feedback deleted successfully.');
    }

    // Admin: Learning Resources Moderation
    public function resources(Request $request)
    {
        $status = $request->query('status');
        $query = Resource::with('bdsp')->orderByDesc('created_at');
        if ($status === 'approved') {
            $query->where('is_approved', true);
        } elseif ($status === 'pending') {
            $query->where('is_approved', false);
        }
        $resources = $query->paginate(20);

        // Ensure all required variables are passed
        $contents = collect(); // Empty collection for now
        $pendingPitches = collect();

        $approvedPitches = collect();
        $rejectedPitches = collect();
        $reviewedPitches = collect();

        $categories = DB::table('categories')->get(); // Fetch all categories

        return view('admin.content_management', compact(
            'resources', 'status', 'contents', 'categories',
            'pendingPitches', 'approvedPitches', 'rejectedPitches', 'reviewedPitches'
        ));
    }

    public function approveResource($id)
    {
        $resource = Resource::findOrFail($id);
        $resource->is_approved = true;
        $resource->save();
        return back()->with('success', 'Resource approved successfully.');
    }

    public function rejectResource($id)
    {
        $resource = Resource::findOrFail($id);
        $resource->is_approved = false;
        $resource->save();
        return back()->with('success', 'Resource rejected successfully.');
    }

    public function destroyResource($id)
    {
        $resource = Resource::findOrFail($id);
        $resource->delete();
        return back()->with('success', 'Resource deleted successfully.');
    }

    // Admin: Content Moderation
    public function approveContent($id)
    {
        $content = Content::findOrFail($id);
        $content->status = 'published';
        $content->save();
        return back()->with('success', 'Content approved successfully.');
    }

    public function rejectContent($id)
    {
        $content = Content::findOrFail($id);
        $content->update(['status' => 'rejected']);
        return back()->with('success', 'Content rejected successfully.');
    }

    // Pitch Event Proposals Management
    public function proposals(Request $request)
    {
        $query = \App\Models\PitchEventProposal::with(['investor', 'reviewer'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by event type
        if ($request->has('event_type') && $request->event_type !== '') {
            $query->where('event_type', $request->event_type);
        }

        // Filter by target sector
        if ($request->has('target_sector') && $request->target_sector !== '') {
            $query->where('target_sector', $request->target_sector);
        }

        $proposals = $query->paginate(15);

        // Get counts for different statuses
        $counts = [
            'pending' => \App\Models\PitchEventProposal::where('status', 'pending')->count(),
            'approved' => \App\Models\PitchEventProposal::where('status', 'approved')->count(),
            'rejected' => \App\Models\PitchEventProposal::where('status', 'rejected')->count(),
            'requested_changes' => \App\Models\PitchEventProposal::where('status', 'requested_changes')->count(),
        ];

        return view('admin.pitch_event_proposals.index', compact('proposals', 'counts'));
    }

    public function showProposal(\App\Models\PitchEventProposal $proposal)
    {
        $proposal->load(['investor', 'reviewer', 'approvedEvent']);
        
        return view('admin.pitch_event_proposals.show', compact('proposal'));
    }

    public function approveProposal(Request $request, \App\Models\PitchEventProposal $proposal)
    {
        $request->validate([
            'admin_feedback' => 'nullable|string|max:1000',
        ]);

        try {
            // Create the pitch event from the proposal
            $event = PitchEvent::create([
                'title' => $proposal->title,
                'description' => $proposal->description,
                'date_time' => $proposal->proposed_date ? 
                    $proposal->proposed_date->setTimeFrom($proposal->proposed_time ?? now()) : 
                    now()->addDays(30),
                'location' => $proposal->proposed_location ?? 'TBD',
                'max_participants' => $proposal->max_participants,
                'status' => 'published',
                'event_type' => $proposal->event_type,
                'target_sector' => $proposal->target_sector,
                'target_stage' => $proposal->target_stage,
                'is_virtual' => $proposal->is_virtual,
                'virtual_platform' => $proposal->virtual_platform,
                'additional_info' => $proposal->additional_requirements,
                'created_by' => auth()->user()->id,
            ]);

            // Update the proposal
            $proposal->update([
                'status' => 'approved',
                'admin_feedback' => $request->admin_feedback,
                'reviewed_by' => (auth()->user() instanceof \App\Models\User) ? auth()->id() : null,
                'reviewed_at' => now(),
                'approved_event_id' => $event->id,
            ]);

            // Notify the investor
            $proposal->investor->notify(new \App\Notifications\ProposalApprovedNotification($proposal));

            Log::info('Pitch event proposal approved', [
                'proposal_id' => $proposal->id,
                'event_id' => $event->id,
                'admin_id' => (auth()->user() instanceof \App\Models\User) ? auth()->id() : null,
            ]);

            return redirect()->route('admin.proposals.index')
                ->with('success', 'Proposal approved and event created successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to approve proposal', [
                'proposal_id' => $proposal->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to approve proposal. Please try again.');
        }
    }

    public function rejectProposal(Request $request, \App\Models\PitchEventProposal $proposal)
    {
        $request->validate([
            'admin_feedback' => 'required|string|max:1000',
        ]);

        try {
            $proposal->update([
                'status' => 'rejected',
                'admin_feedback' => $request->admin_feedback,
                'reviewed_by' => (auth()->user() instanceof \App\Models\User) ? auth()->id() : null,
                'reviewed_at' => now(),
            ]);

            // Notify the investor
            $proposal->investor->notify(new \App\Notifications\ProposalRejectedNotification($proposal));

            Log::info('Pitch event proposal rejected', [
                'proposal_id' => $proposal->id,
                'admin_id' => (auth()->user() instanceof \App\Models\User) ? auth()->id() : null,
            ]);

            return redirect()->route('admin.proposals.index')
                ->with('success', 'Proposal rejected successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to reject proposal', [
                'proposal_id' => $proposal->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to reject proposal. Please try again.');
        }
    }

    public function requestChanges(Request $request, \App\Models\PitchEventProposal $proposal)
    {
        $request->validate([
            'admin_feedback' => 'required|string|max:1000',
        ]);

        try {
            $proposal->update([
                'status' => 'requested_changes',
                'admin_feedback' => $request->admin_feedback,
                'reviewed_by' => (auth()->user() instanceof \App\Models\User) ? auth()->id() : null,
                'reviewed_at' => now(),
            ]);

            // Notify the investor
            $proposal->investor->notify(new \App\Notifications\ProposalChangesRequestedNotification($proposal));

            Log::info('Pitch event proposal changes requested', [
                'proposal_id' => $proposal->id,
                'admin_id' => (auth()->user() instanceof \App\Models\User) ? auth()->id() : null,
            ]);

            return redirect()->route('admin.proposals.index')
                ->with('success', 'Changes requested for proposal successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to request changes for proposal', [
                'proposal_id' => $proposal->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to request changes. Please try again.');
        }
    }

    /**
     * Display all access requests for admin management
     */
    public function accessRequests()
    {
        $accessRequests = \App\Models\StartupAccessRequest::with(['investor', 'startup'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.access-requests', compact('accessRequests'));
    }

    /**
     * Approve an access request
     */
    public function approveAccessRequest(\App\Models\StartupAccessRequest $accessRequest)
    {
        $accessRequest->status = 'approved';
        $accessRequest->save();
        
        // Notify the investor
        $accessRequest->investor->notify(new \App\Notifications\AccessRequestApproved($accessRequest));
        
        return redirect()->back()->with('success', 'Access request approved successfully.');
    }

    /**
     * Reject an access request
     */
    public function rejectAccessRequest(Request $request, \App\Models\StartupAccessRequest $accessRequest)
    {
        $accessRequest->status = 'rejected';
        $accessRequest->response_message = $request->response_message ?? 'Request rejected by admin.';
        $accessRequest->save();
        
        // Notify the investor
        $accessRequest->investor->notify(new \App\Notifications\AccessRequestRejected($accessRequest));
        
        return redirect()->back()->with('success', 'Access request rejected successfully.');
    }
}
