<?php

namespace App\Http\Controllers;

use App\Models\ConsultantProfile;
use Illuminate\Http\Request;

class CustomerConsultantController extends Controller
{
    /**
     * Display all verified consultants for customers
     */
    public function index(Request $request)
    {
        $query = $request->get('q');
        
        $consultants = ConsultantProfile::with('user')
            ->where('is_verified', true)
            ->where('is_rejected', false) // Exclude suspended consultants
            ->when($query, function($q) use ($query) {
                $normalized = mb_strtolower($query);
                $q->where(function($sub) use ($normalized, $query) {
                    $sub->whereRaw('LOWER(expertise) = ?', [$normalized])
                        ->orWhere('full_name', 'like', "%".$query."%")
                        ->orWhere('email', 'like', "%".$query."%");
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

        return view('customer-folder.consultants', compact('consultants', 'query'));
    }

    /**
     * Get all consultants as JSON (for API or AJAX requests)
     */
    public function getAllConsultants(Request $request)
    {
        $query = $request->get('q');
        $topic = $request->get('topic'); // New parameter for topic-based filtering
        
        $consultants = ConsultantProfile::with('user')
            ->where('is_verified', true)
            ->where('is_rejected', false) // Exclude suspended consultants
            ->when($query, function($q) use ($query) {
                $normalized = mb_strtolower($query);
                $q->where(function($sub) use ($normalized, $query) {
                    $sub->whereRaw('LOWER(expertise) = ?', [$normalized])
                        ->orWhere('full_name', 'like', "%".$query."%")
                        ->orWhere('email', 'like', "%".$query."%");
                });
            })
            ->when($topic, function($q) use ($topic) {
                // Filter consultants where their expertise contains the topic
                // Since expertise is comma-separated, we need to check if any expertise matches
                $q->where(function($sub) use ($topic) {
                    $topicNormalized = mb_strtolower(trim($topic));
                    $sub->whereRaw('LOWER(expertise) LIKE ?', ['%' . $topicNormalized . '%']);
                });
            })
            ->orderByDesc('updated_at')
            ->get()
            ->filter(function($consultant) use ($topic) {
                // Additional filtering: ensure the topic exactly matches one of the consultant's expertise
                if ($topic) {
                    $expertiseList = $consultant->expertise 
                        ? array_map('trim', explode(',', $consultant->expertise))
                        : [];
                    $topicNormalized = mb_strtolower(trim($topic));
                    // Check if any expertise exactly matches (case-insensitive)
                    foreach ($expertiseList as $expertise) {
                        if (mb_strtolower(trim($expertise)) === $topicNormalized) {
                            return true;
                        }
                    }
                    return false;
                }
                return true;
            })
            ->map(function($consultant) {
                // Calculate average ratings
                $ratings = \App\Models\ConsultationRating::whereHas('consultation', function($q) use ($consultant) {
                    $q->where('consultant_profile_id', $consultant->id);
                })
                ->where('rater_type', 'customer')
                ->get();
                
                $averageRating = null;
                $totalRatings = 0;
                if ($ratings->count() > 0) {
                    $averageRating = round($ratings->avg('rating'), 1);
                    $totalRatings = $ratings->count();
                }
                
                return [
                    'id' => $consultant->id,
                    'full_name' => $consultant->full_name,
                    'expertise' => $consultant->expertise,
                    'email' => $consultant->email,
                    'phone_number' => $consultant->phone_number,
                    'avatar_path' => $consultant->avatar_path,
                    'is_verified' => $consultant->is_verified,
                    'average_rating' => $averageRating,
                    'total_ratings' => $totalRatings,
                    'created_at' => $consultant->created_at,
                    'updated_at' => $consultant->updated_at,
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'data' => $consultants,
            'total' => $consultants->count()
        ]);
    }

    /**
     * Get consultant statistics
     */
    public function getStats()
    {
        $totalConsultants = ConsultantProfile::where('is_verified', true)->count();
        $recentConsultants = ConsultantProfile::where('is_verified', true)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();
        
        $expertiseStats = ConsultantProfile::where('is_verified', true)
            ->selectRaw('expertise, COUNT(*) as count')
            ->groupBy('expertise')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'stats' => [
                'total_consultants' => $totalConsultants,
                'recent_consultants' => $recentConsultants,
                'expertise_breakdown' => $expertiseStats
            ]
        ]);
    }

    /**
     * Redirect to consultation request with selected consultant
     */
    public function requestConsultation($id)
    {
        $consultant = ConsultantProfile::where('is_verified', true)
            ->with('user')
            ->findOrFail($id);
            
        return redirect()->route('customer.new-consult', ['consultant' => $consultant->id])
            ->with('selected_consultant', $consultant);
    }
}
