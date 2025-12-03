<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConsultantProfileController;
use App\Http\Controllers\AdminConsultantController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\CustomerConsultantController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\RoleController;

// Public pages
Route::get('/', fn() => view('home'))->name('home');
Route::get('/about', fn() => redirect('/#about'))->name('about');
Route::get('/services', fn() => redirect('/#services'))->name('services');

// Public consultants page
Route::get('/consultants', function() {
    $query = request('q');
    $consultants = \App\Models\ConsultantProfile::with('user')
        ->where('is_verified', true)
        ->when($query, function($q) use ($query) {
            $normalized = mb_strtolower($query);
            $q->where(function($sub) use ($normalized, $query) {
                $sub->whereRaw('LOWER(expertise) = ?', [$normalized])
                    ->orWhere('full_name', 'like', "%".$query."%");
            });
        })
        ->orderByDesc('updated_at')
        ->paginate(12)
        ->appends(['q' => $query]);
    
    // Calculate average ratings for each consultant
    foreach ($consultants as $consultant) {
        $ratings = \App\Models\ConsultationRating::whereHas('consultation', function($q) use ($consultant) {
            $q->where('consultant_profile_id', $consultant->id);
        })
        ->where('rater_type', 'customer')
        ->get();
        
        if ($ratings->count() > 0) {
            $consultant->average_rating = round($ratings->avg('rating'), 1);
            $consultant->total_ratings = $ratings->count();
        } else {
            $consultant->average_rating = null;
            $consultant->total_ratings = 0;
        }
    }
    
    return view('consultants', compact('consultants', 'query'));
})->name('consultants');

// Public API for consultants (used for live search on landing & public consultants page)
Route::get('/consultants/api/all', [CustomerConsultantController::class, 'getAllConsultants'])
    ->name('public.consultants.api.all');

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

// Protected dashboard route + generic auth-only routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Generic notification redirector for all roles
    Route::get('/notifications/{id}/go', [NotificationController::class, 'go'])->name('notifications.go');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/select-role', [RoleController::class, 'show'])->name('role.select');
    Route::post('/select-role', [RoleController::class, 'save'])->name('role.save');
});

