<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvestorRegisterController;
use App\Http\Controllers\BDSPRegisterController;
use App\Http\Controllers\EntrepreneurRegisterController;
use App\Http\Controllers\AdminDashboardController;

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
