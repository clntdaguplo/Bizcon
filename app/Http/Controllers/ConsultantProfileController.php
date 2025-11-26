<?php

namespace App\Http\Controllers;

use App\Models\ConsultantProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

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
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'age' => 'required|integer|min:18|max:120',
            'sex' => 'required|in:Male,Female,Other',
            'expertise' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'public');
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $createData = [
            'rules_accepted' => true,
            'full_name' => $validated['full_name'],
            'address' => $validated['address'],
            'age' => (int) $validated['age'],
            'sex' => $validated['sex'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'],
            'expertise' => $validated['expertise'],
            'resume_path' => $resumePath,
            'is_verified' => false,
        ];

        if (Schema::hasColumn('consultant_profiles', 'avatar_path')) {
            $createData['avatar_path'] = $avatarPath;
        }

        ConsultantProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            $createData
        );

        session()->forget('consultant_rules_accepted');

        return redirect()->route('dashboard.consultant')->with('success', 'Profile submitted. Pending approval.');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:18|max:100',
            'sex' => 'nullable|in:Male,Female,Other',
            'expertise' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $updateData = [
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'age' => $request->age,
            'sex' => $request->sex,
            'expertise' => $request->expertise,
            'address' => $request->address,
            'rules_accepted' => true,
        ];
        // Do not write nulls to non-nullable DB columns
        $updateData = array_filter($updateData, static function ($value) {
            return !is_null($value);
        });

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $updateData['avatar_path'] = $avatarPath;
        }

        // Handle resume upload
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
            $updateData['resume_path'] = $resumePath;
        }

        $profile = ConsultantProfile::where('user_id', Auth::id())->firstOrFail();
        $profile->update($updateData);

        return back()->with('success', 'Profile updated successfully.');
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


