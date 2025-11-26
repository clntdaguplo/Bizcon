@extends('admin-folder.layout')

@section('title', 'Consultant Profile')
@section('page-title', 'Consultant Profile')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('admin.manage-users') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Manage Users
        </a>
    </div>
    <div class="bg-white rounded-lg shadow p-6 flex items-center space-x-6">
        <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
            @if($profile->avatar_path)
                <img src="{{ asset('storage/'.$profile->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
            @else
                <span class="text-2xl font-semibold text-gray-500">{{ substr($profile->full_name ?? $profile->user->name, 0, 1) }}</span>
            @endif
        </div>
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-gray-900">{{ $profile->full_name ?? $profile->user->name }}</h2>
            <p class="text-gray-600">{{ $profile->email ?? $profile->user->email }}</p>
            <div class="mt-2">
                @if($profile->is_verified)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Verified</span>
                @elseif($profile->is_rejected)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                @endif
            </div>
        </div>
        <div class="text-right text-sm text-gray-500">
            <div>Joined</div>
            <div>{{ ($profile->created_at ?? $profile->user->created_at)->format('M d, Y') }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h3 class="text-lg font-semibold text-gray-900">Personal Info</h3>
            <div><span class="text-gray-500">Full Name:</span> <span class="font-medium">{{ $profile->full_name ?? '—' }}</span></div>
            <div><span class="text-gray-500">Email:</span> <span class="font-medium">{{ $profile->email ?? $profile->user->email }}</span></div>
            <div><span class="text-gray-500">Phone:</span> <span class="font-medium">{{ $profile->phone_number ?? '—' }}</span></div>
            <div><span class="text-gray-500">Age:</span> <span class="font-medium">{{ $profile->age ?? '—' }}</span></div>
            <div><span class="text-gray-500">Gender:</span> <span class="font-medium">{{ $profile->sex ?? '—' }}</span></div>
            <div><span class="text-gray-500">Address:</span> <span class="font-medium">{{ $profile->address ?? '—' }}</span></div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h3 class="text-lg font-semibold text-gray-900">Professional</h3>
            <div><span class="text-gray-500">Expertise:</span> <span class="font-medium">{{ $profile->expertise ?? '—' }}</span></div>
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-gray-500">Resume:</span>
                    <span class="font-medium">{{ $profile->resume_path ? basename($profile->resume_path) : '—' }}</span>
                </div>
                @if($profile->resume_path)
                    <a href="{{ asset('storage/'.$profile->resume_path) }}" target="_blank" class="text-blue-600 text-sm hover:underline">View</a>
                @endif
            </div>
            @if($profile->admin_note)
                <div>
                    <span class="text-gray-500">Admin Note:</span>
                    <p class="mt-1 text-gray-700">{{ $profile->admin_note }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection


