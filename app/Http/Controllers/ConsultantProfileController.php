<?php

namespace App\Http\Controllers;

use App\Models\ConsultantProfile;
use App\Models\ConsultationRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ConsultantProfileController extends Controller
{
    public function rules()
    {
        $profile = ConsultantProfile::firstOrNew(['user_id' => Auth::id()]);
        $user = Auth::user();
        $userAccepted = $user->consultant_rules_accepted ?? false;

        // If rules already accepted (in DB or on the user record), skip this page
        if (($profile->exists && $profile->rules_accepted) || $userAccepted) {
            return redirect()->route('consultant.profile');
        }

        return view('consultant-folder.rules', compact('profile'));
    }

    public function acceptRules(Request $request)
    {
        $request->validate([
            'accept' => 'accepted',
        ], [
            'accept.accepted' => 'You must accept the rules to proceed.',
        ]);

        // Persist acceptance on the profile if it exists; otherwise persist on the user record
        $profile = ConsultantProfile::where('user_id', Auth::id())->first();
        if ($profile) {
            $profile->rules_accepted = true;
            $profile->save();
        }

        $user = Auth::user();
        $user->consultant_rules_accepted = true;
        $user->save();

        return redirect()->route('consultant.profile');
    }

    public function profile()
    {
        $profile = ConsultantProfile::firstOrNew(['user_id' => Auth::id()]);
        // If no persisted profile yet, rely on the user's flag to allow reaching the profile page after accepting rules
        $userAccepted = Auth::user()->consultant_rules_accepted ?? false;
        if ((!$profile->exists || !$profile->rules_accepted) && !$userAccepted) {
            return redirect()->route('consultant.rules');
        }

        $averageRating = null;
        $totalRatings = 0;
        $ratings = collect();

        if ($profile->exists) {
            $ratings = ConsultationRating::whereHas('consultation', function($q) use ($profile) {
                $q->where('consultant_profile_id', $profile->id);
            })
            ->where('rater_type', 'customer')
            ->get();

            if ($ratings->count() > 0) {
                $averageRating = round($ratings->avg('rating'), 1);
                $totalRatings = $ratings->count();
            }
        }

        return view('consultant-folder.profile', compact('profile', 'averageRating', 'totalRatings'));
    }

    public function saveProfile(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'age' => 'required|integer|min:18|max:120',
            'sex' => 'required|in:Male,Female,Other',
            'expertise' => 'required|array|min:1|max:5',
            'expertise.*' => 'in:Technology & IT Support,E-commerce Business,Marketing Business,Education & Career Coaching,Financial Business',
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
            'expertise' => implode(', ', $validated['expertise']),
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
        // Make sure user's flag is set when profile is created
        $user = Auth::user();
        if (! $user->consultant_rules_accepted) {
            $user->consultant_rules_accepted = true;
            $user->save();
        }

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
            'expertise' => 'required|array|min:1|max:5',
            'expertise.*' => 'in:Technology & IT Support,E-commerce Business,Marketing Business,Education & Career Coaching,Financial Business',
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
            'expertise' => implode(', ', $request->expertise),
            'address' => $request->address,
            'rules_accepted' => true,
            // Any profile update requires admin to approve again
            'is_verified' => false,
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


