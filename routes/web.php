<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvestorRegisterController;
use App\Http\Controllers\BDSPRegisterController;
use App\Http\Controllers\EntrepreneurRegisterController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\PracticePitchController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PitchController;
use App\Http\Controllers\VoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::redirect('/register', '/register-role');
// Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/picture', [\App\Http\Controllers\ProfileController::class, 'removeProfilePicture'])->name('profile.remove-picture');
    Route::get('/profile/picture', [\App\Http\Controllers\ProfileController::class, 'getProfilePicture'])->name('profile.get-picture');
});

// Notification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/recent', [NotificationController::class, 'recent'])->name('notifications.recent');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');
    
    // Test route for creating notifications
    Route::post('/test/create-notification', [\App\Http\Controllers\TestController::class, 'createTestNotification'])->name('test.createNotification');
});

// Messaging Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [\App\Http\Controllers\MessageController::class, 'create'])->middleware(['auth'])->name('messages.create');
    Route::get('/messages/{conversation}', [\App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/conversations', [\App\Http\Controllers\MessageController::class, 'getConversations'])->name('messages.conversations');
    Route::get('/messages/{conversation}/messages', [\App\Http\Controllers\MessageController::class, 'getMessages'])->name('messages.getMessages');
    Route::post('/messages/{conversation}/mark-as-read', [\App\Http\Controllers\MessageController::class, 'markAsRead'])->name('messages.markAsRead');
    Route::get('/messages/unread-count', [\App\Http\Controllers\MessageController::class, 'getUnreadCount'])->name('messages.unreadCount');
    Route::get('/messages/{message}/download', [\App\Http\Controllers\MessageController::class, 'downloadFile'])->name('messages.download');
    Route::delete('/messages/{message}', [\App\Http\Controllers\MessageController::class, 'deleteMessage'])->name('messages.delete');
});

// Group Chat Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/groups/{slug}', [\App\Http\Controllers\GroupController::class, 'show'])->name('groups.show');
    Route::post('/groups/{slug}/messages', [\App\Http\Controllers\GroupController::class, 'storeMessage'])->name('groups.messages.store');
    Route::get('/groups/{slug}/messages', [\App\Http\Controllers\GroupController::class, 'getMessages'])->name('groups.messages.get');
});

// BDSP and Mentor specific routes
Route::middleware(['auth', 'role:bdsp,mentor'])->group(function () {
    Route::get('/mentor/dashboard', [\App\Http\Controllers\MentorDashboardController::class, 'index'])->middleware(['auth'])->name('mentor.dashboard');
    Route::get('/mentor/practice-pitches', [PracticePitchController::class, 'mentorIndex'])->name('mentor.practice-pitches.index');
    Route::post('/mentor/practice-pitches/{id}/feedback', [PracticePitchController::class, 'feedback'])->name('mentor.practice-pitches.feedback');
    Route::get('/training-sessions', [\App\Http\Controllers\TrainingSessionController::class, 'index'])->name('bdsp.training-sessions.index');
});

// Admin specific routes
Route::middleware(['auth', 'role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/user-management', [AdminController::class, 'userManagement'])->name('user-management');
    Route::get('/user-management/{id}/edit', [AdminController::class, 'editUser'])->name('editUser');
    Route::put('/user-management/{id}', [AdminController::class, 'updateUser'])->name('updateUser');
    
    // Startup Profile Management
    Route::patch('/startups/{startup}/approve', [\App\Http\Controllers\StartupController::class, 'approve'])->name('startups.approve');
    Route::patch('/startups/{startup}/reject', [\App\Http\Controllers\StartupController::class, 'reject'])->name('startups.reject');
    Route::delete('/startups/{startup}', [\App\Http\Controllers\AdminStartupController::class, 'destroy'])->name('startups.destroy');
    
    // Task Management
    Route::post('/tasks', [\App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'destroy'])->name('tasks.destroy');

    // Admin Training Schedules CRUD
    Route::get('/training-programs', [AdminController::class, 'trainingPrograms'])->name('training_programs');
    Route::get('/training-programs/create', [AdminController::class, 'createTraining'])->name('training_programs.create');
    Route::post('/training-programs', [AdminController::class, 'storeTraining'])->name('training_programs.store');
    Route::get('/training-programs/{id}/edit', [AdminController::class, 'editTraining'])->name('training_programs.edit');
    Route::put('/training-programs/{id}', [AdminController::class, 'updateTraining'])->name('training_programs.update');
    Route::delete('/training-programs/{id}', [AdminController::class, 'destroyTraining'])->name('training_programs.destroy');

    Route::get('/mentorship', [AdminController::class, 'mentorship'])->name('mentorship');

    Route::get('/mentorship-sessions', [AdminController::class, 'mentorshipSessions'])->name('mentorship_sessions');
    Route::delete('/mentorship-sessions/{session}', [AdminController::class, 'destroyMentorshipSession'])->name('mentorship_sessions.destroy');

    // Mentorship Forms Management
    Route::prefix('mentorship/forms')->name('mentorship.forms.')->group(function () {
        Route::get('/admin-dashboard', [App\Http\Controllers\MentorshipFormController::class, 'adminDashboard'])->name('admin_dashboard');
        Route::get('/submissions', [App\Http\Controllers\MentorshipFormController::class, 'listSubmissions'])->name('list_submissions');
        Route::get('/submissions/{submission}', [App\Http\Controllers\MentorshipFormController::class, 'showSubmission'])->name('show_submission');
        Route::get('/submissions/{submission}/review', [App\Http\Controllers\MentorshipFormController::class, 'reviewSubmission'])->name('review_submission');
        Route::post('/submissions/{submission}/review', [App\Http\Controllers\MentorshipFormController::class, 'storeReview'])->name('store_review');
        Route::get('/submissions/{submission}/download', [App\Http\Controllers\MentorshipFormController::class, 'downloadSubmission'])->name('download_submission');
    });

    // Pitch Event Proposals Management (MOVED UP)
    Route::get('/pitch-events/proposals', [AdminController::class, 'proposals'])->name('proposals.index');
    Route::get('/pitch-events/proposals/{proposal}', [AdminController::class, 'showProposal'])->name('proposals.show');
    Route::patch('/pitch-events/proposals/{proposal}/approve', [AdminController::class, 'approveProposal'])->name('proposals.approve');
    Route::patch('/pitch-events/proposals/{proposal}/reject', [AdminController::class, 'rejectProposal'])->name('proposals.reject');
    Route::patch('/pitch-events/proposals/{proposal}/request-changes', [AdminController::class, 'requestChanges'])->name('proposals.request-changes');

    // Pitch Events Management (RESOURCE ROUTE - KEEP THIS BELOW)
    Route::resource('pitch-events', \App\Http\Controllers\PitchEventController::class);

    Route::get('/analytics', function () {
        return view('admin.analytics'); // Placeholder for analytics page
    })
    ->name('analytics');

    Route::get('/content-management', [\App\Http\Controllers\ContentController::class, 'index'])->name('content_management');

    Route::get('/messages', function () {
        return view('admin.messages'); // Placeholder for messages page
    })->name('messages');

    Route::get('/messages/{conversation}', [\App\Http\Controllers\MessageController::class, 'adminShow'])->name('messages.show');

    Route::get('/settings', function () {
        return view('admin.settings'); // Placeholder for settings page
    })->name('settings');

    Route::get('/ideas-bank', function () {
        return view('admin.ideas_bank'); // Placeholder for Ideas Bank section
    })->name('ideas_bank');

    // Content management CRUD
    Route::get('/contents/{id}/edit', [\App\Http\Controllers\ContentController::class, 'edit'])->name('contents.edit');
    Route::post('/contents/{id}/update', [\App\Http\Controllers\ContentController::class, 'update'])->name('contents.update');
    Route::delete('/contents/{id}', [\App\Http\Controllers\ContentController::class, 'destroy'])->name('contents.destroy');

    // User approval routes
    Route::patch('/users/{user}/approve', [AdminController::class, 'approve'])->name('approve');
    Route::patch('/users/{user}/reject', [AdminController::class, 'reject'])->name('reject');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('destroy');

    // Admin Pairings Management
    Route::get('/pairings/create', [\App\Http\Controllers\AdminController::class, 'createPairing'])->name('pairings.create');
    Route::post('/pairings', [\App\Http\Controllers\AdminController::class, 'storePairing'])->name('pairings.store');
    Route::delete('/pairings/{pairing}', [\App\Http\Controllers\AdminController::class, 'destroyPairing'])->name('pairings.destroy');

    Route::get('/feedback', [AdminController::class, 'feedback'])->name('feedback');
    Route::patch('/feedback/{id}', [AdminController::class, 'updateFeedbackStatus'])->name('feedback.update');
    Route::delete('/feedback/{id}', [AdminController::class, 'destroyFeedback'])->name('feedback.destroy');

    // Admin Learning Resources Moderation
    Route::get('/resources', [AdminController::class, 'resources'])->name('resources');
    Route::patch('/resources/{id}/approve', [AdminController::class, 'approveResource'])->name('resources.approve');
    Route::patch('/resources/{id}/reject', [AdminController::class, 'rejectResource'])->name('resources.reject');
    Route::delete('/resources/{id}', [AdminController::class, 'destroyResource'])->name('resources.destroy');

    // Admin Content Moderation
    Route::patch('/contents/{id}/approve', [AdminController::class, 'approveContent'])->name('contents.approve');
    Route::patch('/contents/{id}/reject', [AdminController::class, 'rejectContent'])->name('contents.reject');

    Route::post('/contents', [\App\Http\Controllers\ContentController::class, 'store'])->name('contents.store');

    // Test route to verify admin access
    Route::get('/test-admin', function() {
        return 'Admin access working!';
    })->name('test-admin');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');





Route::get('/register-role', function () {
    return view('auth.register-role');
})->name('register.role');

Route::get('/register/investor', [InvestorRegisterController::class, 'showRegistrationForm'])->name('register.investor');
Route::post('/register/investor', [InvestorRegisterController::class, 'register']);

Route::get('/register/bdsp', [BDSPRegisterController::class, 'showRegistrationForm'])->name('register.bdsp');
Route::post('/register/bdsp', [BDSPRegisterController::class, 'register']);

Route::get('/register/entrepreneur', [EntrepreneurRegisterController::class, 'showRegistrationForm'])->name('register.entrepreneur');
Route::post('/register/entrepreneur', [EntrepreneurRegisterController::class, 'register']);

// Dashboards
Route::get('/dashboard/investor', function () {
    $approvedStartups = \App\Models\Startup::where('status', 'approved')
        ->with('founder')
        ->orderBy('created_at', 'desc')
        ->get();
    $startupsCount = \App\Models\Startup::where('status', 'approved')->count();
    $pitchEvents = \App\Models\PitchEvent::where('status', 'published')->count();
    $pitchEventsUpcoming = \App\Models\PitchEvent::where('status', 'published')
        ->where('event_date', '>=', now())
        ->count();
    $pitchesCount = $pitchEventsUpcoming;
    return view('dashboard.investor', compact('approvedStartups', 'startupsCount', 'pitchesCount', 'pitchEvents', 'pitchEventsUpcoming'));
})->middleware('auth')->name('dashboard.investor');
Route::get('/dashboard/bdsp', [\App\Http\Controllers\BDSPController::class, 'dashboard'])->middleware('auth')->name('dashboard.bdsp');
Route::get('/dashboard/entrepreneur', function () {
    $user = Auth::user();
    $pairings = \App\Models\Pairing::with(['userOne', 'userTwo'])
        ->where('user_one_id', $user->id)
        ->orWhere('user_two_id', $user->id)
        ->get();
    $tasks = \App\Models\Task::where('assignee_id', $user->id)
        ->orderBy('due_date')
        ->get();
    
    // Get paired BDSPs
    $bdspPairings = \App\Models\Pairing::where('pairing_type', 'bdsp_entrepreneur')
        ->where(function($q) use ($user) {
            $q->where('user_one_id', $user->id)->orWhere('user_two_id', $user->id);
        })->get();
    $bdspIds = $bdspPairings->map(function($pairing) use ($user) {
        return $pairing->user_one_id == $user->id ? $pairing->user_two_id : $pairing->user_one_id;
    });
    
    // Get paired mentors
    $mentorPairings = \App\Models\Pairing::where('pairing_type', 'mentor_entrepreneur')
        ->where(function($q) use ($user) {
            $q->where('user_one_id', $user->id)->orWhere('user_two_id', $user->id);
        })->get();
    $mentorIds = $mentorPairings->map(function($pairing) use ($user) {
        return $pairing->user_one_id == $user->id ? $pairing->user_two_id : $pairing->user_one_id;
    });
    
    // Get all resources uploaded by the entrepreneur's paired BDSPs and mentors
    $allUploaderIds = array_merge($bdspIds->all(), $mentorIds->all(), [$user->id]);
    $learningResources = \App\Models\Resource::whereIn('bdsp_id', $allUploaderIds)
        ->where('is_approved', true)
        ->orderByDesc('created_at')
        ->take(4)
        ->get();

    // Get mentorship sessions for the entrepreneur
    $mentorshipSessions = \App\Models\MentorshipSession::where(function($q) use ($user) {
        $q->where('scheduled_for', $user->id)->orWhere('scheduled_by', $user->id);
    })
    ->with(['scheduledBy', 'scheduledFor'])
    ->orderBy('date_time', 'desc')
    ->take(5)
    ->get();
    
    return view('dashboard.entrepreneur', compact('pairings', 'tasks', 'learningResources', 'mentorshipSessions'));
})->middleware('auth')->name('dashboard.entrepreneur');

// BDSP Dashboard and Management (protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/bdsp/dashboard', [\App\Http\Controllers\BDSPController::class, 'dashboard'])->name('bdsp.dashboard');
    Route::get('/bdsp/mentees', [\App\Http\Controllers\BDSPController::class, 'mentees'])->name('bdsp.mentees');
    Route::get('/bdsp/schedule-session', [\App\Http\Controllers\BDSPController::class, 'scheduleSessionPage'])->name('bdsp.schedule-session-page');
    Route::post('/bdsp/schedule-session', [\App\Http\Controllers\BDSPController::class, 'scheduleSession'])->name('bdsp.schedule-session');
    Route::patch('/bdsp/sessions/{session}/cancel', [\App\Http\Controllers\BDSPController::class, 'cancelSession'])->name('bdsp.sessions.cancel');
    Route::patch('/bdsp/sessions/{session}/complete', [\App\Http\Controllers\BDSPController::class, 'completeSession'])->name('bdsp.sessions.complete');
    // BDSP Resources
    Route::get('/bdsp/upload-resources', [\App\Http\Controllers\ResourceController::class, 'index'])->name('bdsp.resources.index');
    Route::post('/bdsp/upload-resources', [\App\Http\Controllers\ResourceController::class, 'store'])->name('bdsp.resources.store');
    Route::get('/bdsp/resources/{resource}/edit', [\App\Http\Controllers\ResourceController::class, 'edit'])->name('bdsp.resources.edit');
    Route::put('/bdsp/resources/{resource}', [\App\Http\Controllers\ResourceController::class, 'update'])->name('bdsp.resources.update');
    Route::delete('/bdsp/resources/{resource}', [\App\Http\Controllers\ResourceController::class, 'destroy'])->name('bdsp.resources.destroy');
    // BDSP Placeholder Views
    Route::get('/bdsp/sessions', function () { return view('bdsp.sessions'); })->name('bdsp.sessions');
    Route::get('/bdsp/reports', function () { return view('bdsp.reports'); })->name('bdsp.reports');
    Route::get('/bdsp/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('bdsp.messages');
    Route::get('/bdsp/messages/{conversation}', [\App\Http\Controllers\MessageController::class, 'show'])->name('bdsp.messages.show');
    Route::post('/bdsp/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('bdsp.messages.store');
    Route::get('/bdsp/feedback', [\App\Http\Controllers\FeedbackController::class, 'index'])->name('bdsp.feedback');
    Route::delete('/bdsp/feedback/{id}', [\App\Http\Controllers\FeedbackController::class, 'destroy'])->name('bdsp.feedback.destroy');
});

Route::get('/dashboard/entrepreneur-messages', function () {
    return view('dashboard.entrepreneur-messages');
})->middleware('auth')->name('entrepreneur.messages');

Route::get('/dashboard/entrepreneur-hub', function () {
    return view('dashboard.entrepreneur-hub');
})->middleware('auth')->name('entrepreneur.hub');

// Entrepreneur Dashboard Sections
Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard/entrepreneur-progress', 'dashboard.entrepreneur-progress')->name('entrepreneur.progress');
    Route::get('/dashboard/entrepreneur-calendar', function () {
        $user = Auth::user();
        $sessions = \App\Models\TrainingSession::orderBy('date_time', 'asc')->get();
        $registrations = \DB::table('training_session_participants')
            ->where('user_id', $user->id)
            ->pluck('training_session_id')
            ->toArray();
        return view('dashboard.entrepreneur-calendar', compact('sessions', 'registrations'));
    })->name('entrepreneur.calendar');
    // Startup Profile Routes
    Route::get('/dashboard/entrepreneur-startup-profile', [\App\Http\Controllers\StartupController::class, 'index'])->name('entrepreneur.startup-profile');
    Route::get('/dashboard/entrepreneur-startup-profile/create', [\App\Http\Controllers\StartupController::class, 'create'])->name('entrepreneur.startup-profile.create');
    Route::get('/dashboard/entrepreneur-startup-profile/{startup}/edit', [\App\Http\Controllers\StartupController::class, 'edit'])->name('entrepreneur.startup-profile.edit');
    Route::post('/dashboard/entrepreneur-startup-profile', [\App\Http\Controllers\StartupController::class, 'store'])->name('entrepreneur.startup-profile.store');
    Route::put('/dashboard/entrepreneur-startup-profile/{startup}', [\App\Http\Controllers\StartupController::class, 'update'])->name('entrepreneur.startup-profile.update');
    Route::delete('/dashboard/entrepreneur-startup-profile/{startup}', [\App\Http\Controllers\StartupController::class, 'destroy'])->name('entrepreneur.startup-profile.destroy');

    
    // Tasks Routes
    Route::get('/dashboard/entrepreneur-tasks', [\App\Http\Controllers\TaskController::class, 'index'])->name('entrepreneur.tasks');
    Route::post('/dashboard/entrepreneur-tasks/{task}/complete', [\App\Http\Controllers\TaskController::class, 'markAsCompleted'])->name('entrepreneur.tasks.complete');
    Route::post('/dashboard/entrepreneur-tasks/{task}/in-progress', [\App\Http\Controllers\TaskController::class, 'markAsInProgress'])->name('entrepreneur.tasks.in-progress');
    Route::get('/dashboard/entrepreneur-mentorship', function () {
        $user = Auth::user();
        
        // Get paired mentors
        $mentorPairings = \App\Models\Pairing::where('pairing_type', 'mentor_entrepreneur')
            ->where(function($q) use ($user) {
                $q->where('user_one_id', $user->id)->orWhere('user_two_id', $user->id);
            })->get();
        $mentorIds = $mentorPairings->map(function($pairing) use ($user) {
            return $pairing->user_one_id == $user->id ? $pairing->user_two_id : $pairing->user_one_id;
        });
        
        // Get paired BDSPs
        $bdspPairings = \App\Models\Pairing::where('pairing_type', 'bdsp_entrepreneur')
            ->where(function($q) use ($user) {
                $q->where('user_one_id', $user->id)->orWhere('user_two_id', $user->id);
            })->get();
        $bdspIds = $bdspPairings->map(function($pairing) use ($user) {
            return $pairing->user_one_id == $user->id ? $pairing->user_two_id : $pairing->user_one_id;
        });
        
        // Get all paired professionals (mentors + BDSPs)
        $allProfessionalIds = array_merge($mentorIds->all(), $bdspIds->all());
        $professionals = \App\Models\User::whereIn('id', $allProfessionalIds)
            ->where('is_approved', true)
            ->get();
        
        $professionalsArray = $professionals->map(function($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'role' => $p->role,
                'specialty' => $p->specialty ?? ucfirst($p->role),
                'avg_rating' => $p->avg_rating ?? '4.8',
            ];
        })->values();
        
        $sessions = \App\Models\MentorshipSession::with(['pairing.userOne', 'pairing.userTwo', 'scheduledBy', 'scheduledFor'])
            ->where(function($q) use ($user) {
                $q->where('scheduled_by', $user->id)
                  ->orWhere('scheduled_for', $user->id);
            })
            ->where('date_time', '>=', now())
            ->where('status', '!=', 'cancelled')
            ->orderBy('date_time', 'asc')
            ->get();
        return view('dashboard.entrepreneur-mentorship', compact('professionals', 'professionalsArray', 'sessions'));
    })->name('entrepreneur.mentorship');
    Route::get('/dashboard/entrepreneur-pitch', function () {
        $user = Auth::user();
        // Get paired BDSPs
        $bdspPairings = \App\Models\Pairing::where('pairing_type', 'bdsp_entrepreneur')
            ->where(function($q) use ($user) {
                $q->where('user_one_id', $user->id)->orWhere('user_two_id', $user->id);
            })->get();
        $bdspIds = $bdspPairings->map(function($pairing) use ($user) {
            return $pairing->user_one_id == $user->id ? $pairing->user_two_id : $pairing->user_one_id;
        });
        // Get paired mentors
        $mentorPairings = \App\Models\Pairing::where('pairing_type', 'mentor_entrepreneur')
            ->where(function($q) use ($user) {
                $q->where('user_one_id', $user->id)->orWhere('user_two_id', $user->id);
            })->get();
        $mentorIds = $mentorPairings->map(function($pairing) use ($user) {
            return $pairing->user_one_id == $user->id ? $pairing->user_two_id : $pairing->user_one_id;
        });
        // Get all resources uploaded by the entrepreneur, their BDSPs, or mentors
        $allUploaderIds = array_merge($bdspIds->all(), $mentorIds->all(), [$user->id]);
        $learningResources = \App\Models\Resource::whereIn('bdsp_id', $allUploaderIds)
            ->orderByDesc('created_at')->get();

        // Get pitching resources from the content management system
        $pitchDeckCategory = \Illuminate\Support\Facades\DB::table('categories')->where('name', 'Pitch Deck')->first();
        $pitchResources = collect();
        if ($pitchDeckCategory) {
            $pitchResources = \App\Models\Content::where('status', 'published')
                ->where('category_id', $pitchDeckCategory->id)
                ->where(function ($query) {
                    $query->where('visibility', 'public')
                          ->orWhere('visibility', 'entrepreneurs');
                })
                ->orderByDesc('created_at')
                ->get();
        }

        $recommendedEvents = \App\Models\PitchEvent::where('status', 'published')
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();
        return view('dashboard.entrepreneur-pitch', compact('recommendedEvents', 'learningResources', 'pitchResources'));
    })->middleware('auth')->name('entrepreneur.pitch');
    Route::get('/dashboard/entrepreneur-feedback', [\App\Http\Controllers\FeedbackController::class, 'index'])->name('entrepreneur.feedback');
});

Route::post('/entrepreneur/feedback', function (\Illuminate\Http\Request $request) {
    return back()->with('success', 'Feedback submitted (placeholder).');
})->name('entrepreneur.feedback.store');

// Investor Dashboard Sections
Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard/investor-startup-profiles', 'dashboard.investor-startup-profiles')->name('investor.startup_profiles');
    Route::view('/dashboard/investor-pitch-events', 'dashboard.investor-pitch-events')->name('investor.pitch_events');
    Route::view('/dashboard/investor-success-stories', 'dashboard.investor-success-stories')->name('investor.success_stories');
    Route::view('/dashboard/investor-messages', 'dashboard.investor-messages')->name('investor.messages');
    
    // Investor Pitch Event Proposals
    Route::resource('investor/proposals', \App\Http\Controllers\PitchEventProposalController::class)->names([
        'index' => 'investor.proposals.index',
        'create' => 'investor.proposals.create',
        'store' => 'investor.proposals.store',
        'show' => 'investor.proposals.show',
        'edit' => 'investor.proposals.edit',
        'update' => 'investor.proposals.update',
        'destroy' => 'investor.proposals.destroy',
    ]);
});

// Mentor Registration & Dashboard
Route::get('/register/mentor', [\App\Http\Controllers\MentorRegisterController::class, 'showRegistrationForm'])->name('register.mentor');
Route::post('/register/mentor', [\App\Http\Controllers\MentorRegisterController::class, 'register']);
Route::get('/dashboard/mentor', [\App\Http\Controllers\MentorDashboardController::class, 'index'])->middleware(['auth'])->name('dashboard.mentor');

