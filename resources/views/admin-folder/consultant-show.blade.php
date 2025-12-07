@extends('admin-folder.layout')

@section('title', 'Consultant Profile')
@section('page-title', 'Consultant Profile')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.consultants') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg border border-gray-300 hover:bg-gray-50 hover:text-gray-900 transition shadow-sm hover:shadow">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to All Consultants
        </a>
    </div>
    <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-lg border border-gray-200 p-8">
        <div class="flex flex-col md:flex-row items-start md:items-center space-y-6 md:space-y-0 md:space-x-8">
            <div class="relative">
                <div class="w-28 h-28 rounded-2xl overflow-hidden bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center shadow-md ring-4 ring-white">
            @if($profile->avatar_path)
                <img src="{{ asset('storage/'.$profile->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
            @else
                        <span class="text-4xl font-bold text-gray-600">{{ substr($profile->full_name ?? $profile->user->name, 0, 1) }}</span>
                    @endif
                </div>
                @if($profile->is_verified && !$profile->is_rejected)
                    <div class="absolute -bottom-2 -right-2 bg-green-500 rounded-full p-1.5 shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
            @endif
        </div>
        <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $profile->full_name ?? $profile->user->name }}</h2>
                </div>
                <div class="flex items-center text-gray-600 mb-4">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-lg">{{ $profile->email ?? $profile->user->email }}</span>
                </div>
                <div class="flex items-center flex-wrap gap-3 mb-4">
                @if($profile->is_rejected && !$profile->is_verified)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-red-100 text-red-800 border border-red-200">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Rejected
                        </span>
                @elseif($profile->is_rejected && $profile->is_verified)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-orange-100 text-orange-800 border border-orange-200">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                            </svg>
                            Suspended
                        </span>
                @elseif($profile->is_verified)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Verified
                        </span>
                @else
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pending
                        </span>
                @endif
                @if($profile->has_pending_update)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-purple-100 text-purple-800 border border-purple-200 animate-pulse">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Update Requested
                    </span>
                @endif
                @if($profile->average_rating)
                        <div class="flex items-center bg-yellow-50 px-3 py-1.5 rounded-lg border border-yellow-200">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($profile->average_rating))
                                <span class="text-yellow-500 text-lg">⭐</span>
                            @else
                                <span class="text-gray-300 text-lg">☆</span>
                            @endif
                        @endfor
                            <span class="ml-2 text-sm font-semibold text-gray-700">{{ $profile->average_rating }}/5</span>
                    </div>
                @else
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm text-gray-500 bg-gray-50 border border-gray-200">No ratings yet</span>
                @endif
            </div>
        </div>
            <div class="text-right space-y-3 bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-end text-gray-600 mb-2">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
            <div>
                        <div class="text-xs text-gray-500 font-medium">Joined</div>
                        <div class="text-sm font-semibold text-gray-900">{{ ($profile->created_at ?? $profile->user->created_at)->format('M d, Y') }}</div>
                    </div>
            </div>
            <div>
                @if(!$profile->is_verified && !$profile->is_rejected)
                    {{-- Pending: show Approve / Reject --}}
                    <form method="POST"
                          action="{{ route('admin.consultants.approve', $profile->id) }}"
                          class="mb-2"
                          onsubmit="return confirm('Approve this consultant? They will be notified of the approval.');">
                        @csrf
                        <button type="submit"
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold bg-green-600 text-white hover:bg-green-700 w-full transition shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            Approve Consultant
                        </button>
                    </form>
                    <button onclick="openRejectModal({{ $profile->id }})"
                                class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold bg-red-600 text-white hover:bg-red-700 w-full transition shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        Reject Consultant
                    </button>
                @elseif($profile->is_rejected && !$profile->is_verified)
                    {{-- Rejected (never verified): Cannot approve directly - must resubmit --}}
                        <div class="text-center p-4 bg-gradient-to-br from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-xl shadow-sm">
                        <svg class="w-12 h-12 text-yellow-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                            <p class="text-sm font-bold text-yellow-900 mb-2">Cannot Approve Rejected Consultant</p>
                        <p class="text-xs text-yellow-800 mb-3">This consultant was rejected and must resubmit their application before they can be approved.</p>
                        @if($profile->admin_note)
                                <div class="text-xs text-yellow-700 italic mb-3 p-2 bg-yellow-100 rounded-lg border border-yellow-300">
                                <span class="font-semibold">Rejection Reason:</span><br>
                                "{{ \Illuminate\Support\Str::limit($profile->admin_note, 150) }}"
                            </div>
                        @endif
                        <p class="text-xs text-yellow-700">Waiting for consultant to resubmit their profile...</p>
                    </div>
                @elseif($profile->is_rejected && $profile->is_verified)
                    {{-- Suspended (was verified): show Unsuspend and suspension info --}}
                        <div class="space-y-3">
                        @if($profile->suspended_until)
                                <div class="text-sm text-gray-700 mb-3 p-3 bg-orange-50 rounded-lg border border-orange-200">
                                    <div class="flex items-center mb-1">
                                        <svg class="w-4 h-4 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-semibold text-orange-900">Suspended until:</span>
                                    </div>
                                    <div class="text-orange-800">{{ $profile->suspended_until->format('M d, Y \a\t g:i A') }}</div>
                                @if($profile->suspended_until->isFuture())
                                        <div class="text-xs text-orange-600 mt-1">({{ $profile->suspended_until->diffForHumans() }})</div>
                                @else
                                        <div class="text-xs text-red-600 font-semibold mt-1">(Expired - will auto-unsuspend)</div>
                                @endif
                            </div>
                        @else
                                <div class="text-sm text-orange-700 mb-3 p-3 bg-orange-50 rounded-lg border border-orange-200 font-semibold">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                Permanently suspended (manual unsuspend required)
                            </div>
                        @endif
                        <form method="POST"
                              action="{{ route('admin.consultants.unsuspend', $profile->id) }}"
                              onsubmit="return confirm('Unsuspend this consultant?');">
                            @csrf
                            <button type="submit"
                                        class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold bg-green-600 text-white hover:bg-green-700 w-full transition shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Unsuspend Consultant
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Verified & not suspended: show Suspend --}}
                    <button onclick="openSuspendModal({{ $profile->id }})"
                                class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold bg-red-600 text-white hover:bg-red-700 w-full transition shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                            </svg>
                            Suspend Consultant
                    </button>
                @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <div class="flex items-center mb-6 pb-4 border-b border-gray-200">
                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Personal Information</h3>
            </div>
            <div class="space-y-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Full Name</div>
                        <div class="text-base font-semibold text-gray-900">{{ $profile->full_name ?? '—' }}</div>
                    </div>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Email</div>
                        <div class="text-base font-semibold text-gray-900">{{ $profile->email ?? $profile->user->email }}</div>
                    </div>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Phone</div>
                        <div class="text-base font-semibold text-gray-900">{{ $profile->phone_number ?? '—' }}</div>
                    </div>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Age</div>
                        <div class="text-base font-semibold text-gray-900">{{ $profile->age ?? '—' }}</div>
                    </div>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Gender</div>
                        <div class="text-base font-semibold text-gray-900">{{ $profile->sex ?? '—' }}</div>
                    </div>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Address</div>
                        <div class="text-base font-semibold text-gray-900">{{ $profile->address ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <div class="flex items-center mb-6 pb-4 border-b border-gray-200">
                <div class="bg-purple-100 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Professional Details</h3>
            </div>
            <div class="space-y-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Expertise</div>
                        <div class="flex flex-wrap gap-2">
                            @if($profile->expertise)
                                @php
                                    $expertiseList = array_map('trim', explode(',', $profile->expertise));
                                @endphp
                                @foreach($expertiseList as $exp)
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        {{ $exp }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-base font-semibold text-gray-400">—</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Client Rating</div>
                <div class="mt-1">
                    @if($profile->average_rating)
                                <div class="flex items-center flex-wrap gap-2">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($profile->average_rating))
                                    <span class="text-yellow-500 text-xl">⭐</span>
                                @else
                                    <span class="text-gray-300 text-xl">☆</span>
                                @endif
                            @endfor
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">{{ $profile->average_rating }}/5</span>
                                    <span class="text-xs text-gray-500">({{ $profile->total_ratings }} {{ $profile->total_ratings == 1 ? 'rating' : 'ratings' }})</span>
                        </div>
                    @else
                                <span class="text-base text-gray-400">No ratings yet</span>
                    @endif
                </div>
            </div>
                </div>
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Resume</div>
                        <div class="flex flex-col">
                            <span class="text-base font-semibold text-gray-900 mb-2">{{ $profile->resume_path ? basename($profile->resume_path) : '—' }}</span>
                @if($profile->resume_path)
                                <a href="{{ asset('storage/'.$profile->resume_path) }}" target="_blank" class="inline-flex items-center justify-center w-fit px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition border border-blue-200">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Resume
                                </a>
                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pending Update Section --}}
    @if($profile->has_pending_update && $profile->previous_values)
        <div class="bg-purple-50 border-l-4 border-purple-500 rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-purple-900">Pending Profile Update Request</h3>
                </div>
                <span class="text-sm text-purple-700">
                    Requested: {{ $profile->update_requested_at->format('M d, Y \a\t g:i A') }}
                </span>
            </div>
            
            <p class="text-sm text-purple-800 mb-4">This consultant has requested to update their profile. Review the changes below:</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                @php
                    $previous = $profile->previous_values;
                    $current = [
                        'full_name' => $profile->full_name,
                        'email' => $profile->email,
                        'phone_number' => $profile->phone_number,
                        'age' => $profile->age,
                        'sex' => $profile->sex,
                        'expertise' => $profile->expertise,
                        'address' => $profile->address,
                    ];
                @endphp
                
                @foreach(['full_name', 'email', 'phone_number', 'age', 'sex', 'address'] as $field)
                    @php
                        $oldValue = $previous[$field] ?? null;
                        $newValue = $current[$field] ?? null;
                        $isAdded = is_null($oldValue) && !is_null($newValue);
                        $isChanged = !is_null($oldValue) && !is_null($newValue) && $oldValue != $newValue;
                    @endphp
                    @if($isAdded || $isChanged)
                        <div class="bg-white rounded-lg p-4 border border-purple-200">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-xs font-semibold text-purple-700 uppercase">{{ str_replace('_', ' ', $field) }}</div>
                                @if($isAdded)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Added
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Changed
                                    </span>
                                @endif
                            </div>
                            <div class="space-y-2">
                                @if($isAdded)
                                    <div class="flex items-start">
                                        <span class="text-xs font-medium text-blue-600 mr-2">New Value:</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $newValue }}</span>
                                    </div>
                                @else
                                    <div class="flex items-start">
                                        <span class="text-xs font-medium text-red-600 mr-2">Previous:</span>
                                        <span class="text-sm text-gray-700 line-through">{{ $oldValue }}</span>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="text-xs font-medium text-green-600 mr-2">Updated To:</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $newValue }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
                
                {{-- Special handling for Expertise to show additions and changes --}}
                @php
                    $oldExpertise = $previous['expertise'] ?? '';
                    $newExpertise = $current['expertise'] ?? '';
                    $oldExpertiseArray = !empty($oldExpertise) ? array_map('trim', explode(',', $oldExpertise)) : [];
                    $newExpertiseArray = !empty($newExpertise) ? array_map('trim', explode(',', $newExpertise)) : [];
                    $addedExpertise = array_diff($newExpertiseArray, $oldExpertiseArray);
                    $removedExpertise = array_diff($oldExpertiseArray, $newExpertiseArray);
                    $hasExpertiseChanges = !empty($addedExpertise) || !empty($removedExpertise);
                @endphp
                @if($hasExpertiseChanges)
                    <div class="bg-white rounded-lg p-4 border border-purple-200">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-xs font-semibold text-purple-700 uppercase">Expertise</div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Modified
                            </span>
                        </div>
                        <div class="space-y-3">
                            @if(!empty($addedExpertise))
                                <div>
                                    <div class="flex items-center mb-1">
                                        <svg class="w-4 h-4 text-green-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <span class="text-xs font-medium text-green-600">Added:</span>
                                    </div>
                                    <div class="flex flex-wrap gap-1 ml-5">
                                        @foreach($addedExpertise as $exp)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 border border-green-300">
                                                + {{ $exp }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if(!empty($removedExpertise))
                                <div>
                                    <div class="flex items-center mb-1">
                                        <svg class="w-4 h-4 text-red-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span class="text-xs font-medium text-red-600">Removed:</span>
                                    </div>
                                    <div class="flex flex-wrap gap-1 ml-5">
                                        @foreach($removedExpertise as $exp)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 border border-red-300 line-through">
                                                - {{ $exp }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="pt-2 border-t border-gray-200">
                                <div class="text-xs font-medium text-gray-600 mb-1">Current Expertise:</div>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($newExpertiseArray as $exp)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $exp }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if(isset($previous['resume_path']) && $previous['resume_path'] != $profile->resume_path)
                    <div class="bg-white rounded-lg p-4 border border-purple-200">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-xs font-semibold text-purple-700 uppercase">Resume</div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Changed
                            </span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-start">
                                <span class="text-xs font-medium text-red-600 mr-2">Previous:</span>
                                <span class="text-sm text-gray-700 line-through">{{ basename($previous['resume_path']) }}</span>
                            </div>
                            <div class="flex items-start">
                                <span class="text-xs font-medium text-green-600 mr-2">Updated To:</span>
                                <span class="text-sm font-semibold text-gray-900">{{ basename($profile->resume_path) }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="flex gap-3 pt-4 border-t border-purple-200">
                <form method="POST" action="{{ route('admin.consultants.approve-update', $profile->id) }}" 
                      onsubmit="return confirm('Approve this profile update? The changes will be applied.');" class="flex-1">
                    @csrf
                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Approve Update
                    </button>
                </form>
                <button onclick="openRejectUpdateModal({{ $profile->id }})" 
                        class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Reject Update
                </button>
            </div>
        </div>
    @endif

    {{-- Rejection History Section --}}
    @if($profile->rejected_at || $profile->admin_note || $profile->resubmission_count > 0)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Rejection History</h3>
            
            @if($profile->rejected_at)
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class="font-semibold text-red-900">Originally Rejected</span>
                                <span class="ml-3 text-sm text-red-700">{{ $profile->rejected_at->format('M d, Y \a\t g:i A') }}</span>
                            </div>
                            @if($profile->admin_note)
                                <p class="text-red-800 text-sm mt-2">{{ $profile->admin_note }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if($profile->resubmission_count > 0)
                <div class="mb-4 p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <div>
                            <span class="font-semibold text-yellow-900">Resubmitted {{ $profile->resubmission_count }} {{ $profile->resubmission_count == 1 ? 'time' : 'times' }}</span>
                            @if($profile->resubmitted_at)
                                <span class="ml-3 text-sm text-yellow-700">Last resubmission: {{ $profile->resubmitted_at->format('M d, Y \a\t g:i A') }}</span>
                            @endif
                        </div>
                    </div>
                    <p class="text-yellow-800 text-sm mt-2">This consultant has resubmitted their application after being rejected. Review their updated information above.</p>
                </div>
            @endif
        </div>
    @endif
</div>

<!-- Rejection Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-[9999]" style="display: none;">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white z-[10000]">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Reject Consultant</h3>
                <button type="button" onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="mb-4">
                    <label for="reject_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Rejection Reason <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="reject_reason" 
                        name="admin_note" 
                        rows="4" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                        placeholder="Please provide a clear reason for rejection (minimum 10 characters). The consultant will receive this message."
                        required
                        minlength="10"></textarea>
                    <p class="mt-1 text-xs text-gray-500">This message will be sent to the consultant.</p>
                </div>
                <div class="flex justify-end gap-3">
                    <button 
                        type="button" 
                        onclick="closeRejectModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Reject Consultant
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Update Modal -->
<div id="rejectUpdateModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-[9999]" style="display: none;">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white z-[10000]">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Reject Profile Update</h3>
                <button type="button" onclick="closeRejectUpdateModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="rejectUpdateForm" method="POST" action="">
                @csrf
                <div class="mb-4">
                    <label for="reject_update_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Rejection Reason <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="reject_update_reason" 
                        name="admin_note" 
                        rows="4" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                        placeholder="Please provide a clear reason for rejecting this update (minimum 10 characters). The consultant will receive this message and their profile will be restored to previous values."
                        required
                        minlength="10"></textarea>
                    <p class="mt-1 text-xs text-gray-500">This message will be sent to the consultant. Their profile will be restored to the previous approved values.</p>
                </div>
                <div class="flex justify-end gap-3">
                    <button 
                        type="button" 
                        onclick="closeRejectUpdateModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Reject Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Suspend Modal -->
<div id="suspendModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-[9999]" style="display: none;">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white z-[10000]">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Suspend Consultant</h3>
                <button type="button" onclick="closeSuspendModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="suspendForm" method="POST" action="">
                @csrf
                <div class="mb-4">
                    <label for="suspend_duration" class="block text-sm font-medium text-gray-700 mb-2">
                        Suspension Duration <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="suspend_duration" 
                        name="duration" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        required>
                        <option value="">Select duration...</option>
                        <option value="12hrs">12 Hours</option>
                        <option value="1day">1 Day</option>
                        <option value="3days">3 Days</option>
                        <option value="7days">7 Days</option>
                        <option value="permanent">Suspend Anytime (Unsuspend anytime)</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Select how long to suspend this consultant. "Suspend Anytime" means permanent until manually unsuspended.</p>
                </div>
                <div class="mb-4">
                    <label for="suspend_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason (Optional)
                    </label>
                    <textarea 
                        id="suspend_reason" 
                        name="reason" 
                        rows="3"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        placeholder="Enter reason for suspension..."></textarea>
                    <p class="mt-1 text-xs text-gray-500">This will be recorded in the suspension history.</p>
                </div>
                <div class="flex justify-end gap-3">
                    <button 
                        type="button" 
                        onclick="closeSuspendModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Suspend Consultant
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentConsultantId = null;

    function openRejectModal(consultantId) {
        currentConsultantId = consultantId;
        const form = document.getElementById('rejectForm');
        const modal = document.getElementById('rejectModal');
        const textarea = document.getElementById('reject_reason');
        
        if (!form || !modal) {
            console.error('Modal elements not found');
            return;
        }

        // Set the form action
        const baseUrl = '{{ route("admin.consultants.reject", ":id") }}';
        form.action = baseUrl.replace(':id', consultantId);
        
        // Show modal
        modal.classList.remove('hidden');
        modal.style.display = 'block';
        
        // Focus textarea
        if (textarea) {
            setTimeout(() => textarea.focus(), 100);
        }
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        const textarea = document.getElementById('reject_reason');
        
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
        
        if (form) {
            form.reset();
            form.action = '';
        }
        
        currentConsultantId = null;
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('rejectModal');
        if (modal && event.target === modal) {
            closeRejectModal();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const rejectModal = document.getElementById('rejectModal');
            const suspendModal = document.getElementById('suspendModal');
            if (rejectModal && !rejectModal.classList.contains('hidden')) {
                closeRejectModal();
            }
            if (suspendModal && !suspendModal.classList.contains('hidden')) {
                closeSuspendModal();
            }
        }
    });

    // Suspend Modal Functions
    function openSuspendModal(consultantId) {
        currentConsultantId = consultantId;
        const form = document.getElementById('suspendForm');
        const modal = document.getElementById('suspendModal');
        const select = document.getElementById('suspend_duration');
        
        if (!form || !modal) {
            console.error('Suspend modal elements not found');
            return;
        }

        // Set the form action
        const baseUrl = '{{ route("admin.consultants.suspend", ":id") }}';
        form.action = baseUrl.replace(':id', consultantId);
        
        // Show modal
        modal.classList.remove('hidden');
        modal.style.display = 'block';
        
        // Focus select
        if (select) {
            setTimeout(() => select.focus(), 100);
        }
    }

    function closeSuspendModal() {
        const modal = document.getElementById('suspendModal');
        const form = document.getElementById('suspendForm');
        const select = document.getElementById('suspend_duration');
        
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
        
        if (form) {
            form.reset();
            form.action = '';
        }
        
        currentConsultantId = null;
    }

    // Close suspend modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('suspendModal');
        if (modal && event.target === modal) {
            closeSuspendModal();
        }
    });

    // Reject Update Modal Functions
    function openRejectUpdateModal(consultantId) {
        currentConsultantId = consultantId;
        const form = document.getElementById('rejectUpdateForm');
        const modal = document.getElementById('rejectUpdateModal');
        const textarea = document.getElementById('reject_update_reason');
        
        if (!form || !modal) {
            console.error('Reject update modal elements not found');
            return;
        }

        // Set the form action
        const baseUrl = '{{ route("admin.consultants.reject-update", ":id") }}';
        form.action = baseUrl.replace(':id', consultantId);
        
        // Show modal
        modal.classList.remove('hidden');
        modal.style.display = 'block';
        
        // Focus textarea
        if (textarea) {
            setTimeout(() => textarea.focus(), 100);
        }
    }

    function closeRejectUpdateModal() {
        const modal = document.getElementById('rejectUpdateModal');
        const form = document.getElementById('rejectUpdateForm');
        const textarea = document.getElementById('reject_update_reason');
        
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
        
        if (form) {
            form.reset();
            form.action = '';
        }
        
        currentConsultantId = null;
    }

    // Close reject update modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('rejectUpdateModal');
        if (modal && event.target === modal) {
            closeRejectUpdateModal();
        }
    });

    // Close reject update modal on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const rejectUpdateModal = document.getElementById('rejectUpdateModal');
            if (rejectUpdateModal && !rejectUpdateModal.classList.contains('hidden')) {
                closeRejectUpdateModal();
            }
        }
    });
</script>
@endsection


