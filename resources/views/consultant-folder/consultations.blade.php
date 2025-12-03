@extends('consultant-folder.layout')

@section('title', 'Consultations')
@section('page-title', 'My Consultations')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- banner shown only when controller sets $showProfileBanner --}}
        @if(!empty($showProfileBanner))
             <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded-xl mb-6">
                 <div class="flex items-start justify-between">
                     <div class="flex items-start">
                         <svg class="w-5 h-5 text-yellow-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                             <path d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zM9 7h2v5H9V7zm0 6h2v2H9v-2z"/>
                         </svg>
                         <div class="ml-3">
                            <p class="font-medium">Complete your profile to start receiving consultations and accept bookings.</p>
                             <p class="text-sm mt-1 text-yellow-700">Fill out required fields and upload your photo/resume so customers can book you.</p>
                         </div>
                     </div>
                     <div class="ml-4">
                         <a href="{{ route('consultant.profile') }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md text-sm hover:bg-yellow-700">
                             Complete Profile
                         </a>
                     </div>
                 </div>
             </div>
        @endif

        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">My Consultations</h1>
                    <p class="text-gray-600">View and manage all consultation requests assigned to you</p>
                </div>
                <div class="mt-4 lg:mt-0">
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                            <span>Pending</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                            <span>Accepted</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                            <span>Completed</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
                <button onclick="filterConsultations('all')" 
                        class="filter-btn px-4 py-2 rounded-md text-sm font-medium transition-colors bg-white text-gray-900 shadow-sm">
                    All
                </button>
                <button onclick="filterConsultations('pending')" 
                        class="filter-btn px-4 py-2 rounded-md text-sm font-medium transition-colors text-gray-600 hover:bg-white">
                    Pending
                </button>
                <button onclick="filterConsultations('accepted')" 
                        class="filter-btn px-4 py-2 rounded-md text-sm font-medium transition-colors text-gray-600 hover:bg-white">
                    Accepted
                </button>
                <button onclick="filterConsultations('completed')" 
                        class="filter-btn px-4 py-2 rounded-md text-sm font-medium transition-colors text-gray-600 hover:bg-white">
                    Completed
                </button>
            </div>
        </div>

        <!-- Consultations List -->
        <div class="bg-white rounded-xl shadow">
        @forelse($consultations as $consultation)
                <div id="consultation-{{ $consultation->id }}"
                     class="consultation-item border-b border-gray-200 p-6 hover:bg-gray-50 transition-colors" 
                     data-status="{{ strtolower($consultation->status) }}">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $consultation->topic }}</h3>
                                    <p class="text-gray-600 text-sm">From: {{ $consultation->customer->name ?? 'Unknown Customer' }}</p>
                                </div>
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    @if($consultation->status === 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif($consultation->status === 'Accepted') bg-green-100 text-green-800
                                    @elseif($consultation->status === 'Completed') bg-blue-100 text-blue-800
                                    @elseif($consultation->status === 'Rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $consultation->status }}
                                </span>
                            </div>
                            
                            <p class="text-gray-700 mb-4">{{ Str::limit($consultation->details, 150) }}</p>
                            
                            @if($consultation->status === 'Completed' && $consultation->client_readiness_rating)
                                <div class="mb-3 flex items-center">
                                    <span class="text-sm text-gray-600 mr-2">Client Readiness:</span>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $consultation->client_readiness_rating)
                                                <span class="text-yellow-500 text-lg">⭐</span>
                                            @else
                                                <span class="text-gray-300 text-lg">☆</span>
                                            @endif
                                        @endfor
                                        <span class="ml-2 text-sm text-gray-700 font-medium">{{ $consultation->client_readiness_rating }}/5</span>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Preferred Date: {{ $consultation->preferred_date ? \Carbon\Carbon::parse($consultation->preferred_date)->format('M j, Y') : 'Not specified' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Time: {{ $consultation->preferred_time ? \Carbon\Carbon::parse($consultation->preferred_time)->format('g:i A') : 'Not specified' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Requested: {{ $consultation->created_at->format('M j, Y g:i A') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 lg:mt-0 lg:ml-6 flex flex-col space-y-2">
                            @if($consultation->status === 'Pending' || $consultation->status === 'Accepted')
                                <a href="{{ route('consultant.consultations.open', $consultation->id) }}" 
                                   class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                                    Open Request
                                </a>
                            @elseif($consultation->status === 'Completed')
                                <div class="space-y-2">
                                    @if($consultation->consultation_summary)
                                        <a href="{{ route('consultant.consultations.report.view', $consultation->id) }}" 
                                           class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors w-full" target="_blank">
                                            📄 View Report
                                        </a>
                                        @if($consultation->client_readiness_rating)
                                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                                <p class="text-xs text-gray-600 mb-1">Client Readiness:</p>
                                                <div class="flex items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $consultation->client_readiness_rating)
                                                            <span class="text-yellow-500 text-lg">⭐</span>
                                                        @else
                                                            <span class="text-gray-300 text-lg">☆</span>
                                                        @endif
                                                    @endfor
                                                    <span class="ml-2 text-sm text-gray-700">{{ $consultation->client_readiness_rating }}/5</span>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <a href="{{ route('consultant.consultations.report', $consultation->id) }}" 
                                           class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors w-full">
                                            ✍️ Create Report
                                        </a>
                                    @endif
                                    @php
                                        $hasRated = \App\Models\ConsultationRating::where('consultation_id', $consultation->id)
                                            ->where('rater_id', Auth::id())
                                            ->where('rater_type', 'consultant')
                                            ->exists();
                                    @endphp
                                    @if(!$hasRated)
                                        <a href="{{ route('consultant.consultations.rate', $consultation->id) }}" 
                                           class="inline-block bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-yellow-700 transition-colors w-full">
                                            ⭐ Rate Client
                                        </a>
                                    @endif
                                </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Consultations Yet</h3>
                    <p class="text-gray-600 mb-6">You haven't received any consultation requests yet. They will appear here once customers start requesting your services.</p>
                    <a href="{{ route('consultant.profile') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        Update Your Profile
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function filterConsultations(status) {
        // Update button states
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
            btn.classList.add('text-gray-600', 'hover:bg-white');
        });
        event.target.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
        event.target.classList.remove('text-gray-600', 'hover:bg-white');
        
        // Filter consultation items
        const items = document.querySelectorAll('.consultation-item');
        items.forEach(item => {
            if (status === 'all' || item.dataset.status === status) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // When arriving via notification with ?highlight=ID, scroll and highlight that consultation
    document.addEventListener('DOMContentLoaded', function () {
        const params = new URLSearchParams(window.location.search);
        const highlightId = params.get('highlight');
        if (highlightId) {
            const el = document.getElementById('consultation-' + highlightId);
            if (el) {
                el.classList.add('ring-2', 'ring-blue-400', 'ring-offset-1');
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });

                setTimeout(() => {
                    el.classList.remove('ring-2', 'ring-blue-400', 'ring-offset-1');
                }, 4000);
            }
        }
    });

    // viewConsultationDetails removed — Open Request now navigates to the request response page
</script>
@endsection