// Mentee Registration & Dashboard
Route::get('/register/mentee', [\App\Http\Controllers\MenteeRegisterController::class, 'showRegistrationForm'])->name('register.mentee');
Route::post('/register/mentee', [\App\Http\Controllers\MenteeRegisterController::class, 'register']);
Route::get('/dashboard/mentee', [\App\Http\Controllers\AuthController::class, 'menteeDashboard'])->middleware(['auth'])->name('dashboard.mentee');


// Mentorship Session Booking & Management
Route::middleware(['auth'])->group(function () {
    Route::post('mentorship-sessions', [\App\Http\Controllers\MentorshipSessionController::class, 'adminStore'])->name('mentorship-sessions.store');
    Route::post('entrepreneur/mentorship-sessions', [\App\Http\Controllers\MentorshipSessionController::class, 'entrepreneurStore'])->name('entrepreneur.mentorship-sessions.store');
    Route::resource('mentorship-sessions', \App\Http\Controllers\MentorshipSessionController::class)->except(['edit', 'update', 'destroy', 'store']);
    Route::post('mentorship-sessions/{mentorship_session}/confirm', [\App\Http\Controllers\MentorshipSessionController::class, 'confirm'])->name('mentorship-sessions.confirm');
    Route::post('mentorship-sessions/{mentorship_session}/cancel', [\App\Http\Controllers\MentorshipSessionController::class, 'cancel'])->name('mentorship-sessions.cancel');
    Route::post('mentorship-sessions/{mentorship_session}/complete', [\App\Http\Controllers\MentorshipSessionController::class, 'complete'])->name('mentorship-sessions.complete');
});

