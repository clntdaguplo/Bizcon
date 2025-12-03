<?php

namespace App\Http\Controllers;

use App\Models\ConsultantProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminConsultantController extends Controller
{
    public function consultants()
    {
        $consultants = ConsultantProfile::with('user')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin-folder.consultants', compact('consultants'));
    }

    public function customers()
    {
        $customers = \App\Models\User::where('role', 'Customer')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin-folder.customers', compact('customers'));
    }
    public function index()
    {
        $pending = ConsultantProfile::with('user')
            ->where('is_verified', false)
            ->where('is_rejected', false)
            ->whereNotNull('full_name')
            ->whereNotNull('expertise')
            ->whereNotNull('resume_path')
            ->get();

        return view('admin-folder.consultants-pending', compact('pending'));
    }

    public function approve($id)
    {
        $profile = ConsultantProfile::findOrFail($id);
        $profile->is_verified = true;
        $profile->save();

        return back()->with('success', 'Consultant approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_note' => 'nullable|string|max:2000',
        ]);
        $profile = ConsultantProfile::findOrFail($id);
        $profile->is_rejected = true;
        $profile->admin_note = $request->input('admin_note');
        $profile->save();

        return back()->with('success', 'Consultant rejected.');
    }

    /**
     * Soft-suspend a consultant (reuses is_rejected flag).
     */
    public function suspend($id)
    {
        $profile = ConsultantProfile::findOrFail($id);
        $profile->is_rejected = true;
        $profile->save();

        return back()->with('success', 'Consultant has been suspended.');
    }

    /**
     * Remove suspension for a consultant.
     */
    public function unsuspend($id)
    {
        $profile = ConsultantProfile::findOrFail($id);
        $profile->is_rejected = false;
        $profile->save();

        return back()->with('success', 'Consultant suspension removed.');
    }

    public function show($id)
    {
        $profile = ConsultantProfile::with('user')->findOrFail($id);
        
        // Calculate average ratings from clients
        $ratings = \App\Models\ConsultationRating::whereHas('consultation', function($q) use ($profile) {
            $q->where('consultant_profile_id', $profile->id);
        })
        ->where('rater_type', 'customer')
        ->get();
        
        if ($ratings->count() > 0) {
            $profile->average_rating = round($ratings->avg('rating'), 1);
            $profile->total_ratings = $ratings->count();
            $profile->ratings = $ratings;
        } else {
            $profile->average_rating = null;
            $profile->total_ratings = 0;
            $profile->ratings = collect();
        }
        
        return view('admin-folder.consultant-show', compact('profile'));
    }
}


