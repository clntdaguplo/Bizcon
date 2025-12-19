@extends('consultant-folder.layout')

@section('title', 'Consultant Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-600">Here's your consulting performance overview for today.</p>
            </div>
            <!-- Live Clock Widget -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg p-4 min-w-[200px]">
                <div class="text-center text-white">
                    <div class="text-xs font-medium uppercase tracking-wider opacity-80 mb-1">Current Time</div>
                    <div id="clock-time" class="text-3xl font-bold font-mono">--:--:--</div>
                    <div id="clock-date" class="text-sm opacity-80 mt-1">Loading...</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main 3-Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Column 1: Performance & Stats -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Your Performance
                </h3>
                <p class="text-blue-100 text-sm mt-1">Consultation statistics</p>
            </div>
            <div class="p-4 space-y-4">
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-4 border border-yellow-200">
                        <div class="flex items-center justify-between">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="text-2xl font-bold text-gray-900">{{ $stats['pending_consultations'] ?? 0 }}</div>
                            <div class="text-xs text-yellow-700 font-medium">Pending</div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200">
                        <div class="flex items-center justify-between">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="text-2xl font-bold text-gray-900">{{ $stats['accepted_consultations'] ?? 0 }}</div>
                            <div class="text-xs text-green-700 font-medium">Accepted</div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4 border border-purple-200">
                        <div class="flex items-center justify-between">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="text-2xl font-bold text-gray-900">{{ $stats['completed_consultations'] ?? 0 }}</div>
                            <div class="text-xs text-purple-700 font-medium">Completed</div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-200">
                        <div class="flex items-center justify-between">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="text-2xl font-bold text-gray-900">{{ $stats['total_consultations'] ?? 0 }}</div>
                            <div class="text-xs text-blue-700 font-medium">Total</div>
                        </div>
                    </div>
                </div>

                <!-- Monthly Growth -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-600">This Month</div>
                            <div class="text-xl font-bold text-gray-900">{{ $thisMonthCount ?? 0 }} consultations</div>
                        </div>
                        <div class="text-right">
                            @if(($monthlyGrowth ?? 0) > 0)
                                <div class="flex items-center text-green-600">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    <span class="text-lg font-bold">+{{ $monthlyGrowth }}%</span>
                                </div>
                            @elseif(($monthlyGrowth ?? 0) < 0)
                                <div class="flex items-center text-red-600">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path>
                                    </svg>
                                    <span class="text-lg font-bold">{{ $monthlyGrowth }}%</span>
                                </div>
                            @else
                                <span class="text-lg font-bold text-gray-500">0%</span>
                            @endif
                            <div class="text-xs text-gray-500">vs last month</div>
                        </div>
                    </div>
                </div>

                <!-- Rating Summary -->
                @if($averageRating)
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 border border-amber-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm text-amber-700 font-medium">Your Rating</div>
                                <div class="flex items-center">
                                    <span class="text-2xl font-bold text-gray-900">{{ $averageRating }}</span>
                                    <span class="text-gray-500 ml-1">/5</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-600">{{ $totalRatings }} reviews</div>
                            <div class="flex text-yellow-400 mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($averageRating))
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 text-center">
                    <p class="text-gray-500 text-sm">No ratings yet</p>
                </div>
                @endif

            </div>
        </div>

        <!-- Column 2: Today's Schedule & Upcoming -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Today's Schedule
                </h3>
                <p class="text-green-100 text-sm mt-1">{{ now()->format('l, F j, Y') }}</p>
            </div>
            <div class="p-4 space-y-4 max-h-[520px] overflow-y-auto">
                
                <!-- Today's Consultations -->
                @if($todayConsultations && $todayConsultations->count() > 0)
                    @foreach($todayConsultations as $consultation)
                        @php
                            $time = $consultation->scheduled_time;
                            $timeFormatted = is_string($time) ? \Carbon\Carbon::parse($time)->format('g:i A') : $time->format('g:i A');
                        @endphp
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-lg font-bold text-green-700">{{ $timeFormatted }}</span>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($consultation->status === 'Accepted') bg-green-100 text-green-800
                                    @elseif($consultation->status === 'Proposed') bg-indigo-100 text-indigo-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $consultation->status }}
                                </span>
                            </div>
                            <div class="font-medium text-gray-900">{{ $consultation->customer->name ?? 'Customer' }}</div>
                            <div class="text-sm text-gray-600 truncate">{{ $consultation->topic }}</div>
                            @if($consultation->meeting_link)
                                <a href="{{ $consultation->meeting_link }}" target="_blank" 
                                   class="inline-flex items-center mt-2 text-sm text-green-600 hover:text-green-700">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Join Meeting
                                </a>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-sm">No consultations scheduled for today</p>
                    </div>
                @endif

                <!-- Upcoming Consultations -->
                @if($upcomingConsultations && $upcomingConsultations->count() > 0)
                    <div class="pt-4 border-t border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Upcoming
                        </h4>
                        <div class="space-y-2">
                            @foreach($upcomingConsultations as $upcoming)
                                @php
                                    $date = $upcoming->scheduled_date instanceof \Carbon\Carbon 
                                        ? $upcoming->scheduled_date 
                                        : \Carbon\Carbon::parse($upcoming->scheduled_date);
                                @endphp
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">
                                    <div class="flex-1 min-w-0">
                                        <div class="font-medium text-gray-900 truncate">{{ $upcoming->customer->name ?? 'Customer' }}</div>
                                        <div class="text-xs text-gray-500">{{ $date->format('M j, Y') }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-medium text-blue-600">{{ $date->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <!-- Column 3: Top Consultants Based on Area of Expertise -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                    Top Consultants by Expertise
                </h3>
                <p class="text-blue-100 text-sm mt-1">Leading professionals in each field</p>
            </div>
            <div class="p-4 max-h-[480px] overflow-y-auto">
                @if($topConsultantsByExpertise && count($topConsultantsByExpertise) > 0)
                    <div class="space-y-3">
                        @foreach($topConsultantsByExpertise as $expertise => $data)
                            <a href="{{ route('consultant.expertise', ['expertise' => urlencode($expertise)]) }}" 
                               class="block bg-gradient-to-r from-gray-50 to-white rounded-lg p-4 border border-gray-100 hover:shadow-md transition-all duration-200 hover:border-blue-200 cursor-pointer group">
                                @if($data && isset($data['consultant']))
                                    <div class="flex items-center">
                                        <div class="relative">
                                            @if($data['consultant']->avatar_path)
                                                <img src="{{ asset('storage/' . $data['consultant']->avatar_path) }}" 
                                                     alt="{{ $data['consultant']->full_name }}" 
                                                     class="w-12 h-12 rounded-full object-cover border-2 border-blue-200">
                                            @else
                                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center border-2 border-blue-200">
                                                    <span class="text-white font-bold text-sm">{{ substr($data['consultant']->full_name ?? 'C', 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center">
                                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate group-hover:text-blue-600 transition-colors">{{ $data['consultant']->full_name ?? 'Unknown' }}</p>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                                {{ $expertise }}
                                            </span>
                                        </div>
                                        <div class="text-right flex items-center">
                                            <div class="mr-2">
                                                <div class="text-lg font-bold text-blue-600">{{ $data['completed_count'] }}</div>
                                                <div class="text-xs text-gray-500">completed</div>
                                            </div>
                                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center border-2 border-gray-300">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3 flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-400">No consultant yet</p>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 mt-1">
                                                {{ $expertise }}
                                            </span>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-300 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                @endif
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-sm">No consultants yet</p>
                        <p class="text-gray-400 text-xs mt-1">Consultants will appear here once verified</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Analytics Section - Premium Design -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Monthly Performance Chart - Enhanced -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-bold text-white">Monthly Performance</h3>
                            <p class="text-blue-100 text-xs">Last 6 months trend</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-white">{{ $stats['total_consultations'] ?? 0 }}</div>
                        <div class="text-blue-100 text-xs">Total</div>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="relative h-56">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Status Breakdown Chart - Enhanced -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="bg-gradient-to-r from-purple-600 via-purple-500 to-pink-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-bold text-white">Status Breakdown</h3>
                            <p class="text-purple-100 text-xs">Consultation distribution</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Status Legend -->
            <div class="p-4 bg-gray-50 border-b border-gray-100">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @php
                        $statusColors = [
                            'Pending' => ['bg' => 'bg-yellow-500', 'light' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
                            'Accepted' => ['bg' => 'bg-blue-500', 'light' => 'bg-blue-100', 'text' => 'text-blue-700'],
                            'Completed' => ['bg' => 'bg-green-500', 'light' => 'bg-green-100', 'text' => 'text-green-700'],
                            'Rejected' => ['bg' => 'bg-red-500', 'light' => 'bg-red-100', 'text' => 'text-red-700'],
                            'Cancelled' => ['bg' => 'bg-gray-500', 'light' => 'bg-gray-100', 'text' => 'text-gray-700'],
                            'Proposed' => ['bg' => 'bg-indigo-500', 'light' => 'bg-indigo-100', 'text' => 'text-indigo-700'],
                        ];
                        $total = $statusBreakdown ? $statusBreakdown->sum() : 0;
                    @endphp
                    @if($statusBreakdown)
                        @foreach($statusBreakdown as $status => $count)
                            @php
                                $colors = $statusColors[$status] ?? ['bg' => 'bg-gray-500', 'light' => 'bg-gray-100', 'text' => 'text-gray-700'];
                                $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
                            @endphp
                            <div class="flex items-center p-2 {{ $colors['light'] }} rounded-lg">
                                <div class="w-3 h-3 {{ $colors['bg'] }} rounded-full mr-2"></div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-medium {{ $colors['text'] }}">{{ $status }}</div>
                                    <div class="text-sm font-bold text-gray-900">{{ $count }}</div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            
            <div class="p-6">
                <div class="relative h-48 flex items-center justify-center">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Consultations & Top Topics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent Consultations -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-bold text-white">Recent Consultations</h3>
                            <p class="text-gray-300 text-xs">Latest activity</p>
                        </div>
                    </div>
                    <a href="{{ route('consultant.consultations') }}" class="text-sm text-white hover:text-gray-200 flex items-center">
                        View All
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-4 space-y-3 max-h-80 overflow-y-auto">
                @forelse($recent_consultations ?? [] as $consultation)
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-900">{{ $consultation->customer->name ?? 'Customer' }}</div>
                                <div class="text-sm text-gray-600 truncate">{{ $consultation->topic }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $consultation->created_at->diffForHumans() }}</div>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full ml-2 whitespace-nowrap
                                @if($consultation->status === 'Pending') bg-yellow-100 text-yellow-800
                                @elseif($consultation->status === 'Accepted') bg-green-100 text-green-800
                                @elseif($consultation->status === 'Completed') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $consultation->status }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-sm">No consultations yet</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Top Topics -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-600 to-cyan-600 px-6 py-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-bold text-white">Your Top Topics</h3>
                        <p class="text-teal-100 text-xs">Most requested consultation topics</p>
                    </div>
                </div>
            </div>
            <div class="p-4">
                @if($topTopics && $topTopics->count() > 0)
                    @php
                        $maxCount = $topTopics->max();
                        $colors = [
                            ['from' => 'from-amber-400', 'to' => 'to-orange-500', 'bg' => 'bg-amber-50', 'border' => 'border-amber-200'],
                            ['from' => 'from-gray-300', 'to' => 'to-gray-400', 'bg' => 'bg-gray-50', 'border' => 'border-gray-200'],
                            ['from' => 'from-orange-300', 'to' => 'to-amber-400', 'bg' => 'bg-orange-50', 'border' => 'border-orange-200'],
                            ['from' => 'from-blue-400', 'to' => 'to-indigo-500', 'bg' => 'bg-blue-50', 'border' => 'border-blue-200'],
                            ['from' => 'from-purple-400', 'to' => 'to-pink-500', 'bg' => 'bg-purple-50', 'border' => 'border-purple-200'],
                        ];
                        $icons = ['🥇', '🥈', '🥉', '4', '5'];
                        $idx = 0;
                    @endphp
                    <div class="space-y-3">
                        @foreach($topTopics as $topic => $count)
                            @php
                                $color = $colors[$idx] ?? $colors[4];
                                $percentage = $maxCount > 0 ? round(($count / $maxCount) * 100) : 0;
                            @endphp
                            <div class="p-4 {{ $color['bg'] }} rounded-xl border {{ $color['border'] }} hover:shadow-md transition-shadow">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        @if($idx < 3)
                                            <span class="text-xl mr-2">{{ $icons[$idx] }}</span>
                                        @else
                                            <span class="w-6 h-6 rounded-full bg-gradient-to-br {{ $color['from'] }} {{ $color['to'] }} text-white text-xs font-bold flex items-center justify-center mr-2">{{ $idx + 1 }}</span>
                                        @endif
                                        <span class="font-semibold text-gray-900 truncate">{{ $topic }}</span>
                                    </div>
                                    <span class="text-lg font-bold bg-gradient-to-r {{ $color['from'] }} {{ $color['to'] }} bg-clip-text text-transparent">{{ $count }}</span>
                                </div>
                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r {{ $color['from'] }} {{ $color['to'] }} rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                            @php $idx++; @endphp
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-sm">No topics yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Live Clock
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        
        document.getElementById('clock-time').textContent = `${hours}:${minutes}:${seconds}`;
        document.getElementById('clock-date').textContent = `${days[now.getDay()]}, ${months[now.getMonth()]} ${now.getDate()}`;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Monthly Performance Chart
    const monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx) {
        const monthlyData = @json($monthlyData ?? []);
        
        const gradient = monthlyCtx.getContext('2d').createLinearGradient(0, 0, 0, 250);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
        gradient.addColorStop(1, 'rgba(139, 92, 246, 0.05)');
        
        new Chart(monthlyCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: monthlyData.map(d => d.short),
                datasets: [{
                    label: 'Total',
                    data: monthlyData.map(d => d.count),
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(79, 70, 229)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 8
                }, {
                    label: 'Completed',
                    data: monthlyData.map(d => d.completed),
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    tension: 0.4,
                    borderDash: [5, 5],
                    pointBackgroundColor: 'rgb(16, 185, 129)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' },
                        ticks: { stepSize: 1 }
                    },
                    x: { grid: { display: false } }
                },
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.95)',
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                animation: { duration: 1000, easing: 'easeOutQuart' }
            }
        });
    }

    // Status Breakdown Chart
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        const statusData = @json($statusBreakdown ?? []);
        const statusColors = {
            'Pending': '#EAB308',
            'Accepted': '#3B82F6',
            'Completed': '#10B981',
            'Rejected': '#EF4444',
            'Cancelled': '#6B7280',
            'Proposed': '#6366F1'
        };
        
        const labels = Object.keys(statusData);
        const values = Object.values(statusData);
        const colors = labels.map(label => statusColors[label] || '#9CA3AF');
        
        new Chart(statusCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderColor: '#ffffff',
                    borderWidth: 3,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.95)',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? Math.round((context.raw / total) * 100) : 0;
                                return `${context.label}: ${context.raw} (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: { animateRotate: true, animateScale: true, duration: 1000 }
            }
        });
    }
</script>
@endsection