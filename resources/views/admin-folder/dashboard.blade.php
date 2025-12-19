@extends('admin-folder.layout')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome back, {{ Auth::user()->name }}!</h2>
        <p class="text-gray-600">Here's what's happening with your platform today.</p>
    </div>

    <!-- Main 3-Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Column 1: Top Consultants Based on Area of Expertise -->
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
                            <a href="{{ route('admin.consultants.expertise', ['expertise' => urlencode($expertise)]) }}" 
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

        <!-- Column 2: Recognition & Awards -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                    Recognition & Awards
                </h3>
                <p class="text-amber-100 text-sm mt-1">Celebrating our top performers</p>
            </div>
            <div class="p-4 space-y-4">
                
                <!-- Consultant of the Month -->
                @if($consultantOfTheMonth)
                <a href="{{ route('admin.consultants.category', 'month') }}" 
                   class="block bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-5 border border-amber-200 relative overflow-hidden hover:shadow-lg hover:border-amber-300 transition-all duration-200 group cursor-pointer">
                    <div class="absolute top-0 right-0 w-20 h-20 transform translate-x-6 -translate-y-6">
                        <div class="w-full h-full bg-amber-200 rounded-full opacity-30"></div>
                    </div>
                    <div class="relative">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <h4 class="text-sm font-bold text-amber-800">Consultant of the Month</h4>
                                <p class="text-xs text-amber-600">{{ now()->format('F Y') }}</p>
                            </div>
                            <svg class="w-5 h-5 text-amber-400 group-hover:text-amber-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <div class="flex items-center">
                            @if($consultantOfTheMonth['profile']->avatar_path)
                                <img src="{{ asset('storage/' . $consultantOfTheMonth['profile']->avatar_path) }}" 
                                     alt="{{ $consultantOfTheMonth['name'] }}" 
                                     class="w-14 h-14 rounded-full object-cover border-3 border-amber-300 shadow-lg group-hover:scale-105 transition-transform">
                            @else
                                <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center border-3 border-amber-300 shadow-lg group-hover:scale-105 transition-transform">
                                    <span class="text-white font-bold text-lg">{{ substr($consultantOfTheMonth['name'], 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="ml-4">
                                <p class="font-bold text-gray-900 group-hover:text-amber-700 transition-colors">{{ $consultantOfTheMonth['name'] }}</p>
                                <p class="text-sm text-amber-700">{{ $consultantOfTheMonth['count'] }} completed consultations</p>
                            </div>
                        </div>
                    </div>
                </a>
                @else
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-5 border border-amber-200 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 transform translate-x-6 -translate-y-6">
                        <div class="w-full h-full bg-amber-200 rounded-full opacity-30"></div>
                    </div>
                    <div class="relative">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-bold text-amber-800">Consultant of the Month</h4>
                                <p class="text-xs text-amber-600">{{ now()->format('F Y') }}</p>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <p class="text-amber-700 text-sm">No completed consultations this month yet</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Highest Rated -->
                @if($highestRatedConsultant)
                <a href="{{ route('admin.consultants.category', 'rated') }}" 
                   class="block bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-5 border border-purple-200 relative overflow-hidden hover:shadow-lg hover:border-purple-300 transition-all duration-200 group cursor-pointer">
                    <div class="absolute top-0 right-0 w-16 h-16 transform translate-x-4 -translate-y-4">
                        <div class="w-full h-full bg-purple-200 rounded-full opacity-30"></div>
                    </div>
                    <div class="relative">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <h4 class="text-sm font-bold text-purple-800">Highest Rated</h4>
                                <p class="text-xs text-purple-600">Based on customer reviews</p>
                            </div>
                            <svg class="w-5 h-5 text-purple-400 group-hover:text-purple-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <div class="flex items-center">
                            @if($highestRatedConsultant['profile']->avatar_path)
                                <img src="{{ asset('storage/' . $highestRatedConsultant['profile']->avatar_path) }}" 
                                     alt="{{ $highestRatedConsultant['name'] }}" 
                                     class="w-14 h-14 rounded-full object-cover border-3 border-purple-300 shadow-lg group-hover:scale-105 transition-transform">
                            @else
                                <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center border-3 border-purple-300 shadow-lg group-hover:scale-105 transition-transform">
                                    <span class="text-white font-bold text-lg">{{ substr($highestRatedConsultant['name'], 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="ml-4">
                                <p class="font-bold text-gray-900 group-hover:text-purple-700 transition-colors">{{ $highestRatedConsultant['name'] }}</p>
                                <div class="flex items-center mt-1">
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $highestRatedConsultant['average_rating'])
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
                                    <span class="ml-2 text-sm text-purple-700 font-medium">{{ $highestRatedConsultant['average_rating'] }}/5</span>
                                    <span class="ml-1 text-xs text-gray-500">({{ $highestRatedConsultant['total_ratings'] }} reviews)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @else
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-5 border border-purple-200 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-16 h-16 transform translate-x-4 -translate-y-4">
                        <div class="w-full h-full bg-purple-200 rounded-full opacity-30"></div>
                    </div>
                    <div class="relative">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-bold text-purple-800">Highest Rated</h4>
                                <p class="text-xs text-purple-600">Based on customer reviews</p>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <p class="text-purple-700 text-sm">No ratings yet</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Rising Star -->
                @if($risingStar)
                <a href="{{ route('admin.consultants.category', 'rising') }}" 
                   class="block bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-5 border border-green-200 relative overflow-hidden hover:shadow-lg hover:border-green-300 transition-all duration-200 group cursor-pointer">
                    <div class="absolute top-0 right-0 w-16 h-16 transform translate-x-4 -translate-y-4">
                        <div class="w-full h-full bg-green-200 rounded-full opacity-30"></div>
                    </div>
                    <div class="relative">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <h4 class="text-sm font-bold text-green-800">Rising Star</h4>
                                <p class="text-xs text-green-600">Newest top performer</p>
                            </div>
                            <svg class="w-5 h-5 text-green-400 group-hover:text-green-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <div class="flex items-center">
                            @if($risingStar['profile']->avatar_path)
                                <img src="{{ asset('storage/' . $risingStar['profile']->avatar_path) }}" 
                                     alt="{{ $risingStar['name'] }}" 
                                     class="w-14 h-14 rounded-full object-cover border-3 border-green-300 shadow-lg group-hover:scale-105 transition-transform">
                            @else
                                <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center border-3 border-green-300 shadow-lg group-hover:scale-105 transition-transform">
                                    <span class="text-white font-bold text-lg">{{ substr($risingStar['name'], 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="ml-4">
                                <p class="font-bold text-gray-900 group-hover:text-green-700 transition-colors">{{ $risingStar['name'] }}</p>
                                <p class="text-sm text-green-700">{{ $risingStar['completed_count'] }} consultations • Joined {{ $risingStar['joined'] }}</p>
                            </div>
                        </div>
                    </div>
                </a>
                @else
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-5 border border-green-200 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-16 h-16 transform translate-x-4 -translate-y-4">
                        <div class="w-full h-full bg-green-200 rounded-full opacity-30"></div>
                    </div>
                    <div class="relative">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-bold text-green-800">Rising Star</h4>
                                <p class="text-xs text-green-600">Newest top performer</p>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <p class="text-green-700 text-sm">No rising stars yet</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Most Booked -->
                @if($mostBookedConsultant)
                <a href="{{ route('admin.consultants.category', 'booked') }}" 
                   class="block bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-5 border border-blue-200 relative overflow-hidden hover:shadow-lg hover:border-blue-300 transition-all duration-200 group cursor-pointer">
                    <div class="absolute top-0 right-0 w-16 h-16 transform translate-x-4 -translate-y-4">
                        <div class="w-full h-full bg-blue-200 rounded-full opacity-30"></div>
                    </div>
                    <div class="relative">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <h4 class="text-sm font-bold text-blue-800">Most Booked</h4>
                                <p class="text-xs text-blue-600">All-time booking champion</p>
                            </div>
                            <svg class="w-5 h-5 text-blue-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-gray-900 group-hover:text-blue-700 transition-colors">{{ $mostBookedConsultant['consultant'] }}</p>
                                <p class="text-sm text-blue-700">{{ $mostBookedConsultant['count'] }} total bookings</p>
                            </div>
                            <div class="text-3xl font-bold text-blue-500 transform group-hover:scale-110 transition-transform">🏆</div>
                        </div>
                    </div>
                </a>
                @else
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-5 border border-blue-200 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-16 h-16 transform translate-x-4 -translate-y-4">
                        <div class="w-full h-full bg-blue-200 rounded-full opacity-30"></div>
                    </div>
                    <div class="relative">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-bold text-blue-800">Most Booked</h4>
                                <p class="text-xs text-blue-600">All-time booking champion</p>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <p class="text-blue-700 text-sm">No bookings yet</p>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>

        <!-- Column 3: Manage Users & Stats -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Manage Users
                </h3>
                <p class="text-gray-300 text-sm mt-1">Platform overview & quick actions</p>
            </div>
            <div class="p-4 space-y-4">
                
                <!-- Pending Approvals Card -->
                <a href="{{ route('admin.manage-users') }}" class="block bg-gradient-to-r from-red-50 to-orange-50 rounded-xl p-5 border border-red-100 hover:shadow-lg hover:border-red-200 transition-all duration-200 group">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Pending Approvals</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $pendingApprovals ?? 0 }}</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- Active Consultants Card -->
                <a href="{{ route('admin.consultants') }}" class="block bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-5 border border-green-100 hover:shadow-lg hover:border-green-200 transition-all duration-200 group">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Active Consultants</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $consultants->count() }}</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- Total Customers Card -->
                <a href="{{ route('admin.customers') }}" class="block bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-5 border border-blue-100 hover:shadow-lg hover:border-blue-200 transition-all duration-200 group">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Customers</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $customers->count() }}</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- Total Consultations Card -->
                <a href="{{ route('admin.consultations') }}" class="block bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-5 border border-purple-100 hover:shadow-lg hover:border-purple-200 transition-all duration-200 group">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Consultations</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $totalConsultations ?? 0 }}</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- Quick Actions -->
                <div class="pt-2 border-t border-gray-100">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-3">Quick Actions</p>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('admin.reports') }}" class="flex items-center justify-center px-4 py-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Reports
                        </a>
                        <a href="{{ route('admin.settings') }}" class="flex items-center justify-center px-4 py-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Settings
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Analytics Section - Premium Design -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Monthly Consultations Chart - Enhanced -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <!-- Header with gradient -->
            <div class="bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-bold text-white">Monthly Consultations</h3>
                            <p class="text-blue-100 text-xs">Performance over the last 6 months</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-white">{{ $totalConsultations ?? 0 }}</div>
                        <div class="text-blue-100 text-xs">Total</div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Row -->
            <div class="grid grid-cols-3 gap-px bg-gray-100">
                @php
                    $lastMonth = end($monthlyData)['count'] ?? 0;
                    $prevMonth = count($monthlyData) > 1 ? $monthlyData[count($monthlyData) - 2]['count'] ?? 0 : 0;
                    $trend = $prevMonth > 0 ? round((($lastMonth - $prevMonth) / $prevMonth) * 100) : 0;
                    $avgPerMonth = count($monthlyData) > 0 ? round(array_sum(array_column($monthlyData, 'count')) / count($monthlyData), 1) : 0;
                @endphp
                <div class="bg-white p-4 text-center">
                    <div class="text-xs text-gray-500 uppercase tracking-wide">This Month</div>
                    <div class="text-xl font-bold text-gray-900 mt-1">{{ $lastMonth }}</div>
                </div>
                <div class="bg-white p-4 text-center">
                    <div class="text-xs text-gray-500 uppercase tracking-wide">Avg/Month</div>
                    <div class="text-xl font-bold text-gray-900 mt-1">{{ $avgPerMonth }}</div>
                </div>
                <div class="bg-white p-4 text-center">
                    <div class="text-xs text-gray-500 uppercase tracking-wide">Trend</div>
                    <div class="flex items-center justify-center mt-1">
                        @if($trend > 0)
                            <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span class="text-xl font-bold text-green-500">+{{ $trend }}%</span>
                        @elseif($trend < 0)
                            <svg class="w-4 h-4 text-red-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                            <span class="text-xl font-bold text-red-500">{{ $trend }}%</span>
                        @else
                            <span class="text-xl font-bold text-gray-500">0%</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Chart -->
            <div class="p-6">
                <div class="relative h-56">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Status Breakdown Chart - Enhanced -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <!-- Header with gradient -->
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
                            <p class="text-purple-100 text-xs">Consultation status distribution</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-white">{{ $totalConsultations ?? 0 }}</div>
                        <div class="text-purple-100 text-xs">Total</div>
                    </div>
                </div>
            </div>
            
            <!-- Status Legend with counts -->
            <div class="p-4 bg-gray-50 border-b border-gray-100">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @php
                        $statusColors = [
                            'Pending' => ['bg' => 'bg-yellow-500', 'light' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
                            'Accepted' => ['bg' => 'bg-blue-500', 'light' => 'bg-blue-100', 'text' => 'text-blue-700'],
                            'Completed' => ['bg' => 'bg-green-500', 'light' => 'bg-green-100', 'text' => 'text-green-700'],
                            'Rejected' => ['bg' => 'bg-red-500', 'light' => 'bg-red-100', 'text' => 'text-red-700'],
                            'Cancelled' => ['bg' => 'bg-gray-500', 'light' => 'bg-gray-100', 'text' => 'text-gray-700'],
                            'Proposed' => ['bg' => 'bg-indigo-500', 'light' => 'bg-indigo-100', 'text' => 'text-indigo-700'],
                            'Expired' => ['bg' => 'bg-orange-500', 'light' => 'bg-orange-100', 'text' => 'text-orange-700'],
                        ];
                    @endphp
                    @foreach($statusBreakdown as $status => $count)
                        @php
                            $colors = $statusColors[$status] ?? ['bg' => 'bg-gray-500', 'light' => 'bg-gray-100', 'text' => 'text-gray-700'];
                            $percentage = $totalConsultations > 0 ? round(($count / $totalConsultations) * 100) : 0;
                        @endphp
                        <div class="flex items-center p-2 {{ $colors['light'] }} rounded-lg hover:scale-105 transition-transform cursor-default">
                            <div class="w-3 h-3 {{ $colors['bg'] }} rounded-full mr-2 shadow-sm"></div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-medium {{ $colors['text'] }} truncate">{{ $status }}</div>
                                <div class="flex items-center">
                                    <span class="text-sm font-bold text-gray-900">{{ $count }}</span>
                                    <span class="text-xs text-gray-500 ml-1">({{ $percentage }}%)</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Chart -->
            <div class="p-6">
                <div class="relative h-48 flex items-center justify-center">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Most Common Topics - Enhanced -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
        <!-- Header with gradient -->
        <div class="bg-gradient-to-r from-teal-600 via-teal-500 to-cyan-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-bold text-white">Most Common Topics</h3>
                        <p class="text-teal-100 text-xs">Popular consultation categories</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-white">{{ $topTopics ? $topTopics->count() : 0 }}</div>
                    <div class="text-teal-100 text-xs">Categories</div>
                </div>
            </div>
        </div>
        
        <!-- Topics Content -->
        <div class="p-6">
            @if($topTopics && $topTopics->count() > 0)
                @php
                    $maxCount = $topTopics->max();
                    $topicColors = [
                        ['from' => 'from-amber-400', 'to' => 'to-orange-500', 'bg' => 'bg-amber-50', 'border' => 'border-amber-200', 'text' => 'text-amber-600', 'bar' => 'from-amber-400 to-orange-500'],
                        ['from' => 'from-gray-300', 'to' => 'to-gray-400', 'bg' => 'bg-gray-50', 'border' => 'border-gray-200', 'text' => 'text-gray-600', 'bar' => 'from-gray-300 to-gray-400'],
                        ['from' => 'from-orange-300', 'to' => 'to-amber-400', 'bg' => 'bg-orange-50', 'border' => 'border-orange-200', 'text' => 'text-orange-600', 'bar' => 'from-orange-300 to-amber-400'],
                        ['from' => 'from-blue-400', 'to' => 'to-indigo-500', 'bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-600', 'bar' => 'from-blue-400 to-indigo-500'],
                        ['from' => 'from-purple-400', 'to' => 'to-pink-500', 'bg' => 'bg-purple-50', 'border' => 'border-purple-200', 'text' => 'text-purple-600', 'bar' => 'from-purple-400 to-pink-500'],
                    ];
                    $rankIcons = ['🥇', '🥈', '🥉', '4', '5'];
                    $index = 0;
                @endphp
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    @foreach($topTopics as $topic => $count)
                        @php
                            $colors = $topicColors[$index] ?? $topicColors[4];
                            $percentage = $maxCount > 0 ? round(($count / $maxCount) * 100) : 0;
                            $rank = $index + 1;
                        @endphp
                        <div class="relative {{ $colors['bg'] }} rounded-xl p-5 border {{ $colors['border'] }} hover:shadow-lg hover:scale-105 transition-all duration-300 cursor-default group overflow-hidden">
                            <!-- Decorative background element -->
                            <div class="absolute top-0 right-0 w-20 h-20 transform translate-x-8 -translate-y-8 opacity-10">
                                <div class="w-full h-full bg-gradient-to-br {{ $colors['from'] }} {{ $colors['to'] }} rounded-full"></div>
                            </div>
                            
                            <!-- Rank Badge -->
                            <div class="absolute top-3 left-3">
                                @if($rank <= 3)
                                    <span class="text-xl">{{ $rankIcons[$index] }}</span>
                                @else
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gradient-to-br {{ $colors['from'] }} {{ $colors['to'] }} text-white text-xs font-bold shadow-sm">
                                        {{ $rank }}
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="text-center pt-6 relative">
                                <p class="text-gray-800 font-semibold text-sm truncate mb-2" title="{{ $topic }}">{{ $topic }}</p>
                                <p class="text-3xl font-bold bg-gradient-to-r {{ $colors['from'] }} {{ $colors['to'] }} bg-clip-text text-transparent">{{ $count }}</p>
                                <p class="text-xs text-gray-500 mt-1">consultation{{ $count !== 1 ? 's' : '' }}</p>
                                
                                <!-- Progress Bar -->
                                <div class="mt-3 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r {{ $colors['bar'] }} rounded-full transition-all duration-500 group-hover:animate-pulse" 
                                         style="width: {{ $percentage }}%"></div>
                                </div>
                                <p class="text-xs {{ $colors['text'] }} mt-1 font-medium">{{ $percentage }}% of top</p>
                            </div>
                        </div>
                        @php $index++; @endphp
                    @endforeach
                </div>
                
                <!-- Summary Stats -->
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-center gap-8 text-sm">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span><strong class="text-gray-900">{{ $topTopics->sum() }}</strong> total in top {{ $topTopics->count() }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span>Most popular: <strong class="text-gray-900">{{ $topTopics->keys()->first() }}</strong></span>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-sm">No consultation topics yet</p>
                    <p class="text-gray-400 text-xs mt-1">Topics will appear here as consultations are created</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Consultations Chart - Enhanced
    const monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx) {
        const monthlyData = @json($monthlyData ?? []);
        
        // Create gradient
        const gradient = monthlyCtx.getContext('2d').createLinearGradient(0, 0, 0, 250);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
        gradient.addColorStop(0.5, 'rgba(99, 102, 241, 0.2)');
        gradient.addColorStop(1, 'rgba(139, 92, 246, 0.05)');
        
        new Chart(monthlyCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: monthlyData.map(d => d.month),
                datasets: [{
                    label: 'Consultations',
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
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(79, 70, 229)',
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 11,
                                weight: '500'
                            },
                            color: '#6B7280'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11,
                                weight: '500'
                            },
                            color: '#6B7280'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.95)',
                        titleFont: {
                            size: 13,
                            weight: '600'
                        },
                        bodyFont: {
                            size: 12
                        },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            title: function(context) {
                                return context[0].label;
                            },
                            label: function(context) {
                                return `${context.parsed.y} consultation${context.parsed.y !== 1 ? 's' : ''}`;
                            }
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });
    }

    // Status Breakdown Chart - Enhanced
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        const statusData = @json($statusBreakdown ?? []);
        
        // Define colors for each status
        const statusColors = {
            'Pending': '#EAB308',
            'Accepted': '#3B82F6',
            'Completed': '#10B981',
            'Rejected': '#EF4444',
            'Cancelled': '#6B7280',
            'Proposed': '#6366F1',
            'Expired': '#F97316'
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
                    hoverBorderWidth: 3,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        display: false  // We have custom legend above
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.95)',
                        titleFont: {
                            size: 13,
                            weight: '600'
                        },
                        bodyFont: {
                            size: 12
                        },
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
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });
    }
</script>
@endsection