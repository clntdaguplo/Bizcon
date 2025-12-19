<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Optional: generic dashboard (if used anywhere)
    public function index()
    {
        $user = Auth::user();
        if (is_null($user->role)) {
            return redirect()->route('role.select');
        }

        if ($user->role === 'Admin') {
            return redirect()->route('dashboard.admin');
        }

        if ($user->role === 'Consultant') {
            return redirect()->route('dashboard.consultant');
        }

        return redirect()->route('dashboard.customer');
    }

    // Customer dashboard
    public function customer()
    {
        if (Auth::user()->role !== 'Customer') {
            abort(403, 'Unauthorized');
        }



        $totalVerifiedConsultants = \App\Models\ConsultantProfile::where('is_verified', true)->count();

        // Get customer's consultation statistics
        $customerConsultations = \App\Models\Consultation::where('customer_id', Auth::id())
            ->with(['consultantProfile.user'])
            ->get();
        
        $activeBookings = $customerConsultations->whereIn('status', ['Pending', 'Accepted', 'Proposed'])->count();
        $completedSessions = $customerConsultations->where('status', 'Completed')->count();
        
        // Get recent completed consultations
        $completedConsultations = \App\Models\Consultation::where('customer_id', Auth::id())
            ->where('status', 'Completed')
            ->with(['consultantProfile.user'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Get current subscription
        $subscription = null;

        // ===== Top Consultants Logic =====
        $verifiedConsultants = \App\Models\ConsultantProfile::with('user')
            ->where('is_verified', true)
            ->where('is_rejected', false)
            ->get();

        // Cache completed consultations for performance
        $allCompletedConsultations = \App\Models\Consultation::where('status', 'Completed')->get();

        // Calculate stats for all consultants
        foreach ($verifiedConsultants as $consultant) {
             $consultant->completed_count = $allCompletedConsultations->where('consultant_profile_id', $consultant->id)->count();
             
             // Calculate Rating
             $ratings = \App\Models\ConsultationRating::whereHas('consultation', function($q) use ($consultant) {
                $q->where('consultant_profile_id', $consultant->id);
            })->where('rater_type', 'customer')->get();
            
            $consultant->average_rating = $ratings->avg('rating') ?: 0;
            $consultant->total_ratings = $ratings->count();
        }

        // 1. Get Top 3 Highest Rated Consultants
        $topRatedConsultants = $verifiedConsultants->sortByDesc('average_rating')->take(3);

        // 2. Get Top Consultants by Expertise
        // Define the 10 expertise areas
        $defaultExpertiseAreas = [
            'Business Strategy',
            'Startup & Entrepreneurship',
            'Marketing & Branding',
            'Financial & Investment',
            'Technology & IT Support',
            'Legal Consultation',
            'Human Resources (HR) Consultation',
            'E-commerce & Online Business',
            'Career & Professional Development',
            'Healthcare & Wellness',
        ];
        
        // Parse expertise and group consultants
        $expertiseMap = [];
        foreach ($verifiedConsultants as $consultant) {
            $expertiseList = array_map('trim', explode(',', $consultant->expertise ?? ''));
            foreach ($expertiseList as $exp) {
                if (!empty($exp)) {
                    // Normalize to match predefined list casing if it exists there
                    $normalizedExp = $exp;
                    foreach ($defaultExpertiseAreas as $defaultArea) {
                        if (strtolower($exp) === strtolower($defaultArea)) {
                            $normalizedExp = $defaultArea;
                            break;
                        }
                    }
                    
                    if (!isset($expertiseMap[$normalizedExp])) {
                        $expertiseMap[$normalizedExp] = [];
                    }
                    $expertiseMap[$normalizedExp][] = $consultant;
                }
            }
        }
        
        // Build the final list with default expertise areas
        $topConsultantsByExpertise = collect();
        foreach ($defaultExpertiseAreas as $expertise) {
            if (isset($expertiseMap[$expertise]) && count($expertiseMap[$expertise]) > 0) {
                // Sort by completed count and get top consultant
                usort($expertiseMap[$expertise], function($a, $b) {
                    return $b->completed_count - $a->completed_count; // Note: accessing object property now
                });
                $topConsultantsByExpertise[$expertise] = [
                    'consultant' => $expertiseMap[$expertise][0],
                    'completed_count' => $expertiseMap[$expertise][0]->completed_count
                ];
            } else {
                $topConsultantsByExpertise[$expertise] = null;
            }
        }

        // Get current subscription
        if (\Illuminate\Support\Facades\Schema::hasTable('subscriptions')) {
            $subscription = \App\Models\Subscription::where('user_id', Auth::id())
                ->orderByDesc('created_at')
                ->first();
        }

        return view('customer-folder.dashboard', compact(
            'completedConsultations',
            'subscription',
            'topConsultantsByExpertise',
            'topRatedConsultants'
        ));
    }

    // Consultant dashboard
    public function consultant()
    {
        if (Auth::user()->role !== 'Consultant') {
            abort(403, 'Unauthorized');
        }

        // Route consultants to rules first, then profile, then dashboard
        $profile = \App\Models\ConsultantProfile::firstOrNew(['user_id' => Auth::id()]);
        if (!$profile->exists || !$profile->rules_accepted) {
            return redirect()->route('consultant.rules');
        }
        if (!$profile->resume_path || !$profile->full_name || !$profile->expertise) {
            return redirect()->route('consultant.profile');
        }

        if ($profile->is_verified === false) {
            return view('consultant-folder.pending');
        }

        // Get all consultations for this consultant
        $consultations = \App\Models\Consultation::with('customer')
            ->where('consultant_profile_id', $profile->id)
            ->get();
        
        // Basic stats
        $stats = [
            'pending_consultations' => $consultations->where('status', 'Pending')->count(),
            'accepted_consultations' => $consultations->where('status', 'Accepted')->count(),
            'completed_consultations' => $consultations->where('status', 'Completed')->count(),
            'total_earnings' => $consultations->where('status', 'Completed')->count() * 100,
            'total_consultations' => $consultations->count(),
        ];

        // Get recent consultations
        $recent_consultations = $consultations->sortByDesc('created_at')->take(5);

        // ===== NEW: Monthly Performance Data (last 6 months) =====
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = $consultations->filter(function($c) use ($month) {
                return $c->created_at->format('Y-m') === $month->format('Y-m');
            })->count();
            $completed = $consultations->filter(function($c) use ($month) {
                return $c->created_at->format('Y-m') === $month->format('Y-m') && $c->status === 'Completed';
            })->count();
            $monthlyData[] = [
                'month' => $month->format('M Y'),
                'short' => $month->format('M'),
                'count' => $count,
                'completed' => $completed
            ];
        }

        // ===== NEW: Status Breakdown =====
        $statusBreakdown = $consultations->groupBy('status')
            ->map(function($group) {
                return $group->count();
            });

        // ===== NEW: Top Topics =====
        $topTopics = $consultations->groupBy('topic')
            ->map(function($group) {
                return $group->count();
            })
            ->sortByDesc(function($count) {
                return $count;
            })
            ->take(5);

        // ===== NEW: Ratings & Reviews =====
        $ratings = \App\Models\ConsultationRating::whereHas('consultation', function($q) use ($profile) {
            $q->where('consultant_profile_id', $profile->id);
        })->where('rater_type', 'customer')->get();

        $averageRating = $ratings->count() > 0 ? round($ratings->avg('rating'), 1) : null;
        $totalRatings = $ratings->count();
        
        // Rating distribution
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingDistribution[$i] = $ratings->where('rating', $i)->count();
        }

        // ===== NEW: Today's Schedule =====
        $today = now()->format('Y-m-d');
        $todayConsultations = $consultations->filter(function($c) use ($today) {
            if ($c->scheduled_date) {
                $scheduledDate = $c->scheduled_date instanceof \Carbon\Carbon 
                    ? $c->scheduled_date->format('Y-m-d') 
                    : \Carbon\Carbon::parse($c->scheduled_date)->format('Y-m-d');
                return $scheduledDate === $today && in_array($c->status, ['Accepted', 'Pending', 'Proposed']);
            }
            return false;
        })->sortBy(function($c) {
            return $c->scheduled_time;
        })->values();

        // ===== NEW: Upcoming Consultations (next 7 days) =====
        $upcomingConsultations = $consultations->filter(function($c) {
            if ($c->scheduled_date && in_array($c->status, ['Accepted', 'Proposed'])) {
                $scheduledDate = $c->scheduled_date instanceof \Carbon\Carbon 
                    ? $c->scheduled_date 
                    : \Carbon\Carbon::parse($c->scheduled_date);
                return $scheduledDate->isFuture() || $scheduledDate->isToday();
            }
            return false;
        })->sortBy('scheduled_date')->take(5);

        // ===== NEW: This Month vs Last Month Comparison =====
        $thisMonth = now()->format('Y-m');
        $lastMonth = now()->subMonth()->format('Y-m');
        
        $thisMonthCount = $consultations->filter(function($c) use ($thisMonth) {
            return $c->created_at->format('Y-m') === $thisMonth;
        })->count();
        
        $lastMonthCount = $consultations->filter(function($c) use ($lastMonth) {
            return $c->created_at->format('Y-m') === $lastMonth;
        })->count();
        
        $monthlyGrowth = $lastMonthCount > 0 ? round((($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100) : 0;

        // ===== NEW: Top Consultants by Area of Expertise =====
        $allConsultations = \App\Models\Consultation::with('consultantProfile.user')->get();
        
        // Define the 10 expertise areas to display
        $defaultExpertiseAreas = [
            'Business Strategy',
            'Startup & Entrepreneurship',
            'Marketing & Branding',
            'Financial & Investment',
            'Technology & IT Support',
            'Legal Consultation',
            'Human Resources (HR) Consultation',
            'E-commerce & Online Business',
            'Career & Professional Development',
            'Healthcare & Wellness',
        ];
        
        // Get all verified consultants
        $verifiedConsultants = \App\Models\ConsultantProfile::with('user')
            ->where('is_verified', true)
            ->where('is_rejected', false)
            ->get();
        
        // Parse expertise and group consultants
        $expertiseMap = [];
        foreach ($verifiedConsultants as $consultant) {
            $expertiseList = array_map('trim', explode(',', $consultant->expertise ?? ''));
            foreach ($expertiseList as $exp) {
                if (!empty($exp)) {
                    // Normalize to match predefined list casing if it exists there
                    $normalizedExp = $exp;
                    foreach ($defaultExpertiseAreas as $defaultArea) {
                        if (strtolower($exp) === strtolower($defaultArea)) {
                            $normalizedExp = $defaultArea;
                            break;
                        }
                    }
                    
                    if (!isset($expertiseMap[$normalizedExp])) {
                        $expertiseMap[$normalizedExp] = [];
                    }
                    // Count completed consultations for this consultant
                    $completedCount = $allConsultations->where('consultant_profile_id', $consultant->id)
                        ->where('status', 'Completed')
                        ->count();
                    $expertiseMap[$normalizedExp][] = [
                        'consultant' => $consultant,
                        'completed_count' => $completedCount
                    ];
                }
            }
        }
        
        // Build the final list with default expertise areas
        $topConsultantsByExpertise = collect();
        foreach ($defaultExpertiseAreas as $expertise) {
            if (isset($expertiseMap[$expertise]) && count($expertiseMap[$expertise]) > 0) {
                // Sort by completed count and get top consultant
                usort($expertiseMap[$expertise], function($a, $b) {
                    return $b['completed_count'] - $a['completed_count'];
                });
                $topConsultantsByExpertise[$expertise] = $expertiseMap[$expertise][0];
            } else {
                // No consultant for this expertise yet
                $topConsultantsByExpertise[$expertise] = null;
            }
        }

        return view('consultant-folder.dashboard', compact(
            'stats', 
            'recent_consultations',
            'monthlyData',
            'statusBreakdown',
            'topTopics',
            'averageRating',
            'totalRatings',
            'ratingDistribution',
            'todayConsultations',
            'upcomingConsultations',
            'thisMonthCount',
            'lastMonthCount',
            'monthlyGrowth',
            'profile',
            'topConsultantsByExpertise'
        ));
    }

    // Admin dashboard
    public function admin()
    {
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }
        $consultants = \App\Models\ConsultantProfile::with('user')
            ->where('is_verified', true)
            ->orderByDesc('updated_at')
            ->get();
        $customers = \App\Models\User::where('role', 'Customer')
            ->orderByDesc('created_at')
            ->get();

        // Analytics data
        $consultations = \App\Models\Consultation::with(['consultantProfile.user', 'customer'])->get();
        
        // Total consultations
        $totalConsultations = $consultations->count();
        
        // Most booked consultant
        $mostBookedConsultant = $consultations->groupBy('consultant_profile_id')
            ->map(function($group) {
                return [
                    'count' => $group->count(),
                    'consultant' => $group->first()->consultantProfile->user->name ?? 'Unknown',
                    'profile_id' => $group->first()->consultant_profile_id
                ];
            })
            ->sortByDesc('count')
            ->first();
        
        // Most common topics
        $topTopics = $consultations->groupBy('topic')
            ->map(function($group) {
                return $group->count();
            })
            ->sortByDesc(function($count) {
                return $count;
            })
            ->take(5);
        
        // Monthly consultations (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = $consultations->filter(function($consultation) use ($month) {
                return $consultation->created_at->format('Y-m') === $month->format('Y-m');
            })->count();
            $monthlyData[] = [
                'month' => $month->format('M Y'),
                'count' => $count
            ];
        }
        
        // Status breakdown
        $statusBreakdown = $consultations->groupBy('status')
            ->map(function($group) {
                return $group->count();
            });
        
        // Pending approvals
        $pendingApprovals = \App\Models\ConsultantProfile::where('is_verified', false)
            ->where('is_rejected', false)
            ->count();

        // ===== NEW: Top Consultants by Area of Expertise =====
        // Define the 10 expertise areas to display
        $defaultExpertiseAreas = [
            'Business Strategy',
            'Startup & Entrepreneurship',
            'Marketing & Branding',
            'Financial & Investment',
            'Technology & IT Support',
            'Legal Consultation',
            'Human Resources (HR) Consultation',
            'E-commerce & Online Business',
            'Career & Professional Development',
            'Healthcare & Wellness',
        ];
        
        // Get unique expertise areas and their top consultants
        $verifiedConsultants = \App\Models\ConsultantProfile::with('user')
            ->where('is_verified', true)
            ->where('is_rejected', false)
            ->get();
        
        // Parse expertise (could be comma-separated) and group consultants
        $expertiseMap = [];
        foreach ($verifiedConsultants as $consultant) {
            $expertiseList = array_map('trim', explode(',', $consultant->expertise ?? ''));
            foreach ($expertiseList as $exp) {
                if (!empty($exp)) {
                    // Normalize to match predefined list casing if it exists there
                    $normalizedExp = $exp;
                    foreach ($defaultExpertiseAreas as $defaultArea) {
                        if (strtolower($exp) === strtolower($defaultArea)) {
                            $normalizedExp = $defaultArea;
                            break;
                        }
                    }
                    
                    if (!isset($expertiseMap[$normalizedExp])) {
                        $expertiseMap[$normalizedExp] = [];
                    }
                    // Count completed consultations for this consultant
                    $completedCount = $consultations->where('consultant_profile_id', $consultant->id)
                        ->where('status', 'Completed')
                        ->count();
                    $expertiseMap[$normalizedExp][] = [
                        'consultant' => $consultant,
                        'completed_count' => $completedCount
                    ];
                }
            }
        }
        
        // Build the final list with default expertise areas
        $topConsultantsByExpertise = collect();
        foreach ($defaultExpertiseAreas as $expertise) {
            if (isset($expertiseMap[$expertise]) && count($expertiseMap[$expertise]) > 0) {
                // Sort by completed count and get top consultant
                usort($expertiseMap[$expertise], function($a, $b) {
                    return $b['completed_count'] - $a['completed_count'];
                });
                $topConsultantsByExpertise[$expertise] = $expertiseMap[$expertise][0];
            } else {
                // No consultant for this expertise yet
                $topConsultantsByExpertise[$expertise] = null;
            }
        }

        // ===== NEW: Consultant of the Month =====
        // Based on completed consultations this month
        $currentMonth = now()->format('Y-m');
        $thisMonthConsultations = $consultations->filter(function($c) use ($currentMonth) {
            return $c->created_at->format('Y-m') === $currentMonth && $c->status === 'Completed';
        });
        
        $consultantOfTheMonth = null;
        if ($thisMonthConsultations->count() > 0) {
            $monthlyStats = $thisMonthConsultations->groupBy('consultant_profile_id')
                ->map(function($group) {
                    $profile = $group->first()->consultantProfile;
                    return [
                        'profile' => $profile,
                        'count' => $group->count(),
                        'name' => $profile->full_name ?? $profile->user->name ?? 'Unknown'
                    ];
                })
                ->sortByDesc('count')
                ->first();
            $consultantOfTheMonth = $monthlyStats;
        }

        // ===== NEW: Highest Rated Consultant =====
        $highestRatedConsultant = null;
        $ratings = \App\Models\ConsultationRating::where('rater_type', 'customer')->get();
        if ($ratings->count() > 0) {
            // Group ratings by consultant
            $consultantRatings = [];
            foreach ($ratings as $rating) {
                $consultation = $consultations->where('id', $rating->consultation_id)->first();
                if ($consultation && $consultation->consultantProfile) {
                    $profileId = $consultation->consultant_profile_id;
                    if (!isset($consultantRatings[$profileId])) {
                        $consultantRatings[$profileId] = [
                            'profile' => $consultation->consultantProfile,
                            'ratings' => [],
                            'total' => 0
                        ];
                    }
                    $consultantRatings[$profileId]['ratings'][] = $rating->rating;
                    $consultantRatings[$profileId]['total']++;
                }
            }
            
            // Calculate average and find highest
            $maxAvg = 0;
            foreach ($consultantRatings as $profileId => $data) {
                $avg = count($data['ratings']) > 0 ? array_sum($data['ratings']) / count($data['ratings']) : 0;
                if ($avg > $maxAvg && $data['total'] >= 1) {
                    $maxAvg = $avg;
                    $highestRatedConsultant = [
                        'profile' => $data['profile'],
                        'average_rating' => round($avg, 1),
                        'total_ratings' => $data['total'],
                        'name' => $data['profile']->full_name ?? $data['profile']->user->name ?? 'Unknown'
                    ];
                }
            }
        }

        // ===== NEW: Rising Star (newest consultant with completed consultations) =====
        $risingStar = null;
        $newConsultants = $verifiedConsultants->sortByDesc('created_at')->take(10);
        foreach ($newConsultants as $newConsultant) {
            $completedCount = $consultations->where('consultant_profile_id', $newConsultant->id)
                ->where('status', 'Completed')
                ->count();
            if ($completedCount > 0) {
                $risingStar = [
                    'profile' => $newConsultant,
                    'completed_count' => $completedCount,
                    'name' => $newConsultant->full_name ?? $newConsultant->user->name ?? 'Unknown',
                    'joined' => $newConsultant->created_at->diffForHumans()
                ];
                break;
            }
        }

        return view('admin-folder.dashboard', compact(
            'consultants', 
            'customers', 
            'totalConsultations',
            'mostBookedConsultant',
            'topTopics',
            'monthlyData',
            'statusBreakdown',
            'pendingApprovals',
            'topConsultantsByExpertise',
            'consultantOfTheMonth',
            'highestRatedConsultant',
            'risingStar'
        ));
    }
}