<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Carbon;

class AdminReportController extends Controller
{
    /**
     * Show the reports dashboard.
     */
    /**
     * Show the reports dashboard with analytics.
     */
    public function index()
    {
        // 1. Trend Data (Last 6 Months) - Completed Consultations
        $endDate = now()->endOfMonth();
        $startDate = now()->copy()->startOfMonth()->subMonths(5);
        
        $trendQuery = Consultation::where('status', 'Completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function($val) {
                return Carbon::parse($val->created_at)->format('Y-m');
            });
            
        $labels = [];
        $dataPoints = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $monthKey = $currentDate->format('Y-m');
            $count = isset($trendQuery[$monthKey]) ? $trendQuery[$monthKey]->count() : 0;
            
            $labels[] = $currentDate->format('M Y');
            $dataPoints[] = $count;
            
            // Revenue Trend (Optional: could add a separate revenue chart)
            $currentDate->addMonth();
        }

        // ===== Revenue Analytics =====
        $revenueData = Subscription::where('payment_status', 'approved')
            ->selectRaw('plan_type, SUM(price) as total_revenue, COUNT(*) as count')
            ->groupBy('plan_type')
            ->get();
            
        $totalRevenue = Subscription::where('payment_status', 'approved')->sum('price');
        $weeklyRevenue = $revenueData->where('plan_type', 'Weekly')->first()->total_revenue ?? 0;
        $quarterlyRevenue = $revenueData->where('plan_type', 'Quarterly')->first()->total_revenue ?? 0;
        $annualRevenue = $revenueData->where('plan_type', 'Annual')->first()->total_revenue ?? 0;
        
        $revenueLabels = ['Weekly', 'Quarterly', 'Annual'];
        $revenueChartData = [$weeklyRevenue, $quarterlyRevenue, $annualRevenue];
        
        // Stats
        $thisMonthCount = end($dataPoints);
        // Reset pointer to get prev
        $prevValues = array_values(array_slice($dataPoints, -2, 1));
        $lastMonthCount = isset($prevValues[0]) ? $prevValues[0] : 0;
        
        $avgMonth = count($dataPoints) > 0 ? round(array_sum($dataPoints) / count($dataPoints), 1) : 0;
        
        $trendPercent = 0;
        if ($lastMonthCount > 0) {
            $trendPercent = round((($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100);
        } elseif ($thisMonthCount > 0) {
            $trendPercent = 100; // 100% growth from 0
        }

        // Expertise List (Consistent with Dashboard)
        $expertiseList = [
            'Business Strategy',
            'Startup & Entrepreneurship',
            'Marketing & Branding',
            'Financial & Investment',
            'Technology & IT Support',
            'Legal Consultation',
            'Human Resources (HR) Consultation',
            'E-commerce & Online Business',
            'Career & Professional Development',
            'Healthcare & Wellness'
        ];

        // 2. Expertise Breakdown (Consultations per Expertise)
        // Group consultations by consultant's primary expertise
        $expertiseCounts = [];
        $allConsultations = Consultation::with('consultantProfile')->get();
        
        foreach ($allConsultations as $consultation) {
            $profile = $consultation->consultantProfile;
            if (!$profile) continue;
            
            $exp = $profile->expertise;
            $primaryExpertise = 'Other'; // Default
            
            if (!empty($exp)) {
                // Check if JSON
                if (str_starts_with($exp, '[') || str_starts_with($exp, '{')) {
                     $decoded = json_decode($exp, true);
                     if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                         $primaryExpertise = $decoded[0] ?? 'Other';
                     }
                } else {
                    // Plain string
                    $primaryExpertise = $exp;
                }
            }
            // Clean string (remove brackets if decoded failed but looks like array string)
            $primaryExpertise = trim($primaryExpertise, '[]"\'');
            
            if (!isset($expertiseCounts[$primaryExpertise])) {
                $expertiseCounts[$primaryExpertise] = 0;
            }
            $expertiseCounts[$primaryExpertise]++;
        }
        
        // Sort by count desc and limit to Top 5 + Others
        arsort($expertiseCounts);
        $topExpertise = array_slice($expertiseCounts, 0, 5, true);
        $otherCount = array_sum(array_slice($expertiseCounts, 5));
        if ($otherCount > 0) {
            $topExpertise['Others'] = $otherCount;
        }
        
        $expertiseLabels = array_keys($topExpertise);
        $expertiseData = array_values($topExpertise);

        // 3. Bright Idea: Customer Satisfaction (Ratings)
        $ratingQuery = \App\Models\ConsultationRating::where('rater_type', 'customer');
        $avgRating = round($ratingQuery->avg('rating') ?? 0, 1);
        $totalRatings = $ratingQuery->count();
        
        // Distribution (5 stars to 1 star)
        $starCounts = [0, 0, 0, 0, 0];
        $ratingValues = $ratingQuery->pluck('rating');
        foreach ($ratingValues as $r) {
            $idx = max(0, min(4, ceil($r) - 1));
            $starCounts[$idx]++;
        }
        // Reverse to have 5 stars first
        $starCounts = array_reverse($starCounts);

        return view('admin-folder.reports', compact(
            'labels', 'dataPoints', 'thisMonthCount', 'avgMonth', 'trendPercent', 
            'expertiseLabels', 'expertiseData',
            'avgRating', 'totalRatings', 'starCounts',
            'expertiseList',
            'totalRevenue', 'weeklyRevenue', 'quarterlyRevenue', 'annualRevenue',
            'revenueLabels', 'revenueChartData'
        ));
    }

    /**
     * Handle report exports based on type and format.
     */
    public function export(Request $request)
    {
        $type = $request->input('type', 'custom'); // 'custom', 'monthly', 'consolidated'
        $format = $request->input('format', 'csv'); // 'csv', 'excel', 'pdf'
        $year = $request->input('year', now()->year);

        if ($type === 'consolidated') {
             // Consolidated only supports CSV/Excel for now as it's a summary
             // Usually consolidated is simple enough for CSV
             return $this->exportConsolidated($year, $format);
        }

        // Detailed reports
        $query = Consultation::with(['consultantProfile.user', 'customer'])
            ->orderByDesc('created_at');

        $title = "Consultation Report";
        $dateRange = "";

        if ($type === 'monthly') {
            $month = $request->input('month');
            if ($month === 'all') {
                $query->whereYear('created_at', $year);
                $title = "Annual Report {$year}";
                $dateRange = "Jan - Dec {$year}";
                $filename = "consultations_annual_{$year}";
            } else {
                $month = $month ?: now()->month;
                $query->whereYear('created_at', $year)
                      ->whereMonth('created_at', $month);
                $monthName = date('F', mktime(0, 0, 0, $month, 1));
                $title = "Monthly Report - {$monthName} {$year}";
                $dateRange = "{$monthName} {$year}";
                $filename = "consultations_monthly_{$year}_{$month}";
            }
        } else {
            // Custom Range (formerly Weekly)
            $startStr = $request->input('start_date');
            $endStr = $request->input('end_date');
            
            // Default to current week if empty
            $start = $startStr ? Carbon::parse($startStr) : now()->startOfWeek();
            $end = $endStr ? Carbon::parse($endStr)->endOfDay() : now()->endOfWeek()->endOfDay();
            
            $query->whereBetween('created_at', [$start, $end]);
            
            $dateRange = $start->format('M d, Y') . ' - ' . $end->format('M d, Y');
            $filename = "consultations_custom_" . $start->format('Ymd') . "-" . $end->format('Ymd');
        }

        // Filter by Expertise
        if ($expertise = $request->input('expertise')) {
            if ($expertise !== 'all') {
                $query->whereHas('consultantProfile', function($exQuery) use ($expertise) {
                     $exQuery->where('expertise', 'like', '%' . $expertise . '%');
                });
                $title .= " [" . $expertise . "]";
                $filename .= "_" . str_replace([' ', '&', '/'], '_', strtolower($expertise));
            }
        }

        $data = $query->get();

        if ($format === 'pdf') {
            // Calculate revenue for the same period
            $revenueReport = Subscription::whereBetween('approved_at', [$query->getQuery()->wheres[0]['values'] ?? [now()->startOfWeek(), now()], now()]) // approximation or refined logic
                ->where('payment_status', 'approved')
                ->selectRaw('plan_type, SUM(price) as top_rev')
                ->groupBy('plan_type')
                ->get();
            
            // Actually, better to just re-query based on $start and $end if custom, or $year/$month
            $revQuery = Subscription::where('payment_status', 'approved');
            if ($type === 'monthly') {
                if ($month === 'all') {
                    $revQuery->whereYear('approved_at', $year);
                } else {
                    $revQuery->whereYear('approved_at', $year)->whereMonth('approved_at', $month);
                }
            } else {
                $start = $startStr ? Carbon::parse($startStr) : now()->startOfWeek();
                $end = $endStr ? Carbon::parse($endStr)->endOfDay() : now()->endOfWeek()->endOfDay();
                $revQuery->whereBetween('approved_at', [$start, $end]);
            }
            $revenueStats = $revQuery->get()->groupBy('plan_type')->map->sum('price');
            $totalRev = $revenueStats->sum();

            return view('admin-folder.reports-pdf', compact('data', 'title', 'dateRange', 'revenueStats', 'totalRev'));
        }

        return $this->streamCsv($data, $filename . "." . ($format === 'excel' ? 'csv' : 'csv'), $format === 'excel');
    }

    /**
     * Generate consolidated report by month.
     */
    protected function exportConsolidated($year, $format = 'csv')
    {
        $filename = "consultations_consolidated_{$year}.csv";

        // Fetch data grouped by month
        $consultations = Consultation::whereYear('created_at', $year)->get();
        
        $monthlyData = $consultations->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('m');
        });

        // ... existing consolidated logic adjusted for Headers ...
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($monthlyData, $year) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // Always add BOM for better Excel support
            
            fputcsv($handle, ['Month', 'Total Consultations', 'Completed', 'Pending/Active', 'Cancelled/Rejected', 'Revenue (₱)']);

            for ($m = 1; $m <= 12; $m++) {
                $monthKey = str_pad($m, 2, '0', STR_PAD_LEFT);
                $monthName = date('F', mktime(0, 0, 0, $m, 1));
                
                $data = $monthlyData->get($monthKey, collect());
                
                // Revenue for this month
                $revenue = Subscription::whereYear('approved_at', $year)
                    ->whereMonth('approved_at', $m)
                    ->where('payment_status', 'approved')
                    ->sum('price');
                
                fputcsv($handle, [
                    $monthName,
                    $data->count(),
                    $data->where('status', 'Completed')->count(),
                    $data->whereIn('status', ['Pending', 'Accepted', 'Proposed'])->count(),
                    $data->whereIn('status', ['Rejected', 'Cancelled', 'Declined'])->count(),
                    number_format($revenue, 2)
                ]);
            }
            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }

    /**
     * Stream a standard list CSV.
     */
    protected function streamCsv($consultations, $filename, $isExcel = false)
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($consultations) {
            $handle = fopen('php://output', 'w');
            
            // Excel BOM
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($handle, [
                'ID', 'Date', 'Consultant', 'Customer', 'Topic', 'Status', 'Rating', 'Plan Type'
            ]);

            foreach ($consultations as $consultation) {
                // ... map data ...
                 $profile = $consultation->consultantProfile;
                 $rating = $consultation->customerRating ? $consultation->customerRating->rating : 'N/A';
                 
                fputcsv($handle, [
                    $consultation->id,
                    $consultation->created_at->format('Y-m-d H:i'),
                    optional($profile?->user)->name ?? 'Unknown',
                    optional($consultation->customer)->name ?? 'Unknown',
                    $consultation->topic,
                    $consultation->status,
                    $rating,
                    // Price logic per consultation - Note: Consultations don't have individual prices, but we can report the customer's subscription tier
                    optional($consultation->customer->activeSubscription())->plan_type ?? 'None'
                ]);
            }
            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }
}
