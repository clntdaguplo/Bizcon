@extends('admin-folder.layout')

@section('title', 'Consultation Details')
@section('page-title', 'Consultation Details')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.consultations') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg border border-gray-300 hover:bg-gray-50 hover:text-gray-900 transition shadow-sm hover:shadow">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Consultations
        </a>
    </div>

    <!-- Header Card -->
    <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-lg border border-gray-200 p-8">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between space-y-4 md:space-y-0">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <div class="bg-blue-100 p-3 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Session ID</p>
                        <p class="text-2xl font-bold text-gray-900">#{{ str_pad($consultation->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
                <div class="ml-14">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-purple-100 text-purple-800 border border-purple-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        {{ $consultation->topic }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if($consultation->status === 'Completed')
                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Completed
                    </span>
                @elseif($consultation->status === 'Accepted')
                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        In Progress
                    </span>
                @elseif($consultation->status === 'Cancelled')
                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-red-100 text-red-800 border border-red-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelled
                    </span>
                @else
                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $consultation->status }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <div class="flex items-center mb-6 pb-4 border-b border-gray-200">
                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Consultant</h2>
            </div>
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-full overflow-hidden bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center shadow-md">
                    @if($consultation->consultantProfile->avatar_path ?? null)
                        <img src="{{ asset('storage/'.$consultation->consultantProfile->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <span class="text-2xl font-bold text-blue-700">{{ substr(optional(optional($consultation->consultantProfile)->user)->name ?? 'N/A', 0, 1) }}</span>
                    @endif
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">{{ optional(optional($consultation->consultantProfile)->user)->name ?? 'N/A' }}</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ optional($consultation->consultantProfile)->email ?? optional(optional($consultation->consultantProfile)->user)->email ?? 'N/A' }}
                    </p>
                    @if($consultation->consultantProfile->expertise ?? null)
                        <div class="mt-2 flex flex-wrap gap-1.5">
                            @php
                                $expertiseArray = array_map('trim', explode(',', $consultation->consultantProfile->expertise));
                            @endphp
                            @foreach(array_slice($expertiseArray, 0, 3) as $exp)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                    {{ $exp }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                    <a href="{{ route('admin.consultants.show', $consultation->consultantProfile->id ?? '#') }}" class="inline-flex items-center mt-3 text-sm text-blue-600 hover:text-blue-800 font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        View Consultant Profile
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <div class="flex items-center mb-6 pb-4 border-b border-gray-200">
                <div class="bg-green-100 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Customer</h2>
            </div>
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-full overflow-hidden bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center shadow-md">
                    @if($consultation->customer->avatar_path ?? null)
                        <img src="{{ asset('storage/'.$consultation->customer->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <span class="text-2xl font-bold text-green-700">{{ substr($consultation->customer->name ?? 'N/A', 0, 1) }}</span>
                    @endif
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">{{ optional($consultation->customer)->name ?? 'N/A' }}</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ optional($consultation->customer)->email ?? 'N/A' }}
                    </p>
                    <a href="{{ route('admin.customers.show', $consultation->customer->id ?? '#') }}" class="inline-flex items-center mt-3 text-sm text-blue-600 hover:text-blue-800 font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        View Customer Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
        <div class="flex items-center mb-6 pb-4 border-b border-gray-200">
            <div class="bg-purple-100 p-2 rounded-lg mr-3">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900">Session Information</h2>
        </div>
        
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Topic</div>
                        <div class="text-base font-semibold text-gray-900">{{ $consultation->topic }}</div>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Requested At</div>
                        <div class="text-base font-semibold text-gray-900">{{ $consultation->created_at?->format('M d, Y \a\t g:i A') }}</div>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Preferred Date & Time</div>
                        <div class="text-base font-semibold text-gray-900">
                            @if($consultation->preferred_date && $consultation->preferred_time)
                                {{ \Carbon\Carbon::parse($consultation->preferred_date)->format('M d, Y') }}
                                at {{ \Carbon\Carbon::parse($consultation->preferred_time)->format('g:i A') }}
                            @else
                                <span class="text-gray-400 italic">Not specified</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 font-medium uppercase mb-1">Scheduled Date & Time</div>
                        <div class="text-base font-semibold text-gray-900">
                            @if($consultation->scheduled_date && $consultation->scheduled_time)
                                {{ \Carbon\Carbon::parse($consultation->scheduled_date)->format('M d, Y') }}
                                at {{ \Carbon\Carbon::parse($consultation->scheduled_time)->format('g:i A') }}
                            @else
                                <span class="text-gray-400 italic">Not scheduled</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($consultation->details)
                <div class="pt-4 border-t border-gray-200">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <div class="flex-1">
                            <div class="text-xs text-gray-500 font-medium uppercase mb-1">Request Details</div>
                            <div class="text-sm text-gray-700 bg-gray-50 rounded-lg p-4 border border-gray-200 whitespace-pre-line">
                                {{ $consultation->details }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Chat Messages Section -->
    @php
        $messages = collect([]);
        if (\Illuminate\Support\Facades\Schema::hasTable('consultation_messages')) {
            $messages = $consultation->messages()->with('sender')->orderBy('created_at')->get();
        }
    @endphp
    
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="bg-white bg-opacity-20 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Conversation</h3>
                        <p class="text-blue-100 text-sm">Messages between customer and consultant</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6 bg-gray-50" style="min-height: 400px; max-height: 600px; overflow-y: auto;">
            <div class="space-y-4">
                @if($messages->count() > 0)
                    @foreach($messages as $msg)
                        @if($msg->sender_type === 'customer')
                            <!-- Customer Message (Left Side) -->
                            <div class="flex items-start justify-start">
                                <div class="flex items-start space-x-3 max-w-[75%]">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center flex-shrink-0 shadow-md">
                                        <span class="text-white font-semibold text-sm">{{ substr($msg->sender->name ?? 'Customer', 0, 1) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm border border-gray-200">
                                            <div class="flex items-center mb-1">
                                                <span class="text-sm font-semibold text-gray-900">{{ $msg->sender->name ?? 'Customer' }}</span>
                                                <span class="mx-2 text-gray-400">•</span>
                                                <span class="text-xs text-gray-500">{{ $msg->created_at->format('M j, g:i A') }}</span>
                                            </div>
                                            <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $msg->message }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Consultant Message (Right Side) -->
                            <div class="flex items-start justify-end">
                                <div class="flex items-start space-x-3 max-w-[75%] flex-row-reverse">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center flex-shrink-0 shadow-md">
                                        <span class="text-white font-semibold text-sm">{{ substr($msg->sender->name ?? 'Consultant', 0, 1) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-blue-600 text-white rounded-2xl rounded-tr-none px-4 py-3 shadow-md">
                                            <div class="flex items-center mb-1">
                                                <span class="text-sm font-semibold text-blue-100">{{ $msg->sender->name ?? 'Consultant' }}</span>
                                                <span class="mx-2 text-blue-300">•</span>
                                                <span class="text-xs text-blue-200">{{ $msg->created_at->format('M j, g:i A') }}</span>
                                            </div>
                                            <p class="text-white leading-relaxed whitespace-pre-wrap">{{ $msg->message }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <p class="text-gray-600 font-medium">No messages yet</p>
                        <p class="text-gray-500 text-sm mt-1">Conversation history will appear here</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($consultation->consultation_summary || $consultation->recommendations)
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
        <div class="flex items-center mb-6 pb-4 border-b border-gray-200">
            <div class="bg-green-100 p-2 rounded-lg mr-3">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900">Consultation Summary & Recommendations</h2>
        </div>
        
        <div class="space-y-6">
            @if($consultation->consultation_summary)
            <div class="flex items-start">
                <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <div class="flex-1">
                    <div class="text-xs text-gray-500 font-medium uppercase mb-1">Summary</div>
                    <div class="text-sm text-gray-700 bg-green-50 rounded-lg p-4 border border-green-200 whitespace-pre-line">
                        {{ $consultation->consultation_summary }}
                    </div>
                </div>
            </div>
            @endif
            
            @if($consultation->recommendations)
            <div class="flex items-start">
                <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <div class="flex-1">
                    <div class="text-xs text-gray-500 font-medium uppercase mb-1">Recommendations</div>
                    <div class="text-sm text-gray-700 bg-blue-50 rounded-lg p-4 border border-blue-200 whitespace-pre-line">
                        {{ $consultation->recommendations }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection


