@extends('consultant-folder.layout')

@section('title', 'Respond to Requests')
@section('page-title', 'Respond to Requests')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Respond to Consultation Requests</h1>
                    <p class="text-gray-600">Review and respond to pending consultation requests from customers</p>
                </div>
                <div class="mt-4 lg:mt-0">
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                            <span>{{ $pending_consultations->count() }} Pending Review</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Pending Requests -->
        @if($pending_consultations->count() > 0)
            <div class="space-y-6">
                @foreach($pending_consultations as $consultation)
                    <div class="bg-white rounded-xl shadow border border-gray-200">
                        <div class="p-6">
                            <!-- Request Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $consultation->topic }}</h3>
                                    <div class="flex items-center text-sm text-gray-600 mb-2">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>From: {{ $consultation->customer->name ?? 'Unknown Customer' }}</span>
                                        @php
                                            $customerTier = \App\Services\SubscriptionService::getTier($consultation->customer);
                                        @endphp
                                        @if($customerTier === 'Free')
                                            <span class="ml-2 px-2 py-0.5 bg-red-100 text-red-700 text-[10px] font-bold rounded-full border border-red-200 uppercase tracking-wider">Free Trial</span>
                                        @elseif($customerTier === 'Weekly')
                                            <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-full border border-blue-200 uppercase tracking-wider">Weekly</span>
                                        @elseif($customerTier === 'Quarterly')
                                            <span class="ml-2 px-2 py-0.5 bg-purple-100 text-purple-700 text-[10px] font-bold rounded-full border border-purple-200 uppercase tracking-wider">Quarterly</span>
                                        @elseif($customerTier === 'Annual')
                                            <span class="ml-2 px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-full border border-amber-200 uppercase tracking-wider shadow-sm">Annual</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Requested: {{ $consultation->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-yellow-100 text-yellow-800">
                                    Pending Review
                                </span>
                            </div>

                            <!-- Request Details -->
                            <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl p-5 border border-gray-200 mb-4">
                                <div class="flex items-center mb-3">
                                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900">Request Details</h4>
                                </div>
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $consultation->details }}</p>
                                </div>
                            </div>

                            <!-- Preferred Schedule -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span><strong>Preferred Date:</strong> {{ $consultation->preferred_date ? \Carbon\Carbon::parse($consultation->preferred_date)->format('M j, Y') : 'Not specified' }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span><strong>Preferred Time:</strong> {{ $consultation->preferred_time ? \Carbon\Carbon::parse($consultation->preferred_time)->format('g:i A') : 'Not specified' }}</span>
                                </div>
                            </div>

                            <!-- Open Request (go to dedicated page to schedule Google Meet) -->
                            <div class="border-t border-gray-200 pt-6">
                                <div class="flex justify-end">
                                    <a href="{{ route('consultant.consultations.open', $consultation->id) }}" 
                                       class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md hover:shadow-lg font-medium">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Open Request & Respond
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Pending Requests</h3>
                <p class="text-gray-600 mb-6">You don't have any pending consultation requests to respond to at the moment.</p>
                <a href="{{ route('consultant.consultations') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    View All Consultations
                </a>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    // Show/hide alternative schedule based on response type
    document.addEventListener('DOMContentLoaded', function() {
        const responseTypes = document.querySelectorAll('input[name="response_type"]');
        const alternativeSchedule = document.getElementById('alternative_schedule');
        
        responseTypes.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'accept') {
                    alternativeSchedule.classList.remove('hidden');
                } else {
                    alternativeSchedule.classList.add('hidden');
                }
            });
        });
    });
    
    function resetForm() {
        document.querySelectorAll('input[name="response_type"]').forEach(radio => {
            radio.checked = false;
        });
        document.getElementById('response_message').value = '';
        document.getElementById('alternative_date').value = '';
        document.getElementById('alternative_time').value = '';
        document.getElementById('alternative_schedule').classList.add('hidden');
    }
</script>
@endsection
