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

    Route::get('/training-programs', function () {
        return view('admin.training_programs'); // Placeholder for training programs page
    })->name('training_programs');

    Route::get('/mentorship', function () {
        return view('admin.mentorship'); // Placeholder for mentorship page
    })->name('mentorship');

    Route::get('/pitch-events', function () {
        return view('admin.pitch_events'); // Placeholder for pitch events page
    })->name('pitch_events');

    Route::get('/analytics', function () {
        return view('admin.analytics'); // Placeholder for analytics page
    })
    ->name('analytics');

    Route::get('/content-management', function () {
        return view('admin.content_management'); // Placeholder for content management page
    })->name('content_management');

    Route::get('/messages', function () {
        return view('admin.messages'); // Placeholder for messages page
    })->name('messages');

    Route::get('/settings', function () {
        return view('admin.settings'); // Placeholder for settings page
    })->name('settings');

    // User approval routes
    Route::patch('/users/{user}/approve', [AdminController::class, 'approve'])->name('approve');
    Route::patch('/users/{user}/reject', [AdminController::class, 'reject'])->name('reject');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('destroy');
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
Route::view('/dashboard/bdsp', 'dashboard.bdsp')->middleware('auth')->name('dashboard.bdsp');
Route::view('/dashboard/entrepreneur', 'dashboard.entrepreneur')->middleware('auth')->name('dashboard.entrepreneur');

// BDSP Dashboard
Route::get('/bdsp/dashboard', function () {
    return view('bdsp.dashboard');
})->name('bdsp.dashboard');

// My Mentees
Route::get('/bdsp/mentees', function () {
    return view('bdsp.mentees'); // placeholder view
})->name('bdsp.mentees');

// Upload Resources
Route::get('/bdsp/upload-resources', function () {
    return view('bdsp.upload-resources'); // placeholder view
})->name('bdsp.upload-resources');

// Sessions
Route::get('/bdsp/sessions', function () {
    return view('bdsp.sessions'); // placeholder view
})->name('bdsp.sessions');

// Reports
Route::get('/bdsp/reports', function () {
    return view('bdsp.reports'); // placeholder view
})->name('bdsp.reports');

// Messages
Route::get('/bdsp/messages', function () {
    return view('bdsp.messages'); // placeholder view
})->name('bdsp.messages');

Route::get('/dashboard/entrepreneur-messages', function () {
    return view('dashboard.entrepreneur-messages');
})->middleware('auth')->name('entrepreneur.messages');

Route::get('/dashboard/entrepreneur-hub', function () {
    return view('dashboard.entrepreneur-hub');
})->middleware('auth')->name('entrepreneur.hub');

// Entrepreneur Dashboard Sections
Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard/entrepreneur-progress', 'dashboard.entrepreneur-progress')->name('entrepreneur.progress');
    Route::view('/dashboard/entrepreneur-calendar', 'dashboard.entrepreneur-calendar')->name('entrepreneur.calendar');
    Route::view('/dashboard/entrepreneur-mentorship', 'dashboard.entrepreneur-mentorship')->name('entrepreneur.mentorship');
    Route::view('/dashboard/entrepreneur-pitch', 'dashboard.entrepreneur-pitch')->name('entrepreneur.pitch');
    Route::view('/dashboard/entrepreneur-feedback', 'dashboard.entrepreneur-feedback')->name('entrepreneur.feedback');
});

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

Route::get('/registration-success', function () {
    return view('auth.registration-success');
})->name('registration.success');
