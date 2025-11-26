@extends('consultant-folder.layout')

@section('title', 'Pending Approval')
@section('page-title', 'Account Pending Approval')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">Your profile is under review</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Wait for approval</span>
            </div>
            <p class="mt-2">Thank you for submitting your information. An admin will review your profile shortly. You will be notified once approved.</p>
        </div>

        <div class="bg-white rounded-xl shadow p-6 space-y-4">
            <h3 class="text-lg font-semibold text-gray-900">What you can do</h3>
            <ul class="list-disc pl-5 text-gray-700 space-y-2">
                <li>View and update your profile information</li>
                <li>Browse public pages of the website</li>
                <li>Return later to check your approval status</li>
            </ul>
        </div>
    </div>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Pending - BizConsult</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-gray-900 bg-opacity-80 fixed top-0 left-0 w-full z-20">
        <div class="container mx-auto flex justify-between items-center p-4">
            <a href="{{ route('dashboard.consultant') }}" class="flex items-center pl-6">
                <img src="{{ asset('images/Bizcon.png') }}" alt="Biz Consult Logo" class="h-14 w-auto">
            </a>
            <nav class="flex items-center space-x-6 pr-6 text-gray-300">
                <a href="{{ route('logout') }}" class="hover:text-white">Logout</a>
            </nav>
        </div>
    </header>

    <main class="min-h-screen pt-32 px-6">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md text-center">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold mb-4 text-gray-800">Profile Under Review</h1>
                <p class="text-gray-700 mb-6">Thank you for submitting your consultant profile! Our admin team is currently reviewing your information and credentials. You will be notified via email once your profile is approved.</p>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-blue-800 mb-2">What happens next?</h3>
                <ul class="text-left text-blue-700 space-y-1">
                    <li>• Our team will verify your credentials and resume</li>
                    <li>• We'll check your expertise and professional background</li>
                    <li>• You'll receive an email notification once approved</li>
                    <li>• Once approved, you can start accepting client consultations</li>
                </ul>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('dashboard.consultant') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Check Status
                </a>
                <a href="{{ route('logout') }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700 transition">
                    Logout
                </a>
            </div>
        </div>
    </main>

    <footer class="bg-gray-900 bg-opacity-80 text-gray-300 py-6 text-center mt-12">
        <p>&copy; {{ date('Y') }} BizConsult. All rights reserved.</p>
    </footer>
</body>
</html>

