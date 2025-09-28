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

        return view('customer-folder.dashboard');
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

        return view('consultant-folder.dashboard');
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