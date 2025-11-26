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

        $featuredConsultants = \App\Models\ConsultantProfile::with('user')
            ->where('is_verified', true)
            ->orderByDesc('updated_at')
            ->take(3)
            ->get();

        $totalVerifiedConsultants = \App\Models\ConsultantProfile::where('is_verified', true)->count();

        return view('customer-folder.dashboard', compact('featuredConsultants', 'totalVerifiedConsultants'));
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

        // Get consultation statistics
        $consultations = \App\Models\Consultation::where('consultant_profile_id', $profile->id)->get();
        
        $stats = [
            'pending_consultations' => $consultations->where('status', 'Pending')->count(),
            'accepted_consultations' => $consultations->where('status', 'Accepted')->count(),
            'completed_consultations' => $consultations->where('status', 'Completed')->count(),
            'total_earnings' => $consultations->where('status', 'Completed')->count() * 100, // Example: $100 per completed consultation
        ];

        // Get recent consultations
        $recent_consultations = \App\Models\Consultation::with('customer')
            ->where('consultant_profile_id', $profile->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('consultant-folder.dashboard', compact('stats', 'recent_consultations'));
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

        return view('admin-folder.dashboard', compact('consultants', 'customers'));
    }
}