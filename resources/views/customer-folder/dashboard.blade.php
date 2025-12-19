@extends('customer-folder.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full transform translate-x-32 -translate-y-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full transform -translate-x-16 translate-y-16"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-blue-100 text-lg">Ready to grow your business today?</p>
            </div>
            <div class="mt-4 md:mt-0 flex gap-3">
                <a href="{{ route('customer.new-consult') }}" class="px-5 py-2.5 bg-white text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition shadow-md">
                    + New Consultation
                </a>
            </div>
        </div>
    </div>

    @if(Auth::user()->isTrialExhausted())
    <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-orange-500 p-6 rounded-xl shadow-sm">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-orange-100 p-3 rounded-full mr-4">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-orange-900">Free Trial Consultation Used</h3>
                <p class="text-orange-800">You've completed your one free trial consultation! Upgrade to a paid plan to keep accessing our experts.</p>
            </div>
            <div class="ml-4">
                <a href="{{ route('customer.plans') }}" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white font-bold rounded-lg hover:bg-orange-700 transition shadow-sm">
                    Upgrade Now
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Active Bookings -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ $activeBookings ?? 0 }}</div>
                <div class="text-sm text-gray-500">Active Bookings</div>
            </div>
        </div>

        <!-- Completed Sessions -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center text-green-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ $completedSessions ?? 0 }}</div>
                <div class="text-sm text-gray-500">Sessions Completed</div>
            </div>
        </div>

        <!-- Available Experts -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ $totalVerifiedConsultants ?? 0 }}</div>
                <div class="text-sm text-gray-500">Available Experts</div>
            </div>
        </div>
        
        <!-- Plan Status (Compact) -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center">
             <div class="w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center text-amber-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
            </div>
            <div>
                <div class="text-lg font-bold text-gray-900">
                    {{ Auth::user()->getSubscriptionTier() }} Plan
                </div>
                <a href="{{ route('customer.plans') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Manage Plan →</a>
            </div>
        </div>
    </div>

    <!-- Top Rated Consultants -->
    @if(auth()->user()->hasSubscriptionFeature('see_top_experts'))
    @if(isset($topRatedConsultants) && $topRatedConsultants->count() > 0)
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-gray-900 flex items-center">
            <svg class="w-6 h-6 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                 <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            Meet Our Top Rated Experts
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($topRatedConsultants as $index => $consultant)
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 relative overflow-hidden group hover:shadow-lg transition-all">
                @if($index === 0)
                    <div class="absolute top-0 right-0 w-16 h-16 bg-yellow-400 opacity-20 rounded-bl-full -mr-8 -mt-8"></div>
                @endif
                
                <div class="flex items-center space-x-4 mb-4">
                     <div class="relative">
                        @if($consultant->avatar_path)
                            <img src="{{ asset('storage/' . $consultant->avatar_path) }}" class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md">
                        @else
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xl font-bold shadow-md">
                                {{ substr($consultant->user->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-white rounded-full flex items-center justify-center shadow-sm">
                            @if($index === 0) <span class="text-lg">🥇</span>
                            @elseif($index === 1) <span class="text-lg">🥈</span>
                            @elseif($index === 2) <span class="text-lg">🥉</span>
                            @else <span class="text-sm font-bold text-gray-400">#{{ $index+1 }}</span>
                            @endif
                        </div>
                     </div>
                     <div>
                         <h3 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $consultant->user->name }}</h3>
                         <p class="text-xs text-gray-500 mb-1 leading-tight">{{ Illuminate\Support\Str::limit($consultant->expertise, 30) }}</p>
                         <div class="flex items-center text-yellow-500 text-xs font-bold">
                             <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                             {{ number_format($consultant->average_rating, 1) }}
                             <span class="text-gray-400 font-normal ml-1">({{ $consultant->total_ratings }})</span>
                         </div>
                     </div>
                </div>
                
                <a href="{{ route('customer.new-consult', ['consultant' => $consultant->id]) }}" class="block w-full text-center py-2 rounded-lg bg-gray-50 text-blue-600 font-medium hover:bg-blue-600 hover:text-white transition-colors text-sm border border-blue-100 group-hover:border-blue-500">
                    Book Consultation
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @else
    <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl p-8 border border-blue-100 shadow-sm">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Unlock Our Top Experts</h2>
                <p class="text-gray-600">Upgrade your plan to see our top-rated specialists and get direct access to the best in the industry.</p>
            </div>
            <a href="{{ route('customer.plans') }}" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-lg">
                View Upgrade Options →
            </a>
        </div>
    </div>
    @endif

    <!-- Main Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Column 1: Browse & Discover (Left) -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Find an Expert (Categories) -->
            @if(auth()->user()->hasSubscriptionFeature('browse_expertise'))
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Find by Expertise
                    </h3>
                </div>
                <div class="p-4 bg-gray-50 max-h-[500px] overflow-y-auto">
                    @if(isset($topConsultantsByExpertise) && $topConsultantsByExpertise->count() > 0)
                        <div class="space-y-3">
                            @foreach($topConsultantsByExpertise as $expertise => $consultant)
                            <a href="{{ route('customer.expertise', urlencode($expertise)) }}" class="block group">
                                <div class="bg-white p-3 rounded-lg border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-200">
                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="text-sm font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $expertise }}</h4>
                                        <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                    @if($consultant)
                                    <div class="flex items-center mt-2 pt-2 border-t border-gray-100">
                                        <div class="relative">
                                            @if($consultant['consultant']->avatar_path)
                                                <img src="{{ asset('storage/' . $consultant['consultant']->avatar_path) }}" 
                                                     alt="{{ $consultant['consultant']->user->name }}" 
                                                     class="w-8 h-8 rounded-full object-cover">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <span class="text-xs font-bold text-blue-600">{{ substr($consultant['consultant']->user->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-yellow-400 rounded-full border border-white flex items-center justify-center">
                                                <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-2.5 overflow-hidden">
                                            <p class="text-xs font-medium text-gray-900 truncate">{{ $consultant['consultant']->user->name }}</p>
                                            <p class="text-[10px] text-gray-500">{{ $consultant['completed_count'] }} consultations</p>
                                        </div>
                                    </div>
                                    @else
                                    <div class="flex items-center mt-2 pt-2 border-t border-gray-100">
                                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <span class="ml-2 text-xs text-gray-500 italic">No experts yet</span>
                                    </div>
                                    @endif
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6 text-gray-500 text-sm">
                            Loading expertise categories...
                        </div>
                    @endif
                </div>
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Browsing Locked</h3>
                <p class="text-sm text-gray-500 mb-4">Expertise categories are available in Weekly, Quarterly, and Annual plans.</p>
                <a href="{{ route('customer.plans') }}" class="text-blue-600 font-bold hover:underline text-sm">Upgrade Now →</a>
            </div>
            @endif

        </div>

        <!-- Column 2: Recent Activity (Center) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('customer.consultants') }}" class="group block p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-100 hover:border-blue-300 hover:shadow-md transition-all">
                   <div class="flex items-center justify-between mb-4">
                       <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                           <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                           </svg>
                       </div>
                       <svg class="w-5 h-5 text-blue-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                       </svg>
                   </div>
                   <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-700">Find a Consultant</h3>
                   <p class="text-sm text-gray-600 mt-1">Browse our verified experts and book a session.</p>
                </a>

                <a href="{{ route('customer.my-consults') }}" class="group block p-6 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl border border-purple-100 hover:border-purple-300 hover:shadow-md transition-all">
                   <div class="flex items-center justify-between mb-4">
                       <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                           <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                           </svg>
                       </div>
                       <svg class="w-5 h-5 text-purple-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                       </svg>
                   </div>
                   <h3 class="text-lg font-bold text-gray-900 group-hover:text-purple-700">My Consultations</h3>
                   <p class="text-sm text-gray-600 mt-1">View upcoming appointments and history.</p>
                </a>
            </div>

            <!-- Recent Sessions -->
            @if(auth()->user()->hasSubscriptionFeature('view_recent_sessions'))
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                    <h3 class="font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Recent Sessions
                    </h3>
                    <a href="{{ route('customer.my-consults') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium hover:underline">View All</a>
                </div>
                
                @if(isset($completedConsultations) && $completedConsultations->count() > 0)
                    <div class="divide-y divide-gray-100">
                        @foreach($completedConsultations as $consultation)
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        @if($consultation->consultantProfile->avatar_path ?? null)
                                            <img src="{{ asset('storage/'.$consultation->consultantProfile->avatar_path) }}" alt="Avatar" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center border-2 border-white shadow-sm">
                                                <span class="text-sm font-bold text-gray-500">{{ substr($consultation->consultantProfile->user->name ?? '?', 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $consultation->consultantProfile->user->name ?? 'Unknown' }}</h4>
                                        <p class="text-sm text-gray-500">{{ $consultation->topic }}</p>
                                        <div class="text-xs text-gray-400 mt-1 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $consultation->updated_at->format('M j, Y') }}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    @if(auth()->user()->hasSubscriptionFeature('view_consultation_details'))
                                    <a href="{{ route('customer.consultations.show', $consultation->id) }}" class="px-3 py-1.5 bg-white border border-gray-200 text-gray-700 text-xs font-medium rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-colors shadow-sm">
                                        View Details
                                    </a>
                                    @else
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-tight">Upgrade to View</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-8 text-center text-gray-500">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <p>No completed sessions yet.</p>
                    </div>
                @endif
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm border border-dashed border-gray-300 p-8 text-center">
                <div class="w-16 h-16 bg-blue-50 text-blue-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">History Locked</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">Recent sessions and consultation history are exclusive to our premium subscribers. Upgrade now to track your progress.</p>
                <a href="{{ route('customer.plans') }}" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-md">
                    Upgrade to Unlock
                </a>
            </div>
            @endif


            <!-- Personal Notes -->
            @if(auth()->user()->hasSubscriptionFeature('manage_personal_notes'))
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Personal Notes & Reminders
                </h3>
                <form id="notesForm" class="flex gap-2 mb-4">
                    <input id="noteInput" type="text" placeholder="Add a quick note..." class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors">Add</button>
                </form>
                <div class="bg-yellow-50 rounded-lg p-2 min-h-[100px]">
                     <ul id="notesList" class="space-y-2"></ul>
                 </div>
                 <div class="mt-2 text-right">
                    <button id="clearNotes" class="text-xs text-red-500 hover:text-red-700">Clear all notes</button>
                 </div>
            </div>
            @else
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl shadow-sm border border-amber-100 p-6">
                <h3 class="font-bold text-amber-900 mb-4 flex items-center uppercase tracking-wider text-xs">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Notes Capability Locked
                </h3>
                <p class="text-amber-800 text-sm mb-4">You need a premium plan to use the built-in Personal Notes and Reminders feature.</p>
                <a href="{{ route('customer.plans') }}" class="text-amber-900 font-extrabold text-sm border-b-2 border-amber-900 pb-1 hover:text-amber-700 hover:border-amber-700 transition-all">
                    Unlock Premium Tools →
                </a>
            </div>
            @endif


        </div>

    </div>

</div>
@endsection

@section('scripts')
    <script>
        (function() {
            const STORAGE_KEY = 'customerNotes';
            const form = document.getElementById('notesForm');
            const input = document.getElementById('noteInput');
            const list = document.getElementById('notesList');
            const clearBtn = document.getElementById('clearNotes');

            function getNotes() {
                try {
                    return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
                } catch (_) {
                    return [];
                }
            }

            function saveNotes(notes) {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(notes));
            }

            function renderNotes() {
                const notes = getNotes();
                list.innerHTML = '';
                if(notes.length === 0) {
                     list.innerHTML = '<li class="text-sm text-gray-400 italic text-center py-4">No notes yet.</li>';
                     return;
                }
                notes.forEach((note, index) => {
                    const li = document.createElement('li');
                    li.className = 'flex items-center justify-between bg-white rounded-md px-3 py-2 shadow-sm text-sm border border-yellow-100';
                    const text = document.createElement('span');
                    text.className = 'text-gray-800';
                    text.textContent = note;
                    const del = document.createElement('button');
                    del.className = 'text-xs text-red-400 hover:text-red-600 ml-2';
                    del.innerHTML = '&times;';
                    del.title = 'Delete';
                    del.addEventListener('click', function() {
                        const updated = getNotes();
                        updated.splice(index, 1);
                        saveNotes(updated);
                        renderNotes();
                    });
                    li.appendChild(text);
                    li.appendChild(del);
                    list.appendChild(li);
                });
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const value = (input.value || '').trim();
                if (!value) return;
                const notes = getNotes();
                notes.unshift(value);
                saveNotes(notes);
                input.value = '';
                renderNotes();
            });

            clearBtn.addEventListener('click', function() {
                saveNotes([]);
                renderNotes();
            });

            renderNotes();
        })();
    </script>
@endsection
