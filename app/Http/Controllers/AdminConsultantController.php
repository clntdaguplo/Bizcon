<?php

namespace App\Http\Controllers;

use App\Models\ConsultantProfile;
use App\Models\ConsultantSuspensionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminConsultantController extends Controller
{
    public function consultants(Request $request)
    {
        $query = $request->get('search', '');
        $status = $request->get('status', '');
        $expertise = $request->get('expertise', '');
        
        // Exclude rejected consultants from the main list
        $consultants = ConsultantProfile::with('user')
            ->where('is_rejected', false)
            ->when($query, function($q) use ($query) {
                $q->where(function($sub) use ($query) {
                    $sub->where('full_name', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%")
                        ->orWhere('expertise', 'like', "%{$query}%")
                        ->orWhereHas('user', function($userQuery) use ($query) {
                            $userQuery->where('name', 'like', "%{$query}%")
                                      ->orWhere('email', 'like', "%{$query}%");
                        });
                });
            })
            ->when($status === 'verified', function($q) {
                $q->where('is_verified', true);
            })
            ->when($status === 'pending', function($q) {
                $q->where('is_verified', false);
            })
            ->when($expertise, function($q) use ($expertise) {
                // Filter consultants where their expertise contains the selected expertise
                // Since expertise is comma-separated, we need to check if any expertise matches
                $q->where(function($sub) use ($expertise) {
                    $sub->where('expertise', 'like', "%{$expertise}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->appends($request->query());

        return view('admin-folder.consultants', compact('consultants'));
    }
    
    public function rejected()
    {
        // Show only rejected consultants (never verified, is_rejected = true, is_verified = false)
        $rejected = ConsultantProfile::with('user')
            ->where('is_rejected', true)
            ->where('is_verified', false)
            ->orderByDesc('updated_at')
            ->paginate(15);

        return view('admin-folder.consultants-rejected', compact('rejected'));
    }

    public function suspended()
    {
        // Show only suspended consultants (was verified, then suspended: is_rejected = true, is_verified = true)
        // Also check if suspension has expired and auto-unsuspend
        $suspended = ConsultantProfile::with(['user', 'suspensionHistory.admin'])
            ->where('is_rejected', true)
            ->where('is_verified', true)
            ->get()
            ->map(function($consultant) {
                // Auto-unsuspend if suspension has expired
                if ($consultant->suspended_until && $consultant->suspended_until->isPast()) {
                    // Log auto-unsuspension before clearing
                    ConsultantSuspensionHistory::create([
                        'consultant_profile_id' => $consultant->id,
                        'admin_id' => null, // Auto-unsuspension, no admin
                        'action' => 'unsuspended',
                        'duration' => null,
                        'suspended_until' => null,
                        'action_date' => now(),
                        'reason' => 'Automatic unsuspension - suspension period expired',
                    ]);
                    
                    $consultant->is_rejected = false;
                    $consultant->suspended_until = null;
                    $consultant->save();
                    return null; // Filter out auto-unsuspended consultants
                }
                return $consultant;
            })
            ->filter()
            ->sortByDesc('updated_at')
            ->values();

        // Paginate manually
        $currentPage = request()->get('page', 1);
        $perPage = 15;
        $suspendedPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $suspended->forPage($currentPage, $perPage),
            $suspended->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin-folder.consultants-suspended', ['suspended' => $suspendedPaginated]);
    }

    public function customers(Request $request)
    {
        $query = $request->get('search', '');
        $status = $request->get('status', '');
        $dateFilter = $request->get('date_filter', '');
        
        // Start with all customers - exclude suspended by default (show only active)
        $customers = \App\Models\User::where('role', 'Customer')
            ->where('is_suspended', false) // Default: show only active customers
            ->when($query, function($q) use ($query) {
                $q->where(function($sub) use ($query) {
                    $sub->where('name', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%");
                });
            })
            ->when($status === 'active', function($q) {
                $q->where('is_suspended', false);
            })
            ->when($dateFilter === 'today', function($q) {
                $q->whereDate('created_at', today());
            })
            ->when($dateFilter === 'week', function($q) {
                $q->where('created_at', '>=', now()->startOfWeek());
            })
            ->when($dateFilter === 'month', function($q) {
                $q->where('created_at', '>=', now()->startOfMonth());
            })
            ->when($dateFilter === 'year', function($q) {
                $q->where('created_at', '>=', now()->startOfYear());
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->appends($request->query());

        return view('admin-folder.customers', compact('customers'));
    }

    public function customersSuspended()
    {
        // Show only suspended customers
        $customers = \App\Models\User::where('role', 'Customer')
            ->where('is_suspended', true)
            ->orderByDesc('updated_at')
            ->paginate(15);

        return view('admin-folder.customers-suspended', compact('customers'));
    }

    /**
     * Suspend a customer account.
     */
    public function suspendCustomer($id)
    {
        $customer = \App\Models\User::where('role', 'Customer')->findOrFail($id);
        $customer->is_suspended = true;
        $customer->save();

        // Send notification to customer
        \App\Models\ConsultationNotification::create([
            'consultation_id' => null,
            'user_id' => $customer->id,
            'type' => 'account_welcome', // Using existing type, could add customer_suspended later
            'title' => 'Account Suspended',
            'message' => 'Your customer account has been temporarily suspended. Please contact support for more information.',
            'is_read' => false,
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Customer has been suspended.');
    }

    /**
     * Remove suspension for a customer account.
     */
    public function unsuspendCustomer($id)
    {
        $customer = \App\Models\User::where('role', 'Customer')->findOrFail($id);
        $customer->is_suspended = false;
        $customer->save();

        // Send notification to customer
        \App\Models\ConsultationNotification::create([
            'consultation_id' => null,
            'user_id' => $customer->id,
            'type' => 'account_welcome',
            'title' => 'Account Reinstated',
            'message' => 'Your customer account has been reinstated. You can now access all features again.',
            'is_read' => false,
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Customer suspension removed.');
    }
    public function index()
    {
        $pending = ConsultantProfile::with('user')
            ->where('is_verified', false)
            ->where('is_rejected', false) // Includes resubmissions (is_rejected cleared on resubmit)
            ->whereNotNull('full_name')
            ->whereNotNull('expertise')
            ->whereNotNull('resume_path')
            ->orderByDesc('resubmitted_at') // Show resubmissions first
            ->orderByDesc('created_at')
            ->get();

        return view('admin-folder.consultants-pending', compact('pending'));
    }

    public function approve($id)
    {
        $profile = ConsultantProfile::with('user')->findOrFail($id);
        
        // Prevent approving directly rejected consultants - they must resubmit first
        if ($profile->is_rejected && !$profile->is_verified) {
            return back()->with('error', 'Cannot approve a rejected consultant directly. The consultant must resubmit their application first.');
        }
        
        // Set verified and remove rejection status if it exists
        // BUT keep rejection history (admin_note, rejected_at) for records
        $profile->is_verified = true;
        $profile->is_rejected = false;
        // Note: We keep admin_note and rejected_at for historical records
        $profile->save();

        // Send notification to consultant
        \App\Models\ConsultationNotification::create([
            'consultation_id' => null,
            'user_id' => $profile->user_id,
            'type' => 'consultant_approved',
            'title' => 'Account Approved!',
            'message' => 'Congratulations! Your consultant account has been approved. You can now start receiving consultation requests from clients.',
            'is_read' => false,
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Consultant approved successfully! They have been notified.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_note' => 'required|string|min:10|max:2000',
        ], [
            'admin_note.required' => 'Please provide a reason for rejection.',
            'admin_note.min' => 'The rejection reason must be at least 10 characters.',
        ]);
        
        $profile = ConsultantProfile::with('user')->findOrFail($id);
        $profile->is_rejected = true;
        $profile->is_verified = false; // Ensure they're not verified if rejected
        $profile->admin_note = $request->input('admin_note');
        $profile->rejected_at = now(); // Track when rejected
        $profile->save();

        // Send notification to consultant
        \App\Models\ConsultationNotification::create([
            'consultation_id' => null,
            'user_id' => $profile->user_id,
            'type' => 'consultant_rejected',
            'title' => 'Account Review Update',
            'message' => 'Your consultant account application has been reviewed. Unfortunately, we are unable to approve your account at this time. Reason: ' . $request->input('admin_note') . ' Please review your application and feel free to reapply with updated information.',
            'is_read' => false,
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Consultant rejected. They have been notified with the reason.');
    }

    /**
     * Soft-suspend a consultant (reuses is_rejected flag but keeps is_verified true).
     */
    public function suspend(Request $request, $id)
    {
        $request->validate([
            'duration' => 'required|in:12hrs,1day,3days,7days,permanent',
            'reason' => 'nullable|string|max:500',
        ]);

        $profile = ConsultantProfile::findOrFail($id);
        
        // Calculate suspended_until based on duration
        $suspendedUntil = null;
        switch ($request->input('duration')) {
            case '12hrs':
                $suspendedUntil = now()->addHours(12);
                break;
            case '1day':
                $suspendedUntil = now()->addDay();
                break;
            case '3days':
                $suspendedUntil = now()->addDays(3);
                break;
            case '7days':
                $suspendedUntil = now()->addDays(7);
                break;
            case 'permanent':
                $suspendedUntil = null; // null means permanent until manually unsuspended
                break;
        }

        // Keep is_verified = true to distinguish from rejection
        $profile->is_rejected = true;
        $profile->suspended_until = $suspendedUntil;
        $profile->save();

        // Log suspension to history
        ConsultantSuspensionHistory::create([
            'consultant_profile_id' => $profile->id,
            'admin_id' => Auth::id(),
            'action' => 'suspended',
            'duration' => $request->input('duration'),
            'suspended_until' => $suspendedUntil,
            'action_date' => now(),
            'reason' => $request->input('reason'),
        ]);

        // Prepare notification message
        $durationMap = [
            '12hrs' => '12 hours',
            '1day' => '1 day',
            '3days' => '3 days',
            '7days' => '7 days',
            'permanent' => 'an indefinite period'
        ];
        $durationText = $durationMap[$request->input('duration')] ?? $request->input('duration');
        
        $message = 'Your consultant account has been suspended';
        
        if ($request->input('duration') === 'permanent') {
            $message .= ' permanently (until manually unsuspended)';
        } elseif ($suspendedUntil) {
            $message .= ' for ' . $durationText . ' until ' . $suspendedUntil->format('M d, Y \a\t g:i A');
        } else {
            $message .= ' for ' . $durationText;
        }
        
        if ($request->input('reason')) {
            $message .= ".\n\nReason: " . $request->input('reason');
        }
        
        $message .= "\n\nPlease contact support if you have any questions or concerns.";

        // Send notification to consultant
        \App\Models\ConsultationNotification::create([
            'consultation_id' => null,
            'user_id' => $profile->user_id,
            'type' => 'consultant_suspended',
            'title' => 'Account Suspended',
            'message' => $message,
            'is_read' => false,
            'sent_at' => now(),
        ]);

        $durationText = $request->input('duration') === 'permanent' 
            ? 'permanently (until manually unsuspended)' 
            : 'until ' . $suspendedUntil->format('M d, Y \a\t g:i A');

        return back()->with('success', "Consultant has been suspended {$durationText}.");
    }

    /**
     * Remove suspension for a consultant (only if they were verified).
     */
    public function unsuspend($id)
    {
        $profile = ConsultantProfile::findOrFail($id);
        
        // Only unsuspend if they were previously verified (suspended, not rejected)
        if (!$profile->is_verified) {
            return back()->with('error', 'Cannot unsuspend a rejected consultant. Please approve them instead.');
        }
        
        // Log unsuspension to history before clearing suspension data
        ConsultantSuspensionHistory::create([
            'consultant_profile_id' => $profile->id,
            'admin_id' => Auth::id(),
            'action' => 'unsuspended',
            'duration' => null,
            'suspended_until' => null,
            'action_date' => now(),
            'reason' => null,
        ]);
        
        $profile->is_rejected = false;
        $profile->suspended_until = null; // Clear suspension duration
        $profile->save();

        // Send notification to consultant
        \App\Models\ConsultationNotification::create([
            'consultation_id' => null,
            'user_id' => $profile->user_id,
            'type' => 'consultant_unsuspended',
            'title' => 'Account Reinstated',
            'message' => 'Your consultant account suspension has been removed. Your account is now active and you can access all features again. Welcome back!',
            'is_read' => false,
            'sent_at' => now(),
        ]);

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

    public function approveUpdate($id)
    {
        $profile = ConsultantProfile::findOrFail($id);
        
        if (!$profile->has_pending_update) {
            return back()->withErrors(['error' => 'No pending update found for this consultant.']);
        }
        
        // Clear pending update flags and approve the changes
        $profile->has_pending_update = false;
        $profile->update_requested_at = null;
        $profile->previous_values = null;
        $profile->is_verified = true;
        $profile->save();
        
        // Send notification to consultant
        \App\Models\ConsultationNotification::create([
            'user_id' => $profile->user_id,
            'type' => 'consultant_update_approved',
            'title' => 'Profile Update Approved',
            'message' => 'Your profile update has been approved by the admin.',
            'consultation_id' => null,
        ]);
        
        return back()->with('success', 'Profile update approved successfully.');
    }

    public function rejectUpdate(Request $request, $id)
    {
        $request->validate([
            'admin_note' => 'required|string|min:10|max:500',
        ]);
        
        $profile = ConsultantProfile::findOrFail($id);
        
        if (!$profile->has_pending_update) {
            return back()->withErrors(['error' => 'No pending update found for this consultant.']);
        }
        
        // Restore previous values (excluding avatar/picture as per user requirement)
        if ($profile->previous_values) {
            $previousValues = $profile->previous_values;
            $profile->full_name = $previousValues['full_name'] ?? $profile->full_name;
            $profile->email = $previousValues['email'] ?? $profile->email;
            $profile->phone_number = $previousValues['phone_number'] ?? $profile->phone_number;
            $profile->age = $previousValues['age'] ?? $profile->age;
            $profile->sex = $previousValues['sex'] ?? $profile->sex;
            $profile->expertise = $previousValues['expertise'] ?? $profile->expertise;
            $profile->address = $previousValues['address'] ?? $profile->address;
            // Note: avatar_path is NOT restored - profile picture changes are not tracked/restored
            if (isset($previousValues['resume_path'])) {
                $profile->resume_path = $previousValues['resume_path'];
            }
        }
        
        // Clear pending update flags
        $profile->has_pending_update = false;
        $profile->update_requested_at = null;
        $profile->previous_values = null;
        $profile->is_verified = true; // Keep verified status
        $profile->save();
        
        // Send notification to consultant
        \App\Models\ConsultationNotification::create([
            'user_id' => $profile->user_id,
            'type' => 'consultant_update_rejected',
            'title' => 'Profile Update Rejected',
            'message' => 'Your profile update has been rejected. Reason: ' . $request->admin_note,
            'consultation_id' => null,
        ]);
        
        return back()->with('success', 'Profile update rejected. Previous values restored.');
    }
}


