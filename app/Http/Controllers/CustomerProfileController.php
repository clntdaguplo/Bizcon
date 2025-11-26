<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('customer-folder.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ]);

        $updateData = [
            'name' => $validated['name'],
        ];

        if ($request->hasFile('avatar')) {
            $newPath = $request->file('avatar')->store('avatars', 'public');

            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $updateData['avatar_path'] = $newPath;
        }

        $user->update($updateData);

        return back()->with('success', 'Profile updated successfully.');
    }
}

