<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTrialAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Only apply to logged-in customers
        if ($user && $user->role === 'Customer') {
            // Check if user is on a free trial and has used their consultation
            if ($user->isTrialExhausted()) {
                // Allowed routes: plans, logout, notifications (to see the approval/rejection)
                $allowedRoutes = [
                    'customer.plans',
                    'customer.plans.choose',
                    'logout',
                    'notifications.go',
                    'customer.consultations.show', // Allow viewing details of their one consultation
                ];

                $currentRoute = $request->route()->getName();

                if (!in_array($currentRoute, $allowedRoutes)) {
                    return redirect()->route('customer.plans')
                        ->with('error', 'Your free trial consultation has been used. Please upgrade to a paid plan to continue accessing all features.');
                }
            }
        }

        return $next($request);
    }
}