// Mentorship Forms & Journey
Route::middleware(['auth'])->prefix('mentorship')->name('mentorship.')->group(function () {
    // Forms Dashboard
    Route::get('/forms/dashboard', [\App\Http\Controllers\MentorshipFormController::class, 'dashboard'])->name('forms.dashboard');
    
    // Forms Listing
    Route::get('/forms', [\App\Http\Controllers\MentorshipFormController::class, 'index'])->name('forms.index');
    
    // Form Creation & Submission
    Route::get('/forms/{form}/pairing/{pairing}/create', [\App\Http\Controllers\MentorshipFormController::class, 'create'])->name('forms.create');
    Route::post('/forms/{form}/pairing/{pairing}', [\App\Http\Controllers\MentorshipFormController::class, 'store'])->name('forms.store');
    
    // Form Viewing & Editing
    Route::get('/form-submissions/{submission}', [\App\Http\Controllers\MentorshipFormController::class, 'show'])->name('forms.show');
    Route::get('/form-submissions/{submission}/edit', [\App\Http\Controllers\MentorshipFormController::class, 'edit'])->name('forms.edit');
    Route::put('/form-submissions/{submission}', [\App\Http\Controllers\MentorshipFormController::class, 'update'])->name('forms.update');
    
    // Form Review
    Route::post('/form-submissions/{submission}/review', [\App\Http\Controllers\MentorshipFormController::class, 'review'])->name('forms.review');
    
    // Form Download
    Route::get('/form-submissions/{submission}/download', [\App\Http\Controllers\MentorshipFormController::class, 'download'])->name('forms.download');
});