// Role-protected dashboards
Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('/dashboard/customer', [DashboardController::class, 'customer'])->name('dashboard.customer');
    // Friendly aliases per request
    Route::get('/customer/dashboard', [DashboardController::class, 'customer'])->name('customer.dashboard');
    // Customer dashboard subpages
    Route::get('/customer/new-consult', function() {
        $selectedConsultant = null;
        if (request()->filled('consultant')) {
            $selectedConsultant = \App\Models\ConsultantProfile::where('is_verified', true)
                ->with('user')
                ->find(request('consultant'));
        }
        return view('customer-folder.new-consult', compact('selectedConsultant'));
    })->name('customer.new-consult');
    Route::get('/customer/new_consult', function() {
        return view('customer-folder.new-consult');
    })->name('customer.new_consult');

    Route::post('/customer/new-consult', [ConsultationController::class, 'store'])->name('customer.consultations.store');

    Route::get('/customer/my-consults', [\App\Http\Controllers\ConsultationController::class, 'customerHistory'])->name('customer.my-consults');
    Route::get('/customer/my_consults', [\App\Http\Controllers\ConsultationController::class, 'customerHistory'])->name('customer.my_consults');
    
    // Client response to consultant's proposed schedule
    Route::post('/customer/consultations/{id}/respond-proposal', [ConsultationController::class, 'respondToProposal'])->name('customer.consultations.respond-proposal');
    // Client cancels their consultation
    Route::post('/customer/consultations/{id}/cancel', [ConsultationController::class, 'cancelByCustomer'])->name('customer.consultations.cancel');
    // Client edits their consultation request
    Route::get('/customer/consultations/{id}/edit', [ConsultationController::class, 'edit'])->name('customer.consultations.edit');
    Route::put('/customer/consultations/{id}', [ConsultationController::class, 'update'])->name('customer.consultations.update');
    
    // Download consultation report
    Route::get('/customer/consultations/{id}/report', [ConsultationController::class, 'downloadReport'])->name('customer.consultations.report');
    
    // Rating routes
    Route::get('/customer/consultations/{id}/rate', [ConsultationController::class, 'showRatingForm'])->name('customer.consultations.rate');
    Route::post('/customer/consultations/{id}/rate', [ConsultationController::class, 'saveRating'])->name('consultation.rating.save');

    Route::get('/customer/profile', [CustomerProfileController::class, 'edit'])->name('customer.profile');
    Route::put('/customer/profile', [CustomerProfileController::class, 'update'])->name('customer.profile.update');

    // Customers: see all consultants (verified only)
    Route::get('/customer/consultants', [CustomerConsultantController::class, 'index'])->name('customer.consultants');
    
    // API endpoints for consultants
    Route::get('/customer/consultants/api/all', [CustomerConsultantController::class, 'getAllConsultants'])->name('customer.consultants.api.all');
    Route::get('/customer/consultants/api/stats', [CustomerConsultantController::class, 'getStats'])->name('customer.consultants.api.stats');

    // Shortcut: click Request on a consultant card to open prefilled form
    Route::get('/customer/consultants/{id}/request', [CustomerConsultantController::class, 'requestConsultation'])->name('customer.consultants.request');
});
Route::middleware(['auth', 'role:Consultant'])->group(function () {
    Route::get('/dashboard/consultant', [DashboardController::class, 'consultant'])->name('dashboard.consultant');
    Route::get('/consultant/rules', [ConsultantProfileController::class, 'rules'])->name('consultant.rules');
    Route::post('/consultant/rules', [ConsultantProfileController::class, 'acceptRules'])->name('consultant.rules.accept');
    Route::get('/consultant/profile', [ConsultantProfileController::class, 'profile'])->name('consultant.profile');
    Route::post('/consultant/profile', [ConsultantProfileController::class, 'saveProfile'])->name('consultant.profile.save');

    // Google OAuth connect for consultants
    Route::get('/google/connect', [\App\Http\Controllers\GoogleController::class, 'connect'])->name('google.connect');
    Route::get('/google/callback', [\App\Http\Controllers\GoogleController::class, 'callback'])->name('google.callback');

    // Consultant: inbox of consultation requests
    Route::get('/consultant/consultations', [ConsultationController::class, 'consultantInbox'])->name('consultant.consultations');
    
    // New consultant pages
    Route::get('/consultant/respond', function() {
        $profile = \App\Models\ConsultantProfile::where('user_id', Auth::id())->firstOrFail();
        $pending_consultations = \App\Models\Consultation::with('customer')
            ->where('consultant_profile_id', $profile->id)
            ->where('status', 'Pending')
            ->orderByDesc('created_at')
            ->get();
        return view('consultant-folder.respond', compact('pending_consultations'));
    })->name('consultant.respond');

    // Open a single consultation request to schedule meeting
    Route::get('/consultant/consultations/{id}/open', [\App\Http\Controllers\ConsultationController::class, 'openRequest'])->name('consultant.consultations.open');
    
    Route::get('/consultant/profile/manage', function() {
        $profile = \App\Models\ConsultantProfile::where('user_id', Auth::id())->firstOrFail();

        // Calculate ratings for this consultant (same logic as in ConsultantProfileController@profile)
        $averageRating = null;
        $totalRatings = 0;

        $ratings = \App\Models\ConsultationRating::whereHas('consultation', function($q) use ($profile) {
                $q->where('consultant_profile_id', $profile->id);
            })
            ->where('rater_type', 'customer')
            ->get();

        if ($ratings->count() > 0) {
            $averageRating = round($ratings->avg('rating'), 1);
            $totalRatings = $ratings->count();
        }

        return view('consultant-folder.profile', compact('profile', 'averageRating', 'totalRatings'));
    })->name('consultant.profile.manage');
    
    Route::put('/consultant/profile/update', [ConsultantProfileController::class, 'updateProfile'])->name('consultant.profile.update');
    
    // Consultation response actions
    Route::post('/consultant/consultations/{id}/accept', [ConsultationController::class, 'acceptConsultation'])->name('consultant.consultations.accept');
    Route::post('/consultant/consultations/{id}/reject', [ConsultationController::class, 'rejectConsultation'])->name('consultant.consultations.reject');
    Route::post('/consultant/consultations/{id}/complete', [ConsultationController::class, 'completeConsultation'])->name('consultant.consultations.complete');
    Route::post('/consultant/consultations/{id}/respond', [ConsultationController::class, 'respondToConsultation'])->name('consultant.consultations.respond');
    
    // Report routes
    // Consultant views to create/edit report (form)
    Route::get('/consultant/consultations/{id}/report', [ConsultationController::class, 'showReportForm'])->name('consultant.consultations.report');
    // Consultant views final report (PDF-style page) in a new tab
    Route::get('/consultant/consultations/{id}/report/view', [ConsultationController::class, 'downloadReport'])->name('consultant.consultations.report.view');
    Route::post('/consultant/consultations/{id}/report', [ConsultationController::class, 'saveReport'])->name('consultant.consultations.save-report');
    
    // Rating routes
    Route::get('/consultant/consultations/{id}/rate', [ConsultationController::class, 'showRatingForm'])->name('consultant.consultations.rate');
    Route::post('/consultant/consultations/{id}/rate', [ConsultationController::class, 'saveRating'])->name('consultation.rating.save');
});
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/admin/consultants/pending', [AdminConsultantController::class, 'index'])->name('admin.consultants.pending');
    Route::post('/admin/consultants/{id}/approve', [AdminConsultantController::class, 'approve'])->name('admin.consultants.approve');
    Route::post('/admin/consultants/{id}/reject', [AdminConsultantController::class, 'reject'])->name('admin.consultants.reject');
    Route::post('/admin/consultants/{id}/suspend', [AdminConsultantController::class, 'suspend'])->name('admin.consultants.suspend');
    Route::post('/admin/consultants/{id}/unsuspend', [AdminConsultantController::class, 'unsuspend'])->name('admin.consultants.unsuspend');
    Route::get('/admin/consultants', [AdminConsultantController::class, 'consultants'])->name('admin.consultants');
    Route::get('/admin/consultants/{id}', [AdminConsultantController::class, 'show'])->name('admin.consultants.show');
    Route::get('/admin/customers', [AdminConsultantController::class, 'customers'])->name('admin.customers');
    Route::get('/admin/customers/{id}', function ($id) {
        $customer = \App\Models\User::where('role', 'Customer')->findOrFail($id);
        return view('admin-folder.customer-profile', compact('customer'));
    })->name('admin.customers.show');
    
    // New admin pages
    Route::get('/admin/manage-users', function() {
        $consultants = \App\Models\ConsultantProfile::with('user')->where('is_verified', true)->get();
        $customers = \App\Models\User::where('role', 'Customer')->get();
        $pending = \App\Models\ConsultantProfile::where('is_verified', false)->where('is_rejected', false)->get();
        
        return view('admin-folder.manage-users', compact('consultants', 'customers', 'pending'));
    })->name('admin.manage-users');
    
    Route::get('/admin/consultations', function() {
        $consultations = \App\Models\Consultation::with(['consultantProfile.user', 'customer'])
            ->orderByDesc('created_at')
            ->get();
        return view('admin-folder.consultations', compact('consultations'));
    })->name('admin.consultations');

    Route::get('/admin/consultations/{id}', [ConsultationController::class, 'showAdmin'])
        ->name('admin.consultations.show');
    
    Route::get('/admin/reports', function() {
        $consultations = \App\Models\Consultation::with(['consultantProfile.user', 'customer'])->get();
        $consultants = \App\Models\ConsultantProfile::where('is_verified', true)->with('user')->get();
        $customers = \App\Models\User::where('role', 'Customer')->get();
        
        return view('admin-folder.reports', compact('consultations', 'consultants', 'customers'));
    })->name('admin.reports');

    // Admin report exports
    Route::get('/admin/reports/export/pdf', [AdminReportController::class, 'exportPdf'])->name('admin.reports.export.pdf');
    Route::get('/admin/reports/export/excel', [AdminReportController::class, 'exportExcel'])->name('admin.reports.export.excel');
    Route::get('/admin/reports/export/csv', [AdminReportController::class, 'exportCsv'])->name('admin.reports.export.csv');
    
    Route::get('/admin/settings', function() {
        return view('admin-folder.settings');
    })->name('admin.settings');
});