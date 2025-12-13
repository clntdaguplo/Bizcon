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

        $current = Subscription::where('user_id', $user->id)->latest()->first();

        // Auto-expire free trial if countdown finished
        if ($current && $current->plan_type === 'free_trial' && $current->expires_at && now()->greaterThanOrEqualTo($current->expires_at)) {
            $current->status = 'expired';
            $current->minutes_used = $current->minutes_total ?? 20;
            $current->save();
        }

        // Auto-expire Pro subscription if 30 days passed
        if ($current && $current->plan_type === 'pro' && $current->expires_at && now()->greaterThanOrEqualTo($current->expires_at)) {
            $current->status = 'expired';
            $current->save();
        }

        // Backfill expires_at for Pro subscriptions missing it
        if ($current && $current->plan_type === 'pro' && $current->approved_at && !$current->expires_at) {
            $current->expires_at = $current->approved_at->copy()->addDays(30);
            $current->save();
        }

        $hasTrial = Subscription::where('user_id', $user->id)->where('plan_type', 'free_trial')->exists();
        $history = Subscription::where('user_id', $user->id)->orderByDesc('created_at')->get();

        return view('customer-folder.plans', [
            'current' => $current,
            'trialAvailable' => !$hasTrial,
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
            'plan_type' => 'required|in:free_trial,pro',
        ]);

        if ($request->plan_type === 'free_trial') {
            $existingTrial = Subscription::where('user_id', $user->id)
                ->where('plan_type', 'free_trial')
                ->first();

            if ($existingTrial) {
                return back()->withErrors(['plan_type' => 'Free Trial already used on this account.']);
            }

            Subscription::create([
                'user_id' => $user->id,
                'plan_type' => 'free_trial',
                'status' => 'active',
                'payment_method' => 'n/a',
                'payment_status' => 'not_required',
                'minutes_total' => 20,
                'minutes_used' => 0,
                'expires_at' => now()->addMinutes(20),
                'approved_at' => now(),
            ]);

            return redirect()->route('dashboard.customer')->with('success', 'Free Trial activated — enjoy your 20 minutes!');
        }

        // Pro plan flow
        $request->validate([
            'payment_method' => 'required|in:gcash,paymaya',
            'proof' => 'required|image|max:4096',
        ]);

        $path = $request->file('proof')->store('payment_proofs', 'public');

        Subscription::create([
            'user_id' => $user->id,
            'plan_type' => 'pro',
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'proof_path' => $path,
        ]);

        return back()->with('success', 'Payment submitted. Waiting for admin approval.');
    }
}

