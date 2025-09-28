<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConsultantProfileController;
use App\Http\Controllers\AdminConsultantController;

// Public pages
Route::get('/', fn() => view('home'))->name('home');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/services', fn() => view('services'))->name('services');

// Signup routes
Route::get('/signup', [SignupController::class, 'show'])->name('signup');
Route::post('/signup', [SignupController::class, 'store']);

// Login routes
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

// Logout route
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Protected dashboard route
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

use App\Http\Controllers\RoleController;

Route::middleware(['auth'])->group(function () {
    Route::get('/select-role', [RoleController::class, 'show'])->name('role.select');
    Route::post('/select-role', [RoleController::class, 'save'])->name('role.save');
});

// Role-protected dashboards
Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('/dashboard/customer', [DashboardController::class, 'customer'])->name('dashboard.customer');
});
Route::middleware(['auth', 'role:Consultant'])->group(function () {
    Route::get('/dashboard/consultant', [DashboardController::class, 'consultant'])->name('dashboard.consultant');
    Route::get('/consultant/rules', [ConsultantProfileController::class, 'rules'])->name('consultant.rules');
    Route::post('/consultant/rules', [ConsultantProfileController::class, 'acceptRules'])->name('consultant.rules.accept');
    Route::get('/consultant/profile', [ConsultantProfileController::class, 'profile'])->name('consultant.profile');
    Route::post('/consultant/profile', [ConsultantProfileController::class, 'saveProfile'])->name('consultant.profile.save');
});
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/admin/consultants/pending', [AdminConsultantController::class, 'index'])->name('admin.consultants.pending');
    Route::post('/admin/consultants/{id}/approve', [AdminConsultantController::class, 'approve'])->name('admin.consultants.approve');
    Route::post('/admin/consultants/{id}/reject', [AdminConsultantController::class, 'reject'])->name('admin.consultants.reject');
    Route::get('/admin/consultants', [AdminConsultantController::class, 'consultants'])->name('admin.consultants');
    Route::get('/admin/customers', [AdminConsultantController::class, 'customers'])->name('admin.customers');
    
    // New admin pages
    Route::get('/admin/manage-users', function() {
        $consultants = \App\Models\ConsultantProfile::with('user')->get();
        $customers = \App\Models\User::where('role', 'Customer')->get();
        $pending = \App\Models\ConsultantProfile::where('is_verified', false)->where('is_rejected', false)->get();
        
        return view('admin-folder.manage-users', compact('consultants', 'customers', 'pending'));
    })->name('admin.manage-users');
    
    Route::get('/admin/consultations', function() {
        return view('admin-folder.consultations');
    })->name('admin.consultations');
    
    Route::get('/admin/reports', function() {
        return view('admin-folder.reports');
    })->name('admin.reports');
    
    Route::get('/admin/settings', function() {
        return view('admin-folder.settings');
    })->name('admin.settings');
});