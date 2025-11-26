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

        return view('customer-folder.consultants', compact('consultants', 'query'));
    }

    /**
     * Get all consultants as JSON (for API or AJAX requests)
     */
    public function getAllConsultants(Request $request)
    {
        $query = $request->get('q');
        
        $consultants = ConsultantProfile::with('user')
            ->where('is_verified', true)
            ->when($query, function($q) use ($query) {
                $normalized = mb_strtolower($query);
                $q->where(function($sub) use ($normalized, $query) {
                    $sub->whereRaw('LOWER(expertise) = ?', [$normalized])
                        ->orWhere('full_name', 'like', "%".$query."%")
                        ->orWhere('email', 'like', "%".$query."%");
                });
            })
            ->orderByDesc('updated_at')
            ->get()
            ->map(function($consultant) {
                return [
                    'id' => $consultant->id,
                    'full_name' => $consultant->full_name,
                    'expertise' => $consultant->expertise,
                    'email' => $consultant->email,
                    'phone_number' => $consultant->phone_number,
                    'avatar_path' => $consultant->avatar_path,
                    'is_verified' => $consultant->is_verified,
                    'created_at' => $consultant->created_at,
                    'updated_at' => $consultant->updated_at,
                ];
            });

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
