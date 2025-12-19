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
            ->where('plan_type', '!=', 'Free')
            ->where('payment_status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        $recent = Subscription::with('user')
            ->where('plan_type', '!=', 'Free')
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
        
        $limits = \App\Services\SubscriptionService::getTierLimits($subscription->plan_type);
        $subscription->price = $limits['price'] ?? 0;
        
        // Determine expiration duration
        $days = match($subscription->plan_type) {
            'Weekly' => 7,
            'Quarterly' => 90,
            'Annual' => 365,
            default => 30
        };
        
        $subscription->expires_at = now()->addDays($days);
        $subscription->save();

        // Send approval notification to customer
        ConsultationNotification::create([
            'consultation_id' => null,
            'user_id' => $subscription->user_id,
            'type' => 'payment_approved',
            'title' => 'Payment Approved',
            'message' => 'Your ' . $subscription->plan_type . ' subscription payment has been approved! Your benefits are now active.',
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



