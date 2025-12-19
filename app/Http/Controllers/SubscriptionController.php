<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class SubscriptionController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (! Schema::hasTable('subscriptions')) {
            return back()->with('error', 'Subscriptions table not found. Please run migrations.');
        }

        $current = $user->activeSubscription();

        $hasFree = Subscription::where('user_id', $user->id)->where('plan_type', 'Free')->exists();
        $history = Subscription::where('user_id', $user->id)->orderByDesc('created_at')->get();

        return view('customer-folder.plans', [
            'current' => $current,
            'isFreeAvailable' => !$hasFree,
            'history' => $history,
        ]);
    }

    public function choose(Request $request)
    {
        $user = Auth::user();
        if (! Schema::hasTable('subscriptions')) {
            return back()->with('error', 'Subscriptions table not found. Please run migrations.');
        }

        $request->validate([
            'plan_type' => 'required|in:Free,Weekly,Quarterly,Annual',
        ]);

        if ($request->plan_type === 'Free') {
            $existingFree = Subscription::where('user_id', $user->id)
                ->where('plan_type', 'Free')
                ->first();

            if ($existingFree) {
                return back()->withErrors(['plan_type' => 'Free plan already activated on this account.']);
            }

            Subscription::create([
                'user_id' => $user->id,
                'plan_type' => 'Free',
                'status' => 'active',
                'payment_method' => 'n/a',
                'payment_status' => 'approved', // Free is auto-approved
                'minutes_total' => 20, // Free trial valid for 20 minutes
                'minutes_used' => 0,
                'expires_at' => null, // Never expires or handle as needed
                'approved_at' => now(),
            ]);

            return redirect()->route('dashboard.customer')->with('success', 'Free plan activated — enjoy limited access!');
        }

        // Paid plans flow
        $request->validate([
            'payment_method' => 'required|in:gcash,paymaya',
            'proof' => 'required|image|max:4096',
        ]);

        $path = $request->file('proof')->store('payment_proofs', 'public');

        // Determine expiration duration
        $days = match($request->plan_type) {
            'Weekly' => 7,
            'Quarterly' => 90,
            'Annual' => 365,
            default => 30
        };

        Subscription::create([
            'user_id' => $user->id,
            'plan_type' => $request->plan_type,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'proof_path' => $path,
            'expires_at' => now()->addDays($days), // This will be finalized on approval in AdminController if needed, or started now
        ]);

        return back()->with('success', 'Payment submitted for ' . $request->plan_type . ' plan. Waiting for admin approval.');
    }
}



