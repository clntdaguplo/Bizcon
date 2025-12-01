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
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Requested: {{ $consultation->created_at->format('M j, Y g:i A') }}</span>
                                    </div>
                                </div>
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-yellow-100 text-yellow-800">
                                    Pending Review
                                </span>
                            </div>

                            <!-- Request Details -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <h4 class="font-medium text-gray-900 mb-2">Request Details:</h4>
                                <p class="text-gray-700">{{ $consultation->details }}</p>
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
                                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Open Request</a>
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
