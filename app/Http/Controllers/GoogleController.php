<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Google_Client;
use Google_Service_Calendar;

class GoogleController extends Controller
{
    public function connect()
    {
        // Ensure library installed
        if (!class_exists(Google_Client::class)) {
            return redirect()->back()->with('error', 'Google client library is not installed. Run \"composer require google/apiclient:^2.0\"');
        }

        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->addScope(Google_Service_Calendar::CALENDAR);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        return redirect()->away($client->createAuthUrl());
    }

    public function callback(Request $request)
    {
        if (!class_exists(Google_Client::class)) {
            return redirect()->route('consultant.profile')->with('error', 'Google client library is missing.');
        }

        if (!$request->has('code')) {
            return redirect()->route('consultant.profile')->with('error', 'Google authentication failed: no authorization code.');
        }

        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));

        $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));

        if (isset($token['error'])) {
            return redirect()->route('consultant.profile')->with('error', 'Failed to obtain Google token.');
        }

        // Save token to consultant profile
        $profile = \App\Models\ConsultantProfile::where('user_id', Auth::id())->first();
        if (! $profile) {
            return redirect()->route('consultant.profile')->with('error', 'Consultant profile not found.');
        }

        $profile->google_token = json_encode($token);
        $profile->save();

        return redirect()->route('consultant.profile')->with('success', 'Google Calendar connected successfully!');
    }
}
