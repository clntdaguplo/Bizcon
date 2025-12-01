<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function connect()
    {
        // Build Google Client
        if (!class_exists('\Google_Client')) {
            return redirect()->back()->with('error', 'Google client library is not installed. Run "composer require google/apiclient"');
        }

        $client = new \Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(route('google.callback'));
        $client->addScope([\Google_Service_Calendar::CALENDAR]);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        $authUrl = $client->createAuthUrl();
        return redirect()->away($authUrl);
    }

    public function callback(Request $request)
    {
        if (!class_exists('\Google_Client')) {
            return redirect()->route('consultant.profile')->with('error', 'Google client library is missing.');
        }

        $client = new \Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(route('google.callback'));

        if ($request->has('code')) {
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

            return redirect()->route('consultant.profile')->with('success', 'Google connected successfully.');
        }

        return redirect()->route('consultant.profile')->with('error', 'No authorization code provided.');
    }
}