Route::get('/registration-success', function () {
    return view('auth.registration-success');
})->name('registration.success');

Route::middleware(['auth'])->group(function () {
    Route::post('/training-sessions/{id}/register', [\App\Http\Controllers\TrainingSessionController::class, 'register'])->name('training-sessions.register');
    Route::post('/feedback', [\App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/bdsp/resources', [\App\Http\Controllers\ResourceController::class, 'index'])->name('bdsp.resources');
    Route::post('/dashboard/bdsp/resources', [\App\Http\Controllers\ResourceController::class, 'store']);
});

Route::post('/events/{event}/register', [\App\Http\Controllers\PitchEventController::class, 'register'])->name('events.register');
Route::get('/dashboard/investor-pitch-events', [\App\Http\Controllers\InvestorDashboardController::class, 'pitchEvents'])
    ->middleware('auth')
    ->name('investor.pitch_events');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'role:admin,staff'])->name('admin.dashboard');
Route::get('/entrepreneur/module/{module}', function ($module) {
    return view('dashboard.entrepreneur-module', ['module' => $module]);
})->name('entrepreneur.module');

Route::get('/entrepreneur/task/{task}', function ($task) {
    return view('dashboard.entrepreneur-task', ['task' => $task]);
})->name('entrepreneur.task');

Route::get('/entrepreneur/mentorship/session/{id}', function ($id) {
    $user = Auth::user();
    
    // Ensure user is authenticated
    if (!$user) {
        abort(401, 'You must be logged in to view this session.');
    }
    
    // Find the session with all necessary relationships
    $session = \App\Models\MentorshipSession::with([
        'pairing.userOne', 
        'pairing.userTwo', 
        'scheduledBy', 
        'scheduledFor'
    ])->findOrFail($id);
    
    // Enhanced authorization check
    $isAuthorized = false;
    
    // Check if user is directly involved in the session
    if ($session->scheduled_for === $user->id || $session->scheduled_by === $user->id) {
        $isAuthorized = true;
    }
    
    // Check if user is part of the pairing (for additional security)
    if ($session->pairing) {
        if ($session->pairing->user_one_id === $user->id || $session->pairing->user_two_id === $user->id) {
            $isAuthorized = true;
        }
    }
    
    // Check if user is an admin (for support purposes)
    if ($user->role === 'admin' || $user->role === 'staff') {
        $isAuthorized = true;
    }
    
    if (!$isAuthorized) {
        abort(403, 'You are not authorized to view this session.');
    }
    
    return view('dashboard.entrepreneur-mentorship-session', compact('session', 'id'));
})->middleware(['auth'])->name('entrepreneur.mentorship.session');

Route::get('/entrepreneur/achievements', function () {
    return view('dashboard.entrepreneur-achievements');
})->name('entrepreneur.achievements');

Route::get('/entrepreneur/resource/download/{resource}', function ($resource) {
    return view('dashboard.entrepreneur-resource-download', ['resource' => $resource]);
})->name('entrepreneur.resource.download');

// Practice Pitch Routes
Route::middleware(['auth'])->group(function () {
    // Entrepreneur
    Route::get('/practice-pitches', [\App\Http\Controllers\PracticePitchController::class, 'index'])->name('practice-pitches.index');
    Route::post('/practice-pitches', [\App\Http\Controllers\PracticePitchController::class, 'store'])->name('practice-pitches.store');
    // Mentor/BDSP feedback (for approved pitches)
    Route::post('/practice-pitches/{id}/feedback', [\App\Http\Controllers\PracticePitchController::class, 'feedback'])->name('practice-pitches.feedback');
});
Route::middleware(['auth', 'isAdmin'])->group(function () {
    // Admin review
    Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/practice-pitches', [\App\Http\Controllers\PracticePitchController::class, 'adminIndex'])->name('admin.practice-pitches.index');
    Route::post('/admin/practice-pitches/{id}/approve', [\App\Http\Controllers\PracticePitchController::class, 'approve'])->name('admin.practice-pitches.approve');
    Route::post('/admin/practice-pitches/{id}/reject', [\App\Http\Controllers\PracticePitchController::class, 'reject'])->name('admin.practice-pitches.reject');
});
});



// BDSP specific routes for practice pitches
Route::middleware(['auth', 'role:bdsp'])->group(function () {
    Route::get('/bdsp/practice-pitches', [PracticePitchController::class, 'bdspIndex'])->name('bdsp.practice-pitches.index');
    Route::post('/bdsp/practice-pitches/{id}/feedback', [PracticePitchController::class, 'feedback'])->name('bdsp.practice-pitches.feedback');
});

