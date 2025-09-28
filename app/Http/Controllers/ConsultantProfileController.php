<?php

namespace App\Http\Controllers;

use App\Models\ConsultantProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultantProfileController extends Controller
{
    public function rules()
    {
        $profile = ConsultantProfile::firstOrNew(['user_id' => Auth::id()]);
        return view('consultant-folder.rules', compact('profile'));
    }

    public function acceptRules(Request $request)
    {
        $request->validate([
            'accept' => 'accepted',
        ], [
            'accept.accepted' => 'You must accept the rules to proceed.',
        ]);

        // Do not create a DB row yet (required columns would fail). Mark acceptance in session.
        session(['consultant_rules_accepted' => true]);

        return redirect()->route('consultant.profile');
    }

    public function profile()
    {
        $profile = ConsultantProfile::firstOrNew(['user_id' => Auth::id()]);
        // If no persisted profile yet, rely on session to allow reaching the profile page after accepting rules
        $rulesAcceptedSession = session('consultant_rules_accepted', false);
        if ((!$profile->exists || !$profile->rules_accepted) && !$rulesAcceptedSession) {
            return redirect()->route('consultant.rules');
        }
        return view('consultant-folder.profile', compact('profile'));
    }

    public function saveProfile(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:30',
            'age' => 'required|integer|min:18|max:120',
            'sex' => 'required|in:Male,Female,Other',
            'expertise' => 'required|string|in:Marketing,Finance,Operations,HR,IT,Legal,Other',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $path = $request->file('resume')->store('resumes', 'public');

        ConsultantProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'rules_accepted' => true,
                'full_name' => trim($validated['first_name'].' '.$validated['last_name']),
                'address' => '',
                'age' => (int) $validated['age'],
                'sex' => $validated['sex'],
                'phone_number' => $validated['phone_number'],
                'email' => $validated['email'],
                'expertise' => $validated['expertise'],
                'resume_path' => $path,
                'is_verified' => false,
            ]
        );

        // Clear the temporary rules acceptance marker
        session()->forget('consultant_rules_accepted');

        return redirect()->route('dashboard.consultant')->with('success', 'Profile submitted. Pending approval.');
    }
    public function create()
    {
        return view('consultant-verify');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:120',
            'sex' => 'required|in:Male,Female,Other',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $path = $request->file('resume')->store('resumes', 'public');

        ConsultantProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'address' => $validated['address'],
                'age' => $validated['age'],
                'sex' => $validated['sex'],
                'resume_path' => $path,
                'is_verified' => false,
            ]
        );

        return redirect()->route('dashboard.consultant')->with('success', 'Verification submitted. Pending approval.');
    }
}


