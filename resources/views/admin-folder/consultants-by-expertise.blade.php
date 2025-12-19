@extends('admin-folder.layout')

@section('title', $decodedExpertise . ' Consultants')
@section('page-title', $decodedExpertise)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('dashboard.admin') }}" class="mr-4 text-white/80 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $decodedExpertise }}</h1>
                        <p class="text-blue-100 text-sm">All consultants in this expertise area</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-white">{{ $consultants->count() }}</div>
                    <div class="text-blue-100 text-sm">Consultant{{ $consultants->count() !== 1 ? 's' : '' }}</div>
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
                <h3 class="ml-3 text-lg font-bold text-amber-900">🏆 Top Consultant in {{ $decodedExpertise }}</h3>
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
                            <svg class="w-5 h-5 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">{{ $topConsultant->completed_count }} completed</span>
                        </div>
                        @if($topConsultant->average_rating)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">{{ $topConsultant->average_rating }}/5 ({{ $topConsultant->total_ratings }} reviews)</span>
                        </div>
                        @endif
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
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    All {{ $decodedExpertise }} Consultants
                </h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($consultants as $index => $consultant)
                    <div class="p-5 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <!-- Rank Badge -->
                            <div class="w-10 text-center mr-4">
                                @if($index === 0)
                                    <span class="text-2xl">🥇</span>
                                @elseif($index === 1)
                                    <span class="text-2xl">🥈</span>
                                @elseif($index === 2)
                                    <span class="text-2xl">🥉</span>
                                @else
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-600 font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Avatar -->
                            <div class="relative">
                                @if($consultant->avatar_path)
                                    <img src="{{ asset('storage/' . $consultant->avatar_path) }}" 
                                         alt="{{ $consultant->full_name }}" 
                                         class="w-14 h-14 rounded-full object-cover border-2 border-gray-200">
                                @else
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center border-2 border-gray-200">
                                        <span class="text-white font-bold text-lg">{{ substr($consultant->full_name ?? 'C', 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center border-2 border-white">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Info -->
                            <div class="ml-4 flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-900 truncate">{{ $consultant->full_name ?? 'Unknown' }}</h4>
                                <p class="text-sm text-gray-500 truncate">{{ $consultant->email ?? $consultant->user->email ?? '' }}</p>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach(array_slice(explode(',', $consultant->expertise), 0, 3) as $exp)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ trim($exp) === $decodedExpertise ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}">
                                            {{ trim($exp) }}
                                        </span>
                                    @endforeach
                                    @if(count(explode(',', $consultant->expertise)) > 3)
                                        <span class="text-xs text-gray-400">+{{ count(explode(',', $consultant->expertise)) - 3 }} more</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Stats -->
                            <div class="hidden md:flex items-center gap-6 ml-4">
                                <div class="text-center">
                                    <div class="text-xl font-bold text-green-600">{{ $consultant->completed_count }}</div>
                                    <div class="text-xs text-gray-500">Completed</div>
                                </div>
                                <div class="text-center">
                                    @if($consultant->average_rating)
                                        <div class="flex items-center justify-center">
                                            <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span class="text-lg font-bold text-gray-900">{{ $consultant->average_rating }}</span>
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $consultant->total_ratings }} reviews</div>
                                    @else
                                        <div class="text-sm text-gray-400">No ratings</div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="ml-4">
                                <a href="{{ route('admin.consultants.show', $consultant->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    View Profile
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Consultants Found</h3>
            <p class="text-gray-500 mb-6">There are no verified consultants with expertise in "{{ $decodedExpertise }}" yet.</p>
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