Route::get('/mentor/sessions', function () {
    $mentor = Auth::user();
    $sessions = \App\Models\MentorshipSession::where(function ($q) use ($mentor) {
        $q->where('scheduled_by', $mentor->id)
          ->orWhere('scheduled_for', $mentor->id);
    })
    ->where('date_time', '>=', now())
    ->orderBy('date_time')
    ->with(['pairing.userOne', 'pairing.userTwo', 'scheduledBy', 'scheduledFor'])
    ->get();
    return view('mentor.sessions.index', compact('sessions'));
})->middleware(['auth'])->name('mentor.sessions.index');
Route::get('/mentor/sessions/create', [\App\Http\Controllers\MentorshipSessionController::class, 'mentorScheduleSessionPage'])->middleware(['auth'])->name('mentor.sessions.create');
Route::post('/mentor/sessions/create', [\App\Http\Controllers\MentorshipSessionController::class, 'mentorScheduleSession'])->middleware(['auth']);
Route::get('/mentor/messages', [\App\Http\Controllers\MessageController::class, 'index'])->middleware(['auth'])->name('mentor.messages.index');
Route::get('/mentor/messages/{conversation}', [\App\Http\Controllers\MessageController::class, 'show'])->middleware(['auth'])->name('mentor.messages.show');
Route::get('/mentor/mentees', function () {
    $mentor = Auth::user();
    $pairings = \App\Models\Pairing::whereIn('pairing_type', ['mentor_mentee', 'mentor_entrepreneur'])
        ->where(function ($q) use ($mentor) {
            $q->where('user_one_id', $mentor->id)->orWhere('user_two_id', $mentor->id);
        })
        ->with(['userOne', 'userTwo'])
        ->get();
    $mentees = $pairings->map(function ($pairing) use ($mentor) {
        return $pairing->user_one_id == $mentor->id ? $pairing->userTwo : $pairing->userOne;
    });
    return view('mentor.mentees.index', compact('mentees'));
})->middleware(['auth'])->name('mentor.mentees.index');
Route::get('/mentor/mentees/{id}', function ($id) {
    $mentee = \App\Models\User::findOrFail($id);
    return view('mentor.mentees.show', compact('mentee'));
})->middleware(['auth'])->name('mentor.mentees.show');

Route::get('/mentor/calendar', function () {
    $mentor = Auth::user();
    $sessions = \App\Models\MentorshipSession::where(function ($q) use ($mentor) {
        $q->where('scheduled_by', $mentor->id)
          ->orWhere('scheduled_for', $mentor->id);
    })
    ->where('date_time', '>=', now())
    ->orderBy('date_time')
    ->with(['pairing.userOne', 'pairing.userTwo', 'scheduledBy', 'scheduledFor'])
    ->get();
    return view('mentor.calendar', compact('sessions'));
})->middleware(['auth'])->name('mentor.calendar');

Route::get('/mentor/resources', function () {
    return view('mentor.resources');
})->middleware(['auth'])->name('mentor.resources');

Route::get('/mentor/settings', function () {
    return view('mentor.settings');
})->middleware(['auth'])->name('mentor.settings');

Route::get('/mentor/forms', [\App\Http\Controllers\MentorshipFormController::class, 'index'])->middleware(['auth'])->name('mentor.forms');

Route::get('/mentor/reports', function () {
    return view('mentor.reports');
})->middleware(['auth'])->name('mentor.reports');

// Idea Bank MVP routes
Route::middleware(['auth'])->group(function () {
    Route::resource('ideas', IdeaController::class);
    Route::resource('ideas.comments', CommentController::class)->shallow();
    Route::resource('ideas.pitches', PitchController::class)->shallow();
    Route::resource('ideas.votes', VoteController::class)->shallow();
});

// Admin moderation routes for ideas
Route::middleware(['auth'])->group(function () {
    Route::post('admin/ideas/{idea}/approve', [IdeaController::class, 'approve'])->name('admin.ideas.approve');
    Route::post('admin/ideas/{idea}/reject', [IdeaController::class, 'reject'])->name('admin.ideas.reject');
});

// Admin moderation routes for pitches
Route::middleware(['auth'])->group(function () {
    Route::post('admin/pitches/{pitch}/approve', [PitchController::class, 'approve'])->name('admin.pitches.approve');
    Route::post('admin/pitches/{pitch}/reject', [PitchController::class, 'reject'])->name('admin.pitches.reject');
});

// Investor startup profile access routes
Route::middleware(['auth'])->group(function () {
    Route::get('/investor/dashboard', [\App\Http\Controllers\InvestorController::class, 'dashboard'])->name('investor.dashboard');
    Route::post('/investor/startup/{startup}/request-access', [\App\Http\Controllers\InvestorController::class, 'requestAccess'])->name('investor.request_access');
    Route::get('/investor/startup-profiles', [\App\Http\Controllers\InvestorController::class, 'startupProfiles'])->name('investor.startup_profiles');
    Route::get('/investor/startup/{startup}', [\App\Http\Controllers\InvestorController::class, 'viewStartup'])->name('investor.view_startup');
});

// Entrepreneur access request management routes
Route::middleware(['auth'])->group(function () {
    Route::get('/entrepreneur/access-requests', [\App\Http\Controllers\StartupController::class, 'accessRequests'])->name('entrepreneur.access_requests');
    Route::post('/entrepreneur/access-request/{requestId}/approve', [\App\Http\Controllers\StartupController::class, 'approveAccess'])->name('entrepreneur.approve_access');
    Route::post('/entrepreneur/access-request/{requestId}/reject', [\App\Http\Controllers\StartupController::class, 'rejectAccess'])->name('entrepreneur.reject_access');
    Route::post('/entrepreneur/access-request/{requestId}/revoke', [\App\Http\Controllers\StartupController::class, 'revokeAccess'])->name('entrepreneur.revoke_access');
});

