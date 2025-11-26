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

    public function show($id)
    {
        $profile = ConsultantProfile::with('user')->findOrFail($id);
        return view('admin-folder.consultant-show', compact('profile'));
    }
}


