@extends('admin-folder.layout')

@section('title', $title)
@section('page-title', $title)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r 
            @if($category == 'month') from-amber-500 to-orange-500 
            @elseif($category == 'rated') from-purple-500 to-pink-500 
            @elseif($category == 'rising') from-green-500 to-emerald-500 
            @else from-blue-500 to-cyan-500 
            @endif px-6 py-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('dashboard.admin') }}" class="mr-4 text-white/80 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $title }}</h1>
                        <p class="text-white/80 text-sm">{{ $desc }}</p>
                    </div>
                </div>
                <!-- Icon depending on category -->
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-white">
                    @if($category == 'month')
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    @elseif($category == 'rated')
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    @elseif($category == 'rising')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    @else
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($consultants->count() > 0)
        <!-- Top Consultant Highlight -->
        @if($topConsultant)
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl shadow-lg border border-amber-200 p-6">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
                <h3 class="ml-3 text-lg font-bold text-amber-900">🏆 #1 {{ $title }} Leader</h3>
            </div>
            <div class="flex items-center">
                <div class="relative">
                    @if($topConsultant->avatar_path)
                        <img src="{{ asset('storage/' . $topConsultant->avatar_path) }}" 
                             alt="{{ $topConsultant->full_name }}" 
                             class="w-20 h-20 rounded-full object-cover border-4 border-amber-300 shadow-lg">
                    @else
                        <div class="w-20 h-20 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center border-4 border-amber-300 shadow-lg">
                            <span class="text-white font-bold text-2xl">{{ substr($topConsultant->full_name ?? 'C', 0, 1) }}</span>
                        </div>
                    @endif
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center shadow-lg">
                        <span class="text-white text-sm">🥇</span>
                    </div>
                </div>
                <div class="ml-6 flex-1">
                    <h4 class="text-xl font-bold text-gray-900">{{ $topConsultant->full_name ?? 'Unknown' }}</h4>
                    <p class="text-gray-600">{{ $topConsultant->email ?? $topConsultant->user->email ?? '' }}</p>
                    <div class="flex items-center gap-4 mt-2">
                        <div class="flex items-center">
                            @if($category == 'rated')
                                <svg class="w-5 h-5 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="text-lg font-bold text-gray-900">{{ $topConsultant->average_rating ?? '0' }}/5</span>
                                <span class="text-xs text-gray-500 ml-1">({{ $topConsultant->total_ratings ?? 0 }} reviews)</span>
                            @else
                                <span class="text-2xl font-bold text-green-600 mr-2">{{ $topConsultant->stat_value }}</span>
                                <span class="text-sm font-medium text-gray-700">{{ $statLabel }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.consultants.show', $topConsultant->id) }}" 
                   class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors font-medium">
                    View Profile
                </a>
            </div>
        </div>
        @endif

        <!-- All Consultants List -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center text-sm font-semibold text-gray-600">
                    <div class="w-16">Rank</div>
                    <div class="flex-1">Consultant</div>
                    <div class="w-40 text-right">{{ $statLabel }}</div>
                    <div class="w-32 text-right">Actions</div>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($consultants as $index => $consultant)
                    <div class="p-5 hover:bg-gray-50 transition-colors group">
                        <div class="flex items-center">
                            <!-- Rank Badge -->
                            <div class="w-16 text-center">
                                @if($index === 0)
                                    <span class="text-3xl">🥇</span>
                                @elseif($index === 1)
                                    <span class="text-3xl">🥈</span>
                                @elseif($index === 2)
                                    <span class="text-3xl">🥉</span>
                                @else
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-600 font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Avatar & Info -->
                            <div class="flex-1 flex items-center">
                                <div class="relative mr-4">
                                    @if($consultant->avatar_path)
                                        <img src="{{ asset('storage/' . $consultant->avatar_path) }}" 
                                             alt="{{ $consultant->full_name }}" 
                                             class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                                    @else
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center border-2 border-gray-200">
                                            <span class="text-white font-bold text-lg">{{ substr($consultant->full_name ?? 'C', 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-semibold text-gray-900 truncate group-hover:text-blue-600 transition-colors">{{ $consultant->full_name ?? 'Unknown' }}</h4>
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @foreach(array_slice(explode(',', $consultant->expertise), 0, 2) as $exp)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                {{ trim($exp) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Stat -->
                            <div class="w-40 text-right">
                                @if($category == 'rated')
                                    <div class="flex items-center justify-end">
                                        <svg class="w-5 h-5 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="text-xl font-bold text-gray-900">{{ $consultant->stat_value }}</span>
                                        <span class="text-sm text-gray-500 ml-1">/ 5</span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $consultant->total_ratings }} reviews</div>
                                @else
                                    <div class="text-2xl font-bold text-blue-600">{{ $consultant->stat_value }}</div>
                                    <div class="text-xs text-gray-500">completed</div>
                                @endif
                            </div>
                            
                            <!-- Actions -->
                            <div class="w-32 text-right">
                                <a href="{{ route('admin.consultants.show', $consultant->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors shadow-sm">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Consultants in this List</h3>
            <p class="text-gray-500 mb-6">There are currently no consultants that meet the criteria for "{{ $title }}".</p>
            <a href="{{ route('dashboard.admin') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    @endif
</div>
@endsection
