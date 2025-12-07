<?php

namespace App\Http\Controllers;

use App\Models\ConsultantProfile;
use App\Models\ConsultationRating;
use App\Models\ConsultationNotification;
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

        return redirect()->route('dashboard.consultant')->with('success', 'Thank you for creating your consultant account! We are excited to have you join our team of expert consultants. Please complete your profile to start receiving consultation requests from clients.');
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

        // Check if this is a resubmission after rejection
        $existingProfile = ConsultantProfile::where('user_id', Auth::id())->first();
        $isResubmission = $existingProfile && $existingProfile->is_rejected;

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
            // Preserve rejection history - DON'T clear admin_note or rejected_at
            // Only clear is_rejected flag to allow it to appear in pending queue
            'is_rejected' => false, // Clear rejection flag so it appears in pending queue
            'resubmitted_at' => $isResubmission ? now() : null,
            'resubmission_count' => $isResubmission ? ($existingProfile->resubmission_count ?? 0) + 1 : 0,
        ];

        if (Schema::hasColumn('consultant_profiles', 'avatar_path')) {
            $createData['avatar_path'] = $avatarPath;
        }

        // Use update() instead of updateOrCreate to preserve existing fields like admin_note and rejected_at
        if ($existingProfile) {
            $existingProfile->update($createData);
        } else {
            ConsultantProfile::create(array_merge(['user_id' => Auth::id()], $createData));
        }
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

        $profile = ConsultantProfile::where('user_id', Auth::id())->firstOrFail();
        $wasVerified = $profile->is_verified && !$profile->is_rejected;
        
        // Handle avatar upload separately - it doesn't require approval
        $avatarChanged = false;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            // Apply avatar immediately without approval
            $profile->avatar_path = $avatarPath;
            $profile->save();
            $avatarChanged = true;
        }

        // Prepare update data for other fields (excluding avatar)
        $updateData = [
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'age' => $request->age,
            'sex' => $request->sex,
            'expertise' => implode(', ', $request->expertise),
            'address' => $request->address,
            'rules_accepted' => true,
        ];
        // Do not write nulls to non-nullable DB columns
        $updateData = array_filter($updateData, static function ($value) {
            return !is_null($value);
        });

        // Handle resume upload
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
            $updateData['resume_path'] = $resumePath;
        }

        // Check if any non-avatar fields have changed
        $fieldsToCheck = ['full_name', 'email', 'phone_number', 'age', 'sex', 'expertise', 'address', 'resume_path'];
        $hasOtherChanges = false;
        foreach ($fieldsToCheck as $field) {
            $oldValue = $profile->$field ?? null;
            $newValue = $updateData[$field] ?? null;
            
            // For expertise, compare as strings
            if ($field === 'expertise') {
                $oldValue = $profile->expertise ?? '';
                $newValue = implode(', ', $request->expertise);
            }
            
            if ($oldValue != $newValue) {
                $hasOtherChanges = true;
                break;
            }
        }
        
        // If only avatar changed, no approval needed
        if (!$hasOtherChanges && $avatarChanged) {
            return back()->with('success', 'Profile picture updated successfully.');
        }
        
        // If no changes at all (not even avatar), just return
        if (!$hasOtherChanges && !$avatarChanged) {
            return back()->with('info', 'No changes detected.');
        }
        
        // If other fields changed, require approval (but avatar already applied)
        if ($hasOtherChanges) {
            $updateData['is_verified'] = false;
            
            // If profile was already verified, store previous values for comparison
            if ($wasVerified) {
                // Store the current approved values before updating (excluding avatar)
                $previousValues = [
                    'full_name' => $profile->full_name,
                    'email' => $profile->email,
                    'phone_number' => $profile->phone_number,
                    'age' => $profile->age,
                    'sex' => $profile->sex,
                    'expertise' => $profile->expertise,
                    'address' => $profile->address,
                    'resume_path' => $profile->resume_path,
                    // Note: avatar_path is NOT stored - profile picture doesn't need approval
                ];
                
                $updateData['previous_values'] = $previousValues;
                $updateData['has_pending_update'] = true;
                $updateData['update_requested_at'] = now();
            }
        }
        
        // If updating a rejected profile, mark as resubmission
        $isResubmission = $profile->is_rejected;
        if ($isResubmission) {
            $updateData['is_rejected'] = false; // Clear rejection flag to appear in pending
            $updateData['resubmitted_at'] = now();
            $updateData['resubmission_count'] = ($profile->resubmission_count ?? 0) + 1;
        }
        // Preserve rejection history (admin_note, rejected_at) - don't include in $updateData
        
        // Update profile with other field changes
        $profile->update($updateData);

        // Build success message
        $message = '';
        if ($isResubmission) {
            $message = 'Profile resubmitted for review. Pending approval.';
            if ($avatarChanged) {
                $message .= ' Profile picture updated immediately.';
            }
        } elseif ($hasOtherChanges && $wasVerified) {
            $message = 'Update request submitted. Pending admin approval.';
            if ($avatarChanged) {
                $message .= ' Profile picture updated immediately.';
            }
        } else {
            $message = 'Profile updated successfully.';
            if ($avatarChanged) {
                $message .= ' Profile picture updated.';
            }
        }
        
        return back()->with('success', $message);
    }

    public function cancelUpdate()
    {
        $profile = ConsultantProfile::where('user_id', Auth::id())->firstOrFail();
        
        // Check if there's a pending update
        if (!$profile->has_pending_update || !$profile->previous_values) {
            return back()->with('error', 'No pending update to cancel.');
        }
        
        // Restore previous values
        $previousValues = $profile->previous_values;
        
        $restoreData = [
            'full_name' => $previousValues['full_name'] ?? $profile->full_name,
            'email' => $previousValues['email'] ?? $profile->email,
            'phone_number' => $previousValues['phone_number'] ?? $profile->phone_number,
            'age' => $previousValues['age'] ?? $profile->age,
            'sex' => $previousValues['sex'] ?? $profile->sex,
            'expertise' => $previousValues['expertise'] ?? $profile->expertise,
            'address' => $previousValues['address'] ?? $profile->address,
            'resume_path' => $previousValues['resume_path'] ?? $profile->resume_path,
            // Clear pending update flags
            'has_pending_update' => false,
            'update_requested_at' => null,
            'previous_values' => null,
            // Restore verification status if it was verified before
            'is_verified' => true,
        ];
        
        $profile->update($restoreData);
        
        return back()->with('success', 'Profile update request cancelled. Your profile has been restored to the previous approved values.');
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


