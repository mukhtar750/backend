<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvestorRegisterController;
use App\Http\Controllers\BDSPRegisterController;
use App\Http\Controllers\EntrepreneurRegisterController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\NotificationController;

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
    Route::get('/messages/{conversation}', [\App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/conversations', [\App\Http\Controllers\MessageController::class, 'getConversations'])->name('messages.conversations');
    Route::get('/messages/{conversation}/messages', [\App\Http\Controllers\MessageController::class, 'getMessages'])->name('messages.getMessages');
    Route::post('/messages/{conversation}/mark-as-read', [\App\Http\Controllers\MessageController::class, 'markAsRead'])->name('messages.markAsRead');
    Route::get('/messages/unread-count', [\App\Http\Controllers\MessageController::class, 'getUnreadCount'])->name('messages.unreadCount');
    Route::get('/messages/{message}/download', [\App\Http\Controllers\MessageController::class, 'downloadFile'])->name('messages.download');
    Route::delete('/messages/{message}', [\App\Http\Controllers\MessageController::class, 'deleteMessage'])->name('messages.delete');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/user-management', [AdminController::class, 'userManagement'])->name('user-management');
    Route::get('/user-management/{id}/edit', [AdminController::class, 'editUser'])->name('editUser');
    Route::put('/user-management/{id}', [AdminController::class, 'updateUser'])->name('updateUser');

    // Admin Training Schedules CRUD
    Route::get('/training-programs', [AdminController::class, 'trainingPrograms'])->name('training_programs');
    Route::get('/training-programs/create', [AdminController::class, 'createTraining'])->name('training_programs.create');
    Route::post('/training-programs', [AdminController::class, 'storeTraining'])->name('training_programs.store');
    Route::get('/training-programs/{id}/edit', [AdminController::class, 'editTraining'])->name('training_programs.edit');
    Route::put('/training-programs/{id}', [AdminController::class, 'updateTraining'])->name('training_programs.update');
    Route::delete('/training-programs/{id}', [AdminController::class, 'destroyTraining'])->name('training_programs.destroy');

    Route::get('/mentorship', [AdminController::class, 'mentorship'])->name('mentorship');

    Route::get('/mentorship-sessions', [AdminController::class, 'mentorshipSessions'])->name('mentorship_sessions');

    // Pitch Events Management
    Route::resource('pitch-events', \App\Http\Controllers\PitchEventController::class);

    Route::get('/analytics', function () {
        return view('admin.analytics'); // Placeholder for analytics page
    })
    ->name('analytics');

    Route::get('/content-management', [\App\Http\Controllers\ContentController::class, 'index'])->name('content_management');

    Route::get('/messages', function () {
        return view('admin.messages'); // Placeholder for messages page
    })->name('messages');

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
Route::view('/dashboard/investor', 'dashboard.investor')->middleware('auth')->name('dashboard.investor');
Route::get('/dashboard/bdsp', [\App\Http\Controllers\BDSPController::class, 'dashboard'])->middleware('auth')->name('dashboard.bdsp');
Route::get('/dashboard/entrepreneur', function () {
    $user = auth()->user();
    $pairings = \App\Models\Pairing::with(['userOne', 'userTwo'])
        ->where('user_one_id', $user->id)
        ->orWhere('user_two_id', $user->id)
        ->get();
    return view('dashboard.entrepreneur', compact('pairings'));
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
    Route::get('/bdsp/messages', function () { return view('bdsp.messages'); })->name('bdsp.messages');
    // BDSP Messaging
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
        $user = auth()->user();
        $sessions = \App\Models\TrainingSession::orderBy('date_time', 'asc')->get();
        $registrations = \DB::table('training_session_participants')
            ->where('user_id', $user->id)
            ->pluck('training_session_id')
            ->toArray();
        return view('dashboard.entrepreneur-calendar', compact('sessions', 'registrations'));
    })->name('entrepreneur.calendar');
    Route::view('/dashboard/entrepreneur-mentorship', 'dashboard.entrepreneur-mentorship')->name('entrepreneur.mentorship');
    Route::get('/dashboard/entrepreneur-pitch', function () {
        $recommendedEvents = \App\Models\PitchEvent::where('status', 'published')
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();
        return view('dashboard.entrepreneur-pitch', compact('recommendedEvents'));
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
});

// Mentor Registration & Dashboard
Route::get('/register/mentor', [\App\Http\Controllers\MentorRegisterController::class, 'showRegistrationForm'])->name('register.mentor');
Route::post('/register/mentor', [\App\Http\Controllers\MentorRegisterController::class, 'register']);
Route::get('/dashboard/mentor', function () {
    return view('dashboard.mentor');
})->middleware(['auth'])->name('dashboard.mentor');

// Mentee Registration & Dashboard
Route::get('/register/mentee', [\App\Http\Controllers\MenteeRegisterController::class, 'showRegistrationForm'])->name('register.mentee');
Route::post('/register/mentee', [\App\Http\Controllers\MenteeRegisterController::class, 'register']);
Route::get('/dashboard/mentee', function () {
    return view('dashboard.mentee');
})->middleware(['auth'])->name('dashboard.mentee');

// Mentorship Session Booking & Management
Route::middleware(['auth'])->group(function () {
    Route::resource('mentorship-sessions', \App\Http\Controllers\MentorshipSessionController::class)->except(['edit', 'update', 'destroy']);
    Route::post('mentorship-sessions/{mentorship_session}/confirm', [\App\Http\Controllers\MentorshipSessionController::class, 'confirm'])->name('mentorship-sessions.confirm');
    Route::post('mentorship-sessions/{mentorship_session}/cancel', [\App\Http\Controllers\MentorshipSessionController::class, 'cancel'])->name('mentorship-sessions.cancel');
    Route::post('mentorship-sessions/{mentorship_session}/complete', [\App\Http\Controllers\MentorshipSessionController::class, 'complete'])->name('mentorship-sessions.complete');
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

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/entrepreneur/module/{module}', function ($module) {
    return view('dashboard.entrepreneur-module', ['module' => $module]);
})->name('entrepreneur.module');

Route::get('/entrepreneur/task/{task}', function ($task) {
    return view('dashboard.entrepreneur-task', ['task' => $task]);
})->name('entrepreneur.task');

Route::get('/entrepreneur/mentorship/session/{id}', function ($id) {
    return view('dashboard.entrepreneur-mentorship-session', ['id' => $id]);
})->name('entrepreneur.mentorship.session');

Route::get('/entrepreneur/achievements', function () {
    return view('dashboard.entrepreneur-achievements');
})->name('entrepreneur.achievements');

Route::get('/entrepreneur/resource/download/{resource}', function ($resource) {
    return view('dashboard.entrepreneur-resource-download', ['resource' => $resource]);
})->name('entrepreneur.resource.download');