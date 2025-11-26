<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show the login form
    public function show()
    {
        return view('login');
    }

    // Handle login attempt
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // If user has no role, redirect to role selection
            if (is_null(Auth::user()->role)) {
                return redirect()->route('role.select');
            }

            // Redirect to role-specific dashboard
            $role = Auth::user()->role;
            if ($role === 'Admin') {
                return redirect()->route('dashboard.admin')->with('success', 'Welcome back, ' . Auth::user()->name . '!');
            }
            if ($role === 'Consultant') {
                return redirect()->route('dashboard.consultant')->with('success', 'Welcome back, ' . Auth::user()->name . '!');
            }

            return redirect()->route('dashboard.customer')->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        // Optional: log failed attempt
        // \Log::warning('Failed login attempt for email: ' . $request->email);

        LoginAttempt::create([
            'email' => $request->input('email'),
            'was_successful' => false,
            'reason' => 'invalid_credentials',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'occurred_at' => now(),
        ]);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
            'password' => 'Please check your password and try again.',
        ])->onlyInput('email');
    }
}