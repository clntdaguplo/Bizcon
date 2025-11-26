<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\ConsultantProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('consultant-folder.consultations', compact('consultations'));
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
        $request->validate([
            'response_type' => 'required|in:accept,reject',
            'response_message' => 'nullable|string|max:1000',
            'alternative_date' => 'nullable|date',
            'alternative_time' => 'nullable',
        ]);

        $consultation = Consultation::where('consultant_profile_id', 
            ConsultantProfile::where('user_id', Auth::id())->first()->id)
            ->findOrFail($id);
        
        $consultation->status = $request->response_type === 'accept' ? 'Accepted' : 'Rejected';
        $consultation->save();

        $message = $request->response_type === 'accept' 
            ? 'Consultation request accepted successfully.' 
            : 'Consultation request rejected.';

        return back()->with('success', $message);
    }
}


