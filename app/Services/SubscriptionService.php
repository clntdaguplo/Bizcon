<?php

namespace App\Services;

use App\Models\User;
use App\Models\Subscription;

class SubscriptionService
{
    public const TIER_FREE = 'Free';
    public const TIER_WEEKLY = 'Weekly';
    public const TIER_QUARTERLY = 'Quarterly';
    public const TIER_ANNUAL = 'Annual';

    /**
     * Get the active subscription for a user.
     */
    public static function getActiveSubscription(User $user): ?Subscription
    {
        return Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('payment_status', 'approved')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->orderByDesc('created_at')
            ->first();
    }

    /**
     * Get the current tier for a user.
     */
    public static function getTier(User $user): string
    {
        $sub = self::getActiveSubscription($user);
        return $sub ? $sub->plan_type : self::TIER_FREE;
    }

    /**
     * Check if a user has access to a specific feature.
     */
    public static function hasFeature(User $user, string $feature): bool
    {
        $tier = self::getTier($user);

        switch ($feature) {
            case 'rating':
            case 'feedback':
            case 'summary':
                return $tier !== self::TIER_FREE;

            case 'report_export':
                return $tier !== self::TIER_FREE;

            case 'full_info_access':
            case 'view_consultation_details':
            case 'view_recent_sessions':
            case 'manage_personal_notes':
                return true;

            case 'see_top_experts':
            case 'browse_expertise':
                return $tier !== self::TIER_FREE;
            
            case 'prioritized_support':
                return in_array($tier, [self::TIER_QUARTERLY, self::TIER_ANNUAL]);

            case 'premium_support':
                return $tier === self::TIER_ANNUAL;

            case 'unlimited_data':
                return $tier === self::TIER_ANNUAL;

            default:
                return false;
        }
    }

    /**
     * Get the data subset limit for a user.
     * Returns an integer representing the maximum number of records or null for unlimited.
     */
    public static function getDataLimit(User $user): ?int
    {
        $tier = self::getTier($user);

        return match ($tier) {
            self::TIER_FREE => 5,
            self::TIER_WEEKLY => 20,
            self::TIER_QUARTERLY => 100,
            self::TIER_ANNUAL => null,
            default => 5,
        };
    }

    /**
     * Get the export limit description or value.
     */
    public static function getExportLimit(User $user): string
    {
        $tier = self::getTier($user);

        return match ($tier) {
            self::TIER_FREE => 'Disabled',
            self::TIER_WEEKLY => 'Weekly/Monthly',
            self::TIER_QUARTERLY => 'High Limit',
            self::TIER_ANNUAL => 'Unlimited',
            default => 'Disabled',
        };
    }

    /**
     * Get limits for each tier.
     */
    public static function getTierLimits(string $tier): array
    {
        return match ($tier) {
            self::TIER_FREE => [
                'total' => 1,
                'day' => null,
                'week' => null,
                'month' => null,
                'price' => 0,
            ],
            self::TIER_WEEKLY => [
                'total' => null,
                'day' => 1,
                'week' => 3,
                'month' => null,
                'price' => 299,
            ],
            self::TIER_QUARTERLY => [
                'total' => null,
                'day' => 1,
                'week' => null,
                'month' => 12,
                'price' => 999,
            ],
            self::TIER_ANNUAL => [
                'total' => null,
                'day' => 1,
                'week' => null,
                'month' => 4, // 4 per month as requested
                'price' => 3499,
            ],
            default => [
                'total' => 0,
                'day' => 0,
                'week' => 0,
                'month' => 0,
                'price' => 0,
            ],
        };
    }

    /**
     * Check if a user can book another consultation.
     * Returns ['allowed' => bool, 'reason' => string|null]
     */
    public static function checkConsultationEligibility(User $user, $requestedDate = null): array
    {
        $tier = self::getTier($user);
        $limits = self::getTierLimits($tier);
        
        // 1. Same-day check
        if ($requestedDate) {
            $requested = \Carbon\Carbon::parse($requestedDate)->startOfDay();
            if ($requested->isToday()) {
                return ['allowed' => false, 'reason' => 'Same-day requests are not allowed. Please select a date from tomorrow onwards.'];
            }
        }

        // 2. Total limit (Free Trial)
        if ($limits['total'] !== null) {
            $totalCount = \App\Models\Consultation::where('customer_id', $user->id)
                ->whereNotIn('status', ['Cancelled', 'Rejected', 'Expired'])
                ->count();
            if ($totalCount >= $limits['total']) {
                return ['allowed' => false, 'reason' => "You have reached the maximum total limit of {$limits['total']} consultation(s) allowed on your plan."];
            }
        }

        // 3. Daily limit
        if ($limits['day'] !== null) {
            $dayCount = \App\Models\Consultation::where('customer_id', $user->id)
                ->whereDate('created_at', \Carbon\Carbon::today())
                ->whereNotIn('status', ['Cancelled', 'Rejected', 'Expired'])
                ->count();
            if ($dayCount >= $limits['day']) {
                return ['allowed' => false, 'reason' => "You have already requested a consultation today. Your plan is limited to {$limits['day']} request(s) per day."];
            }
        }

        // 4. Weekly limit
        if ($limits['week'] !== null) {
            $weekCount = \App\Models\Consultation::where('customer_id', $user->id)
                ->whereBetween('created_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()])
                ->whereNotIn('status', ['Cancelled', 'Rejected', 'Expired'])
                ->count();
            if ($weekCount >= $limits['week']) {
                return ['allowed' => false, 'reason' => "You have reached your weekly limit of {$limits['week']} consultations."];
            }
        }

        // 5. Monthly limit
        if ($limits['month'] !== null) {
            $monthCount = \App\Models\Consultation::where('customer_id', $user->id)
                ->whereBetween('created_at', [\Carbon\Carbon::now()->startOfMonth(), \Carbon\Carbon::now()->endOfMonth()])
                ->whereNotIn('status', ['Cancelled', 'Rejected', 'Expired'])
                ->count();
            if ($monthCount >= $limits['month']) {
                return ['allowed' => false, 'reason' => "You have reached your monthly limit of {$limits['month']} consultations."];
            }
        }

        return ['allowed' => true, 'reason' => null];
    }

    /**
     * Specifically check if a Free Trial user has already used their one consultation.
     */
    public static function isFreeTrialExhausted(User $user): bool
    {
        if (self::getTier($user) !== self::TIER_FREE) {
            return false;
        }

        return \App\Models\Consultation::where('customer_id', $user->id)
            ->whereNotIn('status', ['Cancelled', 'Rejected', 'Expired'])
            ->exists();
    }
}