// Task submission routes
Route::middleware(['auth'])->group(function () {
    Route::post('/tasks/{task}/submissions', [\App\Http\Controllers\TaskSubmissionController::class, 'store'])->name('tasks.submissions.store');
    Route::get('/submissions/{submission}', [\App\Http\Controllers\TaskSubmissionController::class, 'show'])->name('submissions.show');
    Route::post('/submissions/{submission}/review', [\App\Http\Controllers\TaskSubmissionController::class, 'review'])->name('submissions.review');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/bdsp/tasks', [\App\Http\Controllers\TaskController::class, 'bdspIndex'])->name('bdsp.tasks.index');
    Route::get('/mentor/tasks', [\App\Http\Controllers\TaskController::class, 'mentorIndex'])->name('mentor.tasks.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/tasks/create', [\App\Http\Controllers\TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [\App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
});

// Admin Startup Profile Management
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/startups/{startup}', [\App\Http\Controllers\AdminStartupController::class, 'show'])->name('admin.startups.show');
Route::post('/admin/startups/{startup}/approve', [\App\Http\Controllers\AdminStartupController::class, 'approve'])->name('admin.startups.approve');
Route::post('/admin/startups/{startup}/reject', [\App\Http\Controllers\AdminStartupController::class, 'reject'])->name('admin.startups.reject');
Route::patch('/admin/startups/{startup}/toggle-anonymous', [\App\Http\Controllers\AdminStartupController::class, 'toggleAnonymousTeaser'])->name('admin.startups.toggle_anonymous_teaser');
});

// Startup Info Request Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/startups/{startup}/request-info', [\App\Http\Controllers\StartupInfoRequestController::class, 'store'])->name('startup.info-request.store');
    Route::get('/investor/startup/{startup}', [\App\Http\Controllers\StartupInfoRequestController::class, 'show'])->name('investor.startup-profile');
});

// Admin Startup Info Request Management
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/startup-info-requests/{infoRequest}/approve', [\App\Http\Controllers\StartupInfoRequestController::class, 'approve'])->name('admin.startup-info-requests.approve');
    Route::post('/admin/startup-info-requests/{infoRequest}/reject', [\App\Http\Controllers\StartupInfoRequestController::class, 'reject'])->name('admin.startup-info-requests.reject');
    Route::post('/admin/mentorship-sessions/clear-all', [\App\Http\Controllers\AdminController::class, 'clearAllSessions'])->name('admin.mentorship_sessions.clear_all');
});

// Admin Access Request Management
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/access-requests', [\App\Http\Controllers\AdminController::class, 'accessRequests'])->name('admin.access_requests');
    Route::post('/admin/access-requests/{accessRequest}/approve', [\App\Http\Controllers\AdminController::class, 'approveAccessRequest'])->name('admin.access_requests.approve');
    Route::post('/admin/access-requests/{accessRequest}/reject', [\App\Http\Controllers\AdminController::class, 'rejectAccessRequest'])->name('admin.access_requests.reject');
});



// Ideas interests routes
Route::middleware(['auth'])->group(function () {
    Route::post('/ideas/{idea}/interests', [\App\Http\Controllers\IdeaInterestController::class, 'store'])->name('ideas.interests.store');
    Route::delete('/ideas/{idea}/interests', [\App\Http\Controllers\IdeaInterestController::class, 'destroy'])->name('ideas.interests.destroy');
    Route::patch('/idea-interests/{interest}/accept', [\App\Http\Controllers\IdeaInterestController::class, 'accept'])->name('idea-interests.accept');
    Route::patch('/idea-interests/{interest}/decline', [\App\Http\Controllers\IdeaInterestController::class, 'decline'])->name('idea-interests.decline');
});

// Mentee Resources Page
Route::get('/dashboard/mentee/resources', function () {
    $mentee = Auth::user();
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
    // Get resources uploaded by the mentee and their mentor
    $uploaderIds = [$mentee->id];
    if ($mentor) {
        $uploaderIds[] = $mentor->id;
    }
    $learningResources = \App\Models\Resource::whereIn('bdsp_id', $uploaderIds)
        ->orderByDesc('created_at')
        ->get();
    return view('dashboard.mentee-resources', compact('learningResources'));
})->middleware('auth')->name('dashboard.mentee.resources');

// Mentee Feedback Page
Route::get('/dashboard/mentee/feedback', function () {
    $user = Auth::user();
    
    // Get paired users (mentors, bdsp, etc.)
    $pairings = \App\Models\Pairing::where(function($q) use ($user) {
        $q->where('user_one_id', $user->id)->orWhere('user_two_id', $user->id);
    })->get();
    $pairedUsers = $pairings->map(function($pairing) use ($user) {
        return $pairing->user_one_id == $user->id ? $pairing->userTwo : $pairing->userOne;
    });
    
    // Feedback given by the mentee
    $feedbackGiven = \App\Models\Feedback::where('user_id', $user->id)->latest()->get();
    
    // Feedback received (if mentee has received feedback)
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
    
    return view('dashboard.mentee-feedback', compact('pairedUsers', 'feedbackGiven', 'feedbackReceived', 'stats'));
})->middleware('auth')->name('dashboard.mentee.feedback');

// Test route for debugging storage
Route::get('/test-storage', function() {
    $testFile = 'test.txt';
    $content = 'Test content ' . time();
    
    $uploaded = Storage::disk('public')->put($testFile, $content);
    $exists = Storage::disk('public')->exists($testFile);
    $url = Storage::disk('public')->url($testFile);
    
    return response()->json([
        'uploaded' => $uploaded,
        'exists' => $exists,
        'url' => $url,
        'content' => Storage::disk('public')->get($testFile)
    ]);
})->middleware('auth');
