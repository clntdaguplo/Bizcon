<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\ConsultantProfile;
use App\Models\ConsultationNotification;
use App\Models\ConsultationRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ConsultationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'consultant_id' => 'required|exists:consultant_profiles,id',
            'topic' => 'required|string|max:255',
            'details' => 'nullable|string',
            'preferred_date' => 'nullable|date',
            'preferred_time' => 'nullable',
        ]);

        Consultation::create([
            'customer_id' => Auth::id(),
            'consultant_profile_id' => (int) $validated['consultant_id'],
            'topic' => $validated['topic'],
            'details' => $validated['details'] ?? null,
            'preferred_date' => $validated['preferred_date'] ?? null,
            'preferred_time' => $validated['preferred_time'] ?? null,
            'status' => 'Pending',
        ]);

        return redirect()->route('customer.my-consults')->with('success', 'Consultation request submitted.');
    }

    public function consultantInbox()
    {
        $profile = ConsultantProfile::where('user_id', Auth::id())->firstOrFail();
        $consultations = Consultation::with('customer')
            ->where('consultant_profile_id', $profile->id)
            ->orderByDesc('created_at')
            ->paginate(15);

        // Auto-expire old pending/proposed requests based on preferred date
        foreach ($consultations as $consultation) {
            $consultation->markExpiredIfPastPreferredDate();
        }

        return view('consultant-folder.consultations', compact('consultations'));
    }

    // Show consultation requests for the authenticated customer
    public function customerHistory()
    {
        $consultations = Consultation::with(['consultantProfile.user'])
            ->where('customer_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(12);

        // Auto-expire old pending/proposed requests based on preferred date
        foreach ($consultations as $consultation) {
            $consultation->markExpiredIfPastPreferredDate();
        }

        return view('customer-folder.my-consults', compact('consultations'));
    }

    public function acceptConsultation($id)
    {
        $consultation = Consultation::where('consultant_profile_id', 
            ConsultantProfile::where('user_id', Auth::id())->first()->id)
            ->findOrFail($id);
        
        $consultation->status = 'Accepted';
        $consultation->save();

        return back()->with('success', 'Consultation request accepted successfully.');
    }

    public function rejectConsultation($id)
    {
        $consultation = Consultation::where('consultant_profile_id', 
            ConsultantProfile::where('user_id', Auth::id())->first()->id)
            ->findOrFail($id);
        
        $consultation->status = 'Rejected';
        $consultation->save();

        return back()->with('success', 'Consultation request rejected.');
    }

    public function completeConsultation($id)
    {
        $consultation = Consultation::where('consultant_profile_id', 
            ConsultantProfile::where('user_id', Auth::id())->first()->id)
            ->findOrFail($id);
        
        $consultation->status = 'Completed';
        $consultation->save();

        return back()->with('success', 'Consultation marked as completed.');
    }

    public function respondToConsultation(Request $request, $id)
    {
        $rules = [
            'response_type' => 'required|in:accept,propose,reject',
            'response_message' => 'nullable|string|max:1000',
            'alternative_date' => 'nullable|date',
            'alternative_time' => 'nullable',
        ];

        // Only require proposed_date and proposed_time if response_type is 'propose'
        if ($request->response_type === 'propose') {
            $rules['proposed_date'] = 'required|date';
            $rules['proposed_time'] = 'required';
        } else {
            $rules['proposed_date'] = 'nullable|date';
            $rules['proposed_time'] = 'nullable';
        }

        $request->validate($rules);

        $profile = ConsultantProfile::where('user_id', Auth::id())->firstOrFail();
        $consultation = Consultation::where('consultant_profile_id', $profile->id)
            ->findOrFail($id);

        if ($request->response_type === 'accept') {
            // Accept with same date & time or alternative
            $scheduledDate = $request->alternative_date ?: $consultation->preferred_date;
            $scheduledTime = $request->alternative_time ?: $consultation->preferred_time;

            // Ensure we have a date and time
            if (!$scheduledDate || !$scheduledTime) {
                return back()->withErrors(['error' => 'Please provide a date and time, or ensure the customer has specified preferred date and time.'])->withInput();
            }

            // Check for conflicts
            if (Consultation::hasConflict($profile->id, $scheduledDate, $scheduledTime, $consultation->id)) {
                return back()->withErrors(['conflict' => 'Schedule Conflict – Please choose another time. You are already booked at this time.'])->withInput();
            }

            $consultation->status = 'Accepted';
            $consultation->scheduled_date = $scheduledDate;
            $consultation->scheduled_time = $scheduledTime;
            $consultation->proposal_status = null;
            $consultation->proposed_date = null;
            $consultation->proposed_time = null;

            // Create Google Meet link only when both agree
            $this->createGoogleMeetLink($consultation, $profile);

            // Create notification for customer
            $this->createNotification(
                $consultation,
                $consultation->customer_id,
                'status_change',
                'Consultation Accepted',
                "Your consultation request for '{$consultation->topic}' has been accepted. Scheduled for " . 
                \Carbon\Carbon::parse($scheduledDate)->format('M j, Y') . ' at ' . 
                \Carbon\Carbon::parse($scheduledTime)->format('g:i A')
            );

            $message = 'Consultation request accepted and scheduled.';
        } elseif ($request->response_type === 'propose') {
            // Propose new schedule
            $proposedDate = $request->proposed_date;
            $proposedTime = $request->proposed_time;

            // Check for conflicts
            if (Consultation::hasConflict($profile->id, $proposedDate, $proposedTime, $consultation->id)) {
                return back()->withErrors(['conflict' => 'Schedule Conflict – Please choose another time. You are already booked at this time.'])->withInput();
            }

            $consultation->status = 'Proposed';
            $consultation->proposed_date = $proposedDate;
            $consultation->proposed_time = $proposedTime;
            $consultation->proposal_status = 'pending';

            // Create notification for customer
            $this->createNotification(
                $consultation,
                $consultation->customer_id,
                'proposal',
                'New Schedule Proposed',
                "Consultant proposed a new schedule: " . 
                \Carbon\Carbon::parse($proposedDate)->format('M j, Y') . ' at ' . 
                \Carbon\Carbon::parse($proposedTime)->format('g:i A') . 
                ($request->response_message ? "\n\nMessage: " . $request->response_message : '')
            );

            $message = 'New schedule proposed to client.';
        } else {
            // Reject
            $consultation->status = 'Rejected';
            
            // Create notification for customer
            $this->createNotification(
                $consultation,
                $consultation->customer_id,
                'status_change',
                'Consultation Rejected',
                "Your consultation request for '{$consultation->topic}' has been rejected." . 
                ($request->response_message ? "\n\nReason: " . $request->response_message : '')
            );

            $message = 'Consultation request rejected.';
        }

        if ($request->response_message) {
            $consultation->details = trim(($consultation->details ?? '') . "\n\nConsultant message: " . $request->response_message);
        }

        $consultation->save();

        return redirect()->route('consultant.consultations')->with('success', $message);
    }

    /**
     * Client responds to consultant's proposed schedule
     */
    public function respondToProposal(Request $request, $id)
    {
        $request->validate([
            'proposal_response' => 'required|in:accept,decline',
        ]);

        $consultation = Consultation::where('customer_id', Auth::id())
            ->findOrFail($id);

        if ($consultation->proposal_status !== 'pending') {
            return back()->withErrors(['error' => 'This proposal has already been responded to.']);
        }

        if ($request->proposal_response === 'accept') {
            // Accept the proposed time
            $consultation->status = 'Accepted';
            $consultation->scheduled_date = $consultation->proposed_date;
            $consultation->scheduled_time = $consultation->proposed_time;
            $consultation->proposal_status = 'accepted';
            $consultation->proposed_date = null;
            $consultation->proposed_time = null;

            // Create Google Meet link only when both agree
            $profile = $consultation->consultantProfile;
            $this->createGoogleMeetLink($consultation, $profile);

            // Create notification for consultant
            $this->createNotification(
                $consultation,
                $profile->user_id,
                'status_change',
                'Proposal Accepted',
                "Client accepted your proposed schedule for '{$consultation->topic}'."
            );

            $message = 'Proposed schedule accepted. Meeting link has been created.';
        } else {
            // Decline the proposal
            $consultation->proposal_status = 'declined';
            $consultation->status = 'Pending'; // Back to pending for new proposal

            // Create notification for consultant
            $profile = $consultation->consultantProfile;
            $this->createNotification(
                $consultation,
                $profile->user_id,
                'proposal',
                'Proposal Declined',
                "Client declined your proposed schedule for '{$consultation->topic}'. Please propose another time."
            );

            $message = 'Proposed schedule declined.';
        }

        $consultation->save();

        return redirect()->route('customer.my-consults')->with('success', $message);
    }

    /**
     * Customer cancels their own consultation request (if not completed/rejected)
     */
    public function cancelByCustomer($id)
    {
        $consultation = Consultation::where('customer_id', Auth::id())->findOrFail($id);

        if (in_array($consultation->status, ['Completed', 'Cancelled', 'Rejected'], true)) {
            return back()->withErrors(['error' => 'You can no longer cancel this consultation.']);
        }

        $consultation->status = 'Cancelled';
        $consultation->proposal_status = null;
        $consultation->proposed_date = null;
        $consultation->proposed_time = null;
        $consultation->save();

        // Notify consultant about cancellation if a consultant profile is linked
        $profile = $consultation->consultantProfile;
        if ($profile) {
            $this->createNotification(
                $consultation,
                $profile->user_id,
                'status_change',
                'Consultation Cancelled',
                "The client cancelled the consultation request for '{$consultation->topic}'."
            );
        }

        return back()->with('success', 'Your consultation has been cancelled.');
    }

    /**
     * Show edit form for customer's consultation request
     */
    public function edit($id)
    {
        $consultation = Consultation::where('customer_id', Auth::id())
            ->with(['consultantProfile.user'])
            ->findOrFail($id);

        // Only allow editing if status is Pending, Proposed, or Expired
        if (!in_array($consultation->status, ['Pending', 'Proposed', 'Expired'], true)) {
            return redirect()->route('customer.my-consults')
                ->withErrors(['error' => 'You can only edit consultations that are Pending, Proposed, or Expired.']);
        }

        return view('customer-folder.edit-consult', compact('consultation'));
    }

    /**
     * Update customer's consultation request
     */
    public function update(Request $request, $id)
    {
        $consultation = Consultation::where('customer_id', Auth::id())->findOrFail($id);

        // Only allow editing if status is Pending, Proposed, or Expired
        if (!in_array($consultation->status, ['Pending', 'Proposed', 'Expired'], true)) {
            return redirect()->route('customer.my-consults')
                ->withErrors(['error' => 'You can only edit consultations that are Pending, Proposed, or Expired.']);
        }

        $validated = $request->validate([
            'topic' => 'required|string|max:255',
            'details' => 'nullable|string',
            'preferred_date' => 'nullable|date|after_or_equal:today',
            'preferred_time' => 'nullable',
        ]);

        // Update consultation fields
        $consultation->topic = $validated['topic'];
        $consultation->details = $validated['details'] ?? null;
        $consultation->preferred_date = $validated['preferred_date'] ?? null;
        $consultation->preferred_time = $validated['preferred_time'] ?? null;

        // If status was Expired, reset to Pending when updated
        if ($consultation->status === 'Expired') {
            $consultation->status = 'Pending';
        }

        // Clear any pending proposals when customer updates their request
        if ($consultation->proposal_status === 'pending') {
            $consultation->proposal_status = null;
            $consultation->proposed_date = null;
            $consultation->proposed_time = null;
        }

        $consultation->save();

        // Notify consultant about the update
        $profile = $consultation->consultantProfile;
        if ($profile) {
            $this->createNotification(
                $consultation,
                $profile->user_id,
                'status_change',
                'Consultation Request Updated',
                "The client has updated their consultation request for '{$consultation->topic}'. Please review the new details."
            );
        }

        return redirect()->route('customer.my-consults')
            ->with('success', 'Your consultation request has been updated successfully.');
    }

    /**
     * Create Google Meet link when both parties agree
     */
    protected function createGoogleMeetLink($consultation, $consultantProfile)
    {
        // Try to create real Google Calendar event
        $meetLink = $this->createGoogleEvent($consultation, $consultantProfile);
        
        if ($meetLink) {
            $consultation->meeting_link = $meetLink;
        } else {
            // Fallback: generate placeholder link
            $token = strtolower(bin2hex(random_bytes(3)));
            $consultation->meeting_link = 'https://meet.google.com/' . substr($token,0,3) . '-' . substr($token,3,3) . '-' . substr($token,6,2);
        }
        
        $consultation->save();
    }

    /**
     * Create a notification for a user
     */
    protected function createNotification($consultation, $userId, $type, $title, $message)
    {
        ConsultationNotification::create([
            'consultation_id' => $consultation->id,
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'sent_at' => now(),
        ]);
    }

    /**
     * Show form to create consultation report
     */
    public function showReportForm($id)
    {
        $profile = ConsultantProfile::where('user_id', Auth::id())->firstOrFail();
        $consultation = Consultation::with(['customer', 'consultantProfile'])
            ->where('consultant_profile_id', $profile->id)
            ->findOrFail($id);

        if ($consultation->status !== 'Completed') {
            return back()->withErrors(['error' => 'You can only create reports for completed consultations.']);
        }

        return view('consultant-folder.create-report', compact('consultation'));
    }

    /**
     * Save consultation report
     */
    public function saveReport(Request $request, $id)
    {
        $request->validate([
            'consultation_summary' => 'required|string|max:5000',
            'recommendations' => 'required|string|max:5000',
            'client_readiness_rating' => 'required|integer|min:1|max:5',
        ]);

        $profile = ConsultantProfile::where('user_id', Auth::id())->firstOrFail();
        $consultation = Consultation::where('consultant_profile_id', $profile->id)
            ->findOrFail($id);

        if ($consultation->status !== 'Completed') {
            return back()->withErrors(['error' => 'You can only create reports for completed consultations.']);
        }

        $consultation->consultation_summary = $request->consultation_summary;
        $consultation->recommendations = $request->recommendations;
        $consultation->client_readiness_rating = $request->client_readiness_rating;
        $consultation->save();

        // Generate PDF report
        $pdfPath = $this->generateReportPDF($consultation);
        if ($pdfPath) {
            $consultation->report_file_path = $pdfPath;
            $consultation->save();
        }

        // Notify customer that report is ready
        $this->createNotification(
            $consultation,
            $consultation->customer_id,
            'status_change',
            'Consultation Report Ready',
            "Your consultation report for '{$consultation->topic}' is now available for download."
        );

        return redirect()->route('consultant.consultations')->with('success', 'Consultation report created successfully.');
    }

    /**
     * Download consultation report
     */
    public function downloadReport($id)
    {
        $consultation = Consultation::with(['customer', 'consultantProfile.user'])->findOrFail($id);
        
        // Check if user has access (either customer or consultant)
        $hasAccess = false;
        if (Auth::user()->role === 'Customer' && $consultation->customer_id === Auth::id()) {
            $hasAccess = true;
        } elseif (Auth::user()->role === 'Consultant') {
            $profile = ConsultantProfile::where('user_id', Auth::id())->first();
            if ($profile && $consultation->consultant_profile_id === $profile->id) {
                $hasAccess = true;
            }
        } elseif (Auth::user()->role === 'Admin') {
            $hasAccess = true;
        }

        if (!$hasAccess) {
            abort(403, 'Unauthorized access to this report.');
        }

        if (!$consultation->consultation_summary) {
            return back()->withErrors(['error' => 'Report not yet created for this consultation.']);
        }

        return view('consultation-report', compact('consultation'));
    }

    /**
     * Generate PDF report (simple HTML to PDF approach)
     */
    protected function generateReportPDF($consultation)
    {
        // For now, we'll return null and use HTML view for download
        // In production, you can install barryvdh/laravel-dompdf and generate actual PDF
        // For now, the downloadReport method will serve an HTML view that can be printed as PDF
        return null;
    }

    /**
     * Show rating form
     */
    public function showRatingForm($id)
    {
        $consultation = Consultation::with(['customer', 'consultantProfile.user'])->findOrFail($id);
        
        // Determine if current user is customer or consultant
        $isCustomer = Auth::user()->role === 'Customer' && $consultation->customer_id === Auth::id();
        $isConsultant = false;
        if (Auth::user()->role === 'Consultant') {
            $profile = ConsultantProfile::where('user_id', Auth::id())->first();
            $isConsultant = $profile && $consultation->consultant_profile_id === $profile->id;
        }

        if (!$isCustomer && !$isConsultant) {
            abort(403, 'Unauthorized access.');
        }

        if ($consultation->status !== 'Completed') {
            return back()->withErrors(['error' => 'You can only rate completed consultations.']);
        }

        $raterType = $isCustomer ? 'customer' : 'consultant';
        $existingRating = ConsultationRating::where('consultation_id', $consultation->id)
            ->where('rater_id', Auth::id())
            ->where('rater_type', $raterType)
            ->first();

        return view('consultation-rating', compact('consultation', 'raterType', 'existingRating'));
    }

    /**
     * Save rating
     */
    public function saveRating(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $consultation = Consultation::findOrFail($id);
        
        // Determine if current user is customer or consultant
        $isCustomer = Auth::user()->role === 'Customer' && $consultation->customer_id === Auth::id();
        $isConsultant = false;
        if (Auth::user()->role === 'Consultant') {
            $profile = ConsultantProfile::where('user_id', Auth::id())->first();
            $isConsultant = $profile && $consultation->consultant_profile_id === $profile->id;
        }

        if (!$isCustomer && !$isConsultant) {
            abort(403, 'Unauthorized access.');
        }

        if ($consultation->status !== 'Completed') {
            return back()->withErrors(['error' => 'You can only rate completed consultations.']);
        }

        $raterType = $isCustomer ? 'customer' : 'consultant';

        // Update or create rating
        ConsultationRating::updateOrCreate(
            [
                'consultation_id' => $consultation->id,
                'rater_id' => Auth::id(),
                'rater_type' => $raterType,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        $redirectRoute = $isCustomer ? 'customer.my-consults' : 'consultant.consultations';
        return redirect()->route($redirectRoute)->with('success', 'Rating submitted successfully.');
    }

    // Show a single pending consultation for consultant to open and schedule
    public function openRequest($id)
    {
        $profile = ConsultantProfile::where('user_id', Auth::id())->firstOrFail();
        $consultation = Consultation::with(['customer', 'consultantProfile'])
            ->where('consultant_profile_id', $profile->id)
            ->findOrFail($id);

        // If this request is already past its preferred date, mark as expired and block actions
        $consultation->markExpiredIfPastPreferredDate();
        if ($consultation->status === 'Expired') {
            return redirect()->route('consultant.consultations')
                ->withErrors(['error' => 'This consultation request has expired and can no longer be accepted.']);
        }

        return view('consultant-folder.open-request', compact('consultation'));
    }

    /**
     * Try to create a Google Calendar event (with Meet link) for the given consultation.
     * Returns the meeting link on success or null on failure/if not available.
     */
    protected function createGoogleEvent($consultation, $consultantProfile)
    {
        if (!class_exists('Google_Client')) {
            return null; // google client library not installed
        }

        $tokenJson = $consultantProfile->google_token;
        if (!$tokenJson) {
            return null; // not connected
        }

        $token = json_decode($tokenJson, true);

        $client = new \Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        $client->setAccessToken($token);

        // Refresh token if needed
        if ($client->isAccessTokenExpired() && isset($token['refresh_token'])) {
            $newToken = $client->fetchAccessTokenWithRefreshToken($token['refresh_token']);
            $client->setAccessToken($newToken);
            // persist the new token back
            $consultantProfile->google_token = json_encode(array_merge($token, $newToken));
            $consultantProfile->save();
        }

        try {
            $service = new \Google_Service_Calendar($client);

            $startDateTime = $consultation->scheduled_date ? $consultation->scheduled_date : $consultation->preferred_date;
            $startTime = $consultation->scheduled_time ? $consultation->scheduled_time : $consultation->preferred_time;

            if (!$startDateTime) return null; // need a date to schedule

            // Build RFC3339 datetime
            $start = new \DateTime($startDateTime . ' ' . ($startTime ?: '00:00'));
            $end = (clone $start)->modify('+1 hour');

            $event = new \Google_Service_Calendar_Event([
                'summary' => 'Consultation: ' . $consultation->topic,
                'description' => 'Consultation between ' . ($consultation->customer->name ?? '') . ' and consultant.',
                'start' => ['dateTime' => $start->format(DateTime::RFC3339), 'timeZone' => config('app.timezone')],
                'end' => ['dateTime' => $end->format(DateTime::RFC3339), 'timeZone' => config('app.timezone')],
                'conferenceData' => [
                    'createRequest' => [
                        'requestId' => 'meet-' . uniqid(),
                        'conferenceSolutionKey' => ['type' => 'hangoutsMeet']
                    ]
                ]
            ]);

            $optParams = ['conferenceDataVersion' => 1];
            $created = $service->events->insert('primary', $event, $optParams);

            // Parse meeting link
            if (isset($created->conferenceData) && isset($created->conferenceData->entryPoints) && count($created->conferenceData->entryPoints) > 0) {
                foreach ($created->conferenceData->entryPoints as $entry) {
                    if ($entry->entryPointType === 'video') {
                        return $entry->uri;
                    }
                }
            }

        } catch (\Exception $e) {
            // silently fail — leave meeting link null
            \Log::error('Google Calendar event creation failed: ' . $e->getMessage());
            return null;
        }

        return null;
    }
}


