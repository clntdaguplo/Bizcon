<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\ConsultationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('status', 'all'); // all|approved|rejected

        $pending = Subscription::with('user')
            ->where('plan_type', 'pro')
            ->where('payment_status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        $recent = Subscription::with('user')
            ->where('plan_type', 'pro')
            ->whereIn('payment_status', ['approved', 'rejected'])
            ->when($filter !== 'all', function ($q) use ($filter) {
                $q->where('payment_status', $filter);
            })
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();

        return view('admin-folder.payments', compact('pending', 'recent', 'filter'));
    }

    public function approve($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->payment_status = 'approved';
        $subscription->status = 'active';
        $subscription->approved_at = now();
        $subscription->approved_by = Auth::id();
        $subscription->expires_at = now()->addDays(30);
        $subscription->save();

        // Send approval notification to customer
        ConsultationNotification::create([
            'consultation_id' => null,
            'user_id' => $subscription->user_id,
            'type' => 'payment_approved',
            'title' => 'Payment Approved',
            'message' => 'Your subscription payment has been approved! You can now book consultations for 30 days.',
            'is_read' => false,
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Payment approved and subscription activated.');
    }

    public function reject(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->payment_status = 'rejected';
        $subscription->status = 'rejected';
        $subscription->approved_by = Auth::id();
        $subscription->save();

        // Send rejection notification to customer
        ConsultationNotification::create([
            'consultation_id' => null,
            'user_id' => $subscription->user_id,
            'type' => 'payment_rejected',
            'title' => 'Payment Rejected',
            'message' => 'Your subscription payment was rejected. Please submit a new payment proof to continue.',
            'is_read' => false,
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Payment rejected.');
    }
}

