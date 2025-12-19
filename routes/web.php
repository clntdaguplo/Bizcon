<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
        ->where('is_rejected', false) // Exclude suspended consultants
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
    Route::middleware(['trial_access'])->group(function () {
        Route::get('/dashboard/customer', [DashboardController::class, 'customer'])->name('dashboard.customer');
        // Friendly aliases per request
        Route::get('/customer/dashboard', [DashboardController::class, 'customer'])->name('customer.dashboard');
        // Customer dashboard subpages
        // View all consultants by expertise area (Customer)
        Route::get('/customer/expertise/{expertise}', function($expertise) {
            $decodedExpertise = urldecode($expertise);
            
            // Get all verified consultants with this expertise
            $consultants = \App\Models\ConsultantProfile::with('user')
                ->where('is_verified', true)
                ->where('is_rejected', false)
                ->where(function($q) use ($decodedExpertise) {
                    $q->where('expertise', 'like', '%' . $decodedExpertise . '%');
                })
                ->get();
            
            // Calculate stats for each consultant
            $allConsultations = \App\Models\Consultation::all();
            foreach ($consultants as $consultant) {
                $completedCount = $allConsultations->where('consultant_profile_id', $consultant->id)
                    ->where('status', 'Completed')
                    ->count();
                $consultant->completed_count = $completedCount;
                
                // Get ratings
                $ratings = \App\Models\ConsultationRating::whereHas('consultation', function($q) use ($consultant) {
                    $q->where('consultant_profile_id', $consultant->id);
                })
                ->where('rater_type', 'customer')
                ->get();
                
                $consultant->average_rating = $ratings->count() > 0 ? round($ratings->avg('rating'), 1) : null;
                $consultant->total_ratings = $ratings->count();
            }
            
            // Sort by completed count (highest first)
            $consultants = $consultants->sortByDesc('completed_count')->values();
            
            $topConsultant = $consultants->first();
            
            return view('customer-folder.consultants-by-expertise', compact('consultants', 'decodedExpertise', 'topConsultant'));
        })->name('customer.expertise');

        Route::get('/customer/new-consult', function() {
            // Block new consults if no plan, trial expired/used, or pro pending/rejected/expired
            if (\Illuminate\Support\Facades\Schema::hasTable('subscriptions')) {
                $sub = \App\Models\Subscription::where('user_id', Auth::id())
                    ->orderByDesc('created_at')
                    ->first();
                
                if (!$sub) {
                    return redirect()->route('customer.plans')->withErrors(['error' => 'Please choose a plan (Free Trial or Subscription) to book consultations.']);
                }
                
                $trialUsedUp = $sub->plan_type === 'Free' && (
                    ($sub->expires_at && now()->greaterThanOrEqualTo($sub->expires_at)) ||
                    ($sub->minutes_total ?? 0) <= ($sub->minutes_used ?? 0)
                );
                $hasActivePro = in_array($sub->plan_type, ['Weekly', 'Quarterly', 'Annual']) && 
                    in_array($sub->payment_status, ['approved', 'not_required']) && 
                    $sub->status === 'active' &&
                    (!$sub->expires_at || now()->lessThan($sub->expires_at));
                
                if ($trialUsedUp && !$hasActivePro) {
                    return redirect()->route('customer.plans')->withErrors(['error' => 'Your free trial has been used. Subscribe to continue booking consultations.']);
                }
                
                if (in_array($sub->plan_type, ['Weekly', 'Quarterly', 'Annual']) && $sub->payment_status === 'rejected') {
                    return redirect()->route('customer.plans')->withErrors(['error' => 'Your payment was rejected. Please submit a new payment to continue.']);
                }
                
                if (in_array($sub->plan_type, ['Weekly', 'Quarterly', 'Annual']) && $sub->payment_status === 'pending') {
                    return redirect()->route('customer.plans')->withErrors(['error' => 'Your subscription payment is pending. Please wait for approval to book consultations.']);
                }
                
                if (in_array($sub->plan_type, ['Weekly', 'Quarterly', 'Annual']) && $sub->expires_at && now()->greaterThanOrEqualTo($sub->expires_at)) {
                    return redirect()->route('customer.plans')->withErrors(['error' => 'Your subscription has expired. Please renew to continue booking consultations.']);
                }
            }
            
            $selectedConsultant = null;
            if (request()->filled('consultant')) {
                $selectedConsultant = \App\Models\ConsultantProfile::where('is_verified', true)
                    ->where('is_rejected', false)
                    ->with('user')
                    ->find(request('consultant'));
                
                // Calculate ratings if consultant is selected
                if ($selectedConsultant) {
                    $ratings = \App\Models\ConsultationRating::whereHas('consultation', function($q) use ($selectedConsultant) {
                        $q->where('consultant_profile_id', $selectedConsultant->id);
                    })
                    ->where('rater_type', 'customer')
                    ->get();
                    
                    if ($ratings->count() > 0) {
                        $selectedConsultant->average_rating = round($ratings->avg('rating'), 1);
                        $selectedConsultant->total_ratings = $ratings->count();
                    } else {
                        $selectedConsultant->average_rating = null;
                        $selectedConsultant->total_ratings = 0;
                    }
                }
            }
            return view('customer-folder.new-consult', compact('selectedConsultant'));
        })->name('customer.new-consult');
        Route::get('/customer/new_consult', function() {
            // Block new consults if no plan, trial expired/used, or pro pending/rejected/expired
            if (\Illuminate\Support\Facades\Schema::hasTable('subscriptions')) {
                $sub = \App\Models\Subscription::where('user_id', Auth::id())
                    ->orderByDesc('created_at')
                    ->first();
                
                if (!$sub) {
                    return redirect()->route('customer.plans')->withErrors(['error' => 'Please choose a plan (Free Trial or Subscription) to book consultations.']);
                }
                
                $trialUsedUp = $sub->plan_type === 'Free' && (
                    ($sub->expires_at && now()->greaterThanOrEqualTo($sub->expires_at)) ||
                    ($sub->minutes_total ?? 0) <= ($sub->minutes_used ?? 0)
                );
                $hasActivePro = in_array($sub->plan_type, ['Weekly', 'Quarterly', 'Annual']) && 
                    in_array($sub->payment_status, ['approved', 'not_required']) && 
                    $sub->status === 'active' &&
                    (!$sub->expires_at || now()->lessThan($sub->expires_at));
                
                if ($trialUsedUp && !$hasActivePro) {
                    return redirect()->route('customer.plans')->withErrors(['error' => 'Your free trial has been used. Subscribe to continue booking consultations.']);
                }
                
                if (in_array($sub->plan_type, ['Weekly', 'Quarterly', 'Annual']) && $sub->payment_status === 'rejected') {
                    return redirect()->route('customer.plans')->withErrors(['error' => 'Your payment was rejected. Please submit a new payment to continue.']);
                }
                
                if (in_array($sub->plan_type, ['Weekly', 'Quarterly', 'Annual']) && $sub->payment_status === 'pending') {
                    return redirect()->route('customer.plans')->withErrors(['error' => 'Your subscription payment is pending. Please wait for approval to book consultations.']);
                }
                
                if (in_array($sub->plan_type, ['Weekly', 'Quarterly', 'Annual']) && $sub->expires_at && now()->greaterThanOrEqualTo($sub->expires_at)) {
                    return redirect()->route('customer.plans')->withErrors(['error' => 'Your subscription has expired. Please renew to continue booking consultations.']);
                }
            }
            return view('customer-folder.new-consult');
        })->name('customer.new_consult');

        Route::post('/customer/new-consult', [ConsultationController::class, 'store'])->name('customer.consultations.store');

        Route::get('/customer/my-consults', [\App\Http\Controllers\ConsultationController::class, 'customerHistory'])->name('customer.my-consults');
        Route::get('/customer/my_consults', [\App\Http\Controllers\ConsultationController::class, 'customerHistory'])->name('customer.my_consults');
        
        // View consultation details
        Route::get('/customer/consultations/{id}', [ConsultationController::class, 'show'])->name('customer.consultations.show');
        
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

        // Messaging routes for customers
        Route::post('/customer/consultations/{id}/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('customer.consultations.messages.store');
        Route::get('/customer/consultations/{id}/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('customer.consultations.messages.index');

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
    
    // Subscription plans (Outside trial_access)
    Route::get('/customer/plans', [\App\Http\Controllers\SubscriptionController::class, 'show'])->name('customer.plans');
    Route::post('/customer/plans', [\App\Http\Controllers\SubscriptionController::class, 'choose'])->name('customer.plans.choose');
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
    Route::post('/consultant/profile/cancel-update', [ConsultantProfileController::class, 'cancelUpdate'])->name('consultant.profile.cancel-update');
    
    // Consultation response actions
    Route::post('/consultant/consultations/{id}/accept', [ConsultationController::class, 'acceptConsultation'])->name('consultant.consultations.accept');
    Route::post('/consultant/consultations/{id}/reject', [ConsultationController::class, 'rejectConsultation'])->name('consultant.consultations.reject');
    Route::post('/consultant/consultations/{id}/complete', [ConsultationController::class, 'completeConsultation'])->name('consultant.consultations.complete');
    Route::post('/consultant/consultations/{id}/respond', [ConsultationController::class, 'respondToConsultation'])->name('consultant.consultations.respond');
    Route::post('/consultant/consultations/{id}/generate-meet-link', [ConsultationController::class, 'generateMeetLink'])->name('consultant.consultations.generate-meet-link');
    
    // Report routes
    // Consultant views to create/edit report (form)
    Route::get('/consultant/consultations/{id}/report', [ConsultationController::class, 'showReportForm'])->name('consultant.consultations.report');
    // Consultant views final report (PDF-style page) in a new tab
    Route::get('/consultant/consultations/{id}/report/view', [ConsultationController::class, 'downloadReport'])->name('consultant.consultations.report.view');
    Route::post('/consultant/consultations/{id}/report', [ConsultationController::class, 'saveReport'])->name('consultant.consultations.save-report');
    
    // Rating routes
    Route::get('/consultant/consultations/{id}/rate', [ConsultationController::class, 'showRatingForm'])->name('consultant.consultations.rate');
    Route::post('/consultant/consultations/{id}/rate', [ConsultationController::class, 'saveRating'])->name('consultation.rating.save');

    // Messaging routes for consultants
    Route::post('/consultant/consultations/{id}/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('consultant.consultations.messages.store');
    Route::get('/consultant/consultations/{id}/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('consultant.consultations.messages.index');
    
    // Consultant-Admin Messaging routes
    Route::get('/consultant/messages/admin', function() {
        $profile = \App\Models\ConsultantProfile::where('user_id', Auth::id())->first();
        if (!$profile) {
            return back()->withErrors(['error' => 'Profile not found. Please complete your profile first.']);
        }
        return view('consultant-folder.messages-admin');
    })->name('consultant.messages.admin');
    Route::post('/consultant/messages/admin/{id}', [\App\Http\Controllers\AdminConsultantMessageController::class, 'consultantStore'])->name('consultant.messages.admin.store');
    Route::get('/consultant/messages/admin/{id}/api', [\App\Http\Controllers\AdminConsultantMessageController::class, 'index'])->name('consultant.messages.admin.index');
    
    // View all consultants by expertise area
    Route::get('/consultant/expertise/{expertise}', function($expertise) {
        $decodedExpertise = urldecode($expertise);
        
        // Normalize casing against predefined list
        $defaultExpertiseAreas = [
            'Business Strategy', 'Startup & Entrepreneurship', 'Marketing & Branding', 
            'Financial & Investment', 'Technology & IT Support', 'Legal Consultation', 
            'Human Resources (HR) Consultation', 'E-commerce & Online Business', 
            'Career & Professional Development', 'Healthcare & Wellness'
        ];
        foreach ($defaultExpertiseAreas as $defaultArea) {
            if (strtolower($decodedExpertise) === strtolower($defaultArea)) {
                $decodedExpertise = $defaultArea;
                break;
            }
        }
        
        // Get all verified consultants with this expertise
        $consultants = \App\Models\ConsultantProfile::with('user')
            ->where('is_verified', true)
            ->where('is_rejected', false)
            ->where(function($q) use ($decodedExpertise) {
                $q->where('expertise', 'like', '%' . $decodedExpertise . '%');
            })
            ->get();
        
        // Calculate stats for each consultant
        $allConsultations = \App\Models\Consultation::all();
        foreach ($consultants as $consultant) {
            $completedCount = $allConsultations->where('consultant_profile_id', $consultant->id)
                ->where('status', 'Completed')
                ->count();
            $consultant->completed_count = $completedCount;
            
            // Get ratings
            $ratings = \App\Models\ConsultationRating::whereHas('consultation', function($q) use ($consultant) {
                $q->where('consultant_profile_id', $consultant->id);
            })
            ->where('rater_type', 'customer')
            ->get();
            
            $consultant->average_rating = $ratings->count() > 0 ? round($ratings->avg('rating'), 1) : null;
            $consultant->total_ratings = $ratings->count();
        }
        
        // Sort by completed count (highest first)
        $consultants = $consultants->sortByDesc('completed_count')->values();
        
        $topConsultant = $consultants->first();
        
        return view('consultant-folder.consultants-by-expertise', compact('consultants', 'decodedExpertise', 'topConsultant'));
    })->name('consultant.expertise');
});
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    
    // Reports
    Route::get('/admin/reports', [\App\Http\Controllers\AdminReportController::class, 'index'])->name('admin.reports');
    Route::get('/admin/reports/export', [\App\Http\Controllers\AdminReportController::class, 'export'])->name('admin.reports.export');
    


    // View all consultants by expertise area
    Route::get('/admin/consultants/expertise/{expertise}', function($expertise) {
        $decodedExpertise = urldecode($expertise);
        
        // Normalize casing against predefined list
        $defaultExpertiseAreas = [
            'Business Strategy', 'Startup & Entrepreneurship', 'Marketing & Branding', 
            'Financial & Investment', 'Technology & IT Support', 'Legal Consultation', 
            'Human Resources (HR) Consultation', 'E-commerce & Online Business', 
            'Career & Professional Development', 'Healthcare & Wellness'
        ];
        foreach ($defaultExpertiseAreas as $defaultArea) {
            if (strtolower($decodedExpertise) === strtolower($defaultArea)) {
                $decodedExpertise = $defaultArea;
                break;
            }
        }
        
        // Get all verified consultants with this expertise
        $consultants = \App\Models\ConsultantProfile::with('user')
            ->where('is_verified', true)
            ->where('is_rejected', false)
            ->where(function($q) use ($decodedExpertise) {
                $q->where('expertise', 'like', '%' . $decodedExpertise . '%');
            })
            ->get();
        
        // Calculate stats for each consultant
        foreach ($consultants as $consultant) {
            $completedCount = \App\Models\Consultation::where('consultant_profile_id', $consultant->id)
                ->where('status', 'Completed')
                ->count();
            $consultant->completed_count = $completedCount;
            
            // Get ratings
            $ratings = \App\Models\ConsultationRating::whereHas('consultation', function($q) use ($consultant) {
                $q->where('consultant_profile_id', $consultant->id);
            })
            ->where('rater_type', 'customer')
            ->get();
            
            $consultant->average_rating = $ratings->count() > 0 ? round($ratings->avg('rating'), 1) : null;
            $consultant->total_ratings = $ratings->count();
        }
        
        // Sort by completed count (highest first)
        $consultants = $consultants->sortByDesc('completed_count')->values();
        
        $topConsultant = $consultants->first();
        
        return view('admin-folder.consultants-by-expertise', compact('consultants', 'decodedExpertise', 'topConsultant'));
    })->name('admin.consultants.expertise');

    // View consultants by category (month, rated, rising, booked)
    Route::get('/admin/consultants/category/{category}', function($category) {
        $consultants = collect([]);
        $title = '';
        $desc = '';
        $statLabel = '';
        $topConsultant = null;

        // Common query for verified consultants
        $query = \App\Models\ConsultantProfile::with('user')
            ->where('is_verified', true)
            ->where('is_rejected', false);

        switch($category) {
            case 'month':
                $title = 'Consultants of the Month';
                $desc = 'Top performers for ' . now()->format('F Y');
                $statLabel = 'Consultations this month';
                
                // Get consultants with completed consultations this month
                $consultants = $query->get()->map(function($c) {
                    $count = \App\Models\Consultation::where('consultant_profile_id', $c->id)
                        ->where('status', 'Completed')
                        ->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)
                        ->count();
                    $c->stat_value = $count;
                    // Also get rating
                    $ratings = \App\Models\ConsultationRating::whereHas('consultation', function($q) use ($c) {
                        $q->where('consultant_profile_id', $c->id);
                    })->where('rater_type', 'customer')->get();
                    $c->average_rating = $ratings->count() > 0 ? round($ratings->avg('rating'), 1) : null;
                    return $c;
                })->filter(function($c) {
                    return $c->stat_value > 0;
                })->sortByDesc('stat_value')->values();
                break;

            case 'rated':
                $title = 'Highest Rated Consultants';
                $desc = 'Top rated professionals based on customer reviews';
                $statLabel = 'Average Rating';
                
                $consultants = $query->get()->map(function($c) {
                    $ratings = \App\Models\ConsultationRating::whereHas('consultation', function($q) use ($c) {
                        $q->where('consultant_profile_id', $c->id);
                    })->where('rater_type', 'customer')->get();
                    
                    $c->stat_value = $ratings->count() > 0 ? round($ratings->avg('rating'), 1) : 0;
                    $c->average_rating = $c->stat_value; // For display purposes
                    $c->total_ratings = $ratings->count();
                    return $c;
                })->filter(function($c) {
                    return $c->total_ratings > 0;
                })->sortByDesc('stat_value')->values();
                break;

            case 'rising':
                $title = 'Rising Stars';
                $desc = 'Top performing new consultants (joined in last 3 months)';
                $statLabel = 'Consultations Completed';
                
                $threeMonthsAgo = now()->subMonths(3);
                $consultants = $query->where('created_at', '>=', $threeMonthsAgo)
                    ->get()->map(function($c) {
                        $count = \App\Models\Consultation::where('consultant_profile_id', $c->id)
                            ->where('status', 'Completed')
                            ->count();
                        $c->stat_value = $count;
                        // Also get rating
                        $ratings = \App\Models\ConsultationRating::whereHas('consultation', function($q) use ($c) {
                            $q->where('consultant_profile_id', $c->id);
                        })->where('rater_type', 'customer')->get();
                        $c->average_rating = $ratings->count() > 0 ? round($ratings->avg('rating'), 1) : null;
                        return $c;
                    })->filter(function($c) {
                        return $c->stat_value > 0;
                    })->sortByDesc('stat_value')->values();
                break;

            case 'booked':
                $title = 'Most Booked Consultants';
                $desc = 'All-time booking champions';
                $statLabel = 'Total Consultations';
                
                $consultants = $query->get()->map(function($c) {
                    $count = \App\Models\Consultation::where('consultant_profile_id', $c->id)
                        ->where('status', 'Completed')
                        ->count();
                    $c->stat_value = $count;
                    // Also get rating
                    $ratings = \App\Models\ConsultationRating::whereHas('consultation', function($q) use ($c) {
                        $q->where('consultant_profile_id', $c->id);
                    })->where('rater_type', 'customer')->get();
                    $c->average_rating = $ratings->count() > 0 ? round($ratings->avg('rating'), 1) : null;
                    return $c;
                })->filter(function($c) {
                    return $c->stat_value > 0;
                })->sortByDesc('stat_value')->values();
                break;
        }

        $topConsultant = $consultants->first();
        
        return view('admin-folder.consultants-by-category', compact('consultants', 'title', 'desc', 'category', 'topConsultant', 'statLabel'));
    })->name('admin.consultants.category');
    
    Route::get('/admin/consultants/pending', [AdminConsultantController::class, 'index'])->name('admin.consultants.pending');
    Route::get('/admin/consultants/rejected', [AdminConsultantController::class, 'rejected'])->name('admin.consultants.rejected');
    Route::get('/admin/consultants/suspended', [AdminConsultantController::class, 'suspended'])->name('admin.consultants.suspended');
    Route::post('/admin/consultants/{id}/approve', [AdminConsultantController::class, 'approve'])->name('admin.consultants.approve');
    Route::post('/admin/consultants/{id}/reject', [AdminConsultantController::class, 'reject'])->name('admin.consultants.reject');
    Route::post('/admin/consultants/{id}/suspend', [AdminConsultantController::class, 'suspend'])->name('admin.consultants.suspend');
    Route::post('/admin/consultants/{id}/unsuspend', [AdminConsultantController::class, 'unsuspend'])->name('admin.consultants.unsuspend');
    Route::post('/admin/consultants/{id}/approve-update', [AdminConsultantController::class, 'approveUpdate'])->name('admin.consultants.approve-update');
    Route::post('/admin/consultants/{id}/reject-update', [AdminConsultantController::class, 'rejectUpdate'])->name('admin.consultants.reject-update');
    Route::get('/admin/consultants', [AdminConsultantController::class, 'consultants'])->name('admin.consultants');
    Route::get('/admin/consultants/{id}', [AdminConsultantController::class, 'show'])->name('admin.consultants.show');
    
    // Admin-Consultant Messaging routes
    Route::get('/admin/consultants/{id}/messages', [\App\Http\Controllers\AdminConsultantMessageController::class, 'showMessages'])->name('admin.consultants.messages');
    Route::post('/admin/consultants/{id}/messages', [\App\Http\Controllers\AdminConsultantMessageController::class, 'adminStore'])->name('admin.consultants.messages.store');
    Route::get('/admin/consultants/{id}/messages/api', [\App\Http\Controllers\AdminConsultantMessageController::class, 'index'])->name('admin.consultants.messages.index');
    Route::get('/admin/customers', [AdminConsultantController::class, 'customers'])->name('admin.customers');
    Route::get('/admin/customers/suspended', [AdminConsultantController::class, 'customersSuspended'])->name('admin.customers.suspended');
    Route::post('/admin/customers/{id}/suspend', [AdminConsultantController::class, 'suspendCustomer'])->name('admin.customers.suspend');
    Route::post('/admin/customers/{id}/unsuspend', [AdminConsultantController::class, 'unsuspendCustomer'])->name('admin.customers.unsuspend');
    Route::get('/admin/customers/{id}', function ($id) {
        $customer = \App\Models\User::where('role', 'Customer')
            ->with(['subscriptions' => function($q) {
                $q->orderByDesc('created_at')->limit(1);
            }])
            ->findOrFail($id);
        return view('admin-folder.customer-profile', compact('customer'));
    })->name('admin.customers.show');
    
    // New admin pages
    Route::get('/admin/manage-users', function() {
        $consultants = \App\Models\ConsultantProfile::with('user')->where('is_verified', true)->get();
        $customers = \App\Models\User::where('role', 'Customer')->get();
        $pending = \App\Models\ConsultantProfile::where('is_verified', false)->where('is_rejected', false)->get();
        $pendingUpdates = \App\Models\ConsultantProfile::where('has_pending_update', true)->count();
        
        return view('admin-folder.manage-users', compact('consultants', 'customers', 'pending', 'pendingUpdates'));
    })->name('admin.manage-users');
    
    Route::get('/admin/consultations', function(Request $request) {
        $query = $request->get('search', '');
        $status = $request->get('status', '');
        $dateFilter = $request->get('date_filter', '');
        
        // Get statistics from the database (total counts)
        $baseQuery = \App\Models\Consultation::query();
        
        // Apply same filters for statistics
        $statsQuery = clone $baseQuery;
        if ($query) {
            $statsQuery->where(function($sub) use ($query) {
                $sub->where('topic', 'like', "%{$query}%")
                    ->orWhereHas('consultantProfile.user', function($userQuery) use ($query) {
                        $userQuery->where('name', 'like', "%{$query}%")
                                  ->orWhere('email', 'like', "%{$query}%");
                    })
                    ->orWhereHas('customer', function($customerQuery) use ($query) {
                        $customerQuery->where('name', 'like', "%{$query}%")
                                     ->orWhere('email', 'like', "%{$query}%");
                    });
            });
        }
        if ($dateFilter === 'today') {
            $statsQuery->whereDate('created_at', today());
        } elseif ($dateFilter === 'week') {
            $statsQuery->where('created_at', '>=', now()->startOfWeek());
        } elseif ($dateFilter === 'month') {
            $statsQuery->where('created_at', '>=', now()->startOfMonth());
        }
        
        // Get statistics
        $totalCount = (clone $statsQuery)->count();
        $completedCount = (clone $statsQuery)->where('status', 'Completed')->count();
        $inProgressCount = (clone $statsQuery)->where('status', 'Accepted')->count();
        $cancelledCount = (clone $statsQuery)->where('status', 'Cancelled')->count();
        
        // Fetch consultations with filters
        $consultations = \App\Models\Consultation::with(['consultantProfile.user', 'customer'])
            ->when($query, function($q) use ($query) {
                $q->where(function($sub) use ($query) {
                    $sub->where('topic', 'like', "%{$query}%")
                        ->orWhereHas('consultantProfile.user', function($userQuery) use ($query) {
                            $userQuery->where('name', 'like', "%{$query}%")
                                      ->orWhere('email', 'like', "%{$query}%");
                        })
                        ->orWhereHas('customer', function($customerQuery) use ($query) {
                            $customerQuery->where('name', 'like', "%{$query}%")
                                         ->orWhere('email', 'like', "%{$query}%");
                        });
                });
            })
            ->when($status === 'completed', function($q) {
                $q->where('status', 'Completed');
            })
            ->when($status === 'in-progress', function($q) {
                $q->where('status', 'Accepted');
            })
            ->when($status === 'cancelled', function($q) {
                $q->where('status', 'Cancelled');
            })
            ->when($status === 'pending', function($q) {
                $q->where('status', 'Pending');
            })
            ->when($dateFilter === 'today', function($q) {
                $q->whereDate('created_at', today());
            })
            ->when($dateFilter === 'week', function($q) {
                $q->where('created_at', '>=', now()->startOfWeek());
            })
            ->when($dateFilter === 'month', function($q) {
                $q->where('created_at', '>=', now()->startOfMonth());
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->appends($request->query());
        
        // Get recent activity - focus on completed sessions and status changes
        $recentActivity = \App\Models\Consultation::with(['consultantProfile.user', 'customer'])
            ->where(function($q) {
                $q->where('status', 'Completed')
                  ->orWhere(function($sub) {
                      // Get consultations that changed status recently (check updated_at vs created_at)
                      $sub->whereColumn('updated_at', '>', 'created_at')
                          ->whereIn('status', ['Completed', 'Accepted', 'Cancelled', 'Rejected']);
                  });
            })
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();
        
        return view('admin-folder.consultations', compact('consultations', 'totalCount', 'completedCount', 'inProgressCount', 'cancelledCount', 'recentActivity'));
    })->name('admin.consultations');

    Route::get('/admin/consultations/{id}', [ConsultationController::class, 'showAdmin'])
        ->name('admin.consultations.show');
    

    
    Route::get('/admin/settings', function() {
        return view('admin-folder.settings');
    })->name('admin.settings');
    
    // Payment approvals
    Route::get('/admin/payments', [\App\Http\Controllers\AdminSubscriptionController::class, 'index'])->name('admin.payments');
    Route::post('/admin/payments/{id}/approve', [\App\Http\Controllers\AdminSubscriptionController::class, 'approve'])->name('admin.payments.approve');
    Route::post('/admin/payments/{id}/reject', [\App\Http\Controllers\AdminSubscriptionController::class, 'reject'])->name('admin.payments.reject');
});