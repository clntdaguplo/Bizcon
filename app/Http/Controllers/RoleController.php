<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    // Show the role selection form
    public function show()
    {
        return view('select-role');
    }

    // Save the selected role and redirect accordingly
    public function save(Request $request)
    {
        $request->validate([
            'role' => 'required|in:Customer,Consultant',
        ]);

        $user = Auth::user();
        $user->role = $request->role;
        $user->save();

        // Redirect to consultant onboarding flow (rules -> profile)
        if ($user->role === 'Consultant') {
            return redirect()->route('consultant.rules')->with('success', 'Please review the rules and complete your profile.');
        }

        return redirect()->route('dashboard.customer')->with('success', 'Welcome, Customer!');
    }
}