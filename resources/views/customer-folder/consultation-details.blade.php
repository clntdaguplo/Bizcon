@extends('customer-folder.layout')

@section('title', 'Consultation Details')
@section('page-title', 'Consultation Details')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('customer.my-consults') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg border border-gray-300 hover:bg-gray-50 hover:text-gray-900 transition shadow-sm hover:shadow">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to My Consultations
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
                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Accepted
                    </span>
                @elseif($consultation->status === 'Rejected')
                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-red-100 text-red-800 border border-red-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Rejected
                    </span>
                @elseif($consultation->status === 'Expired')
                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-gray-100 text-gray-800 border border-gray-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Expired
                    </span>
                @else
                    <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Pending
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Consultant Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
            <div class="flex items-center">
                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Consultant</h2>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-full overflow-hidden bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center shadow-md">
                @if($consultation->consultantProfile->avatar_path ?? null)
                    <img src="{{ asset('storage/'.$consultation->consultantProfile->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                @else
                    <span class="text-2xl font-bold text-blue-700">{{ substr($consultation->consultantProfile->full_name ?? 'N/A', 0, 1) }}</span>
                @endif
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">{{ $consultation->consultantProfile->full_name ?? 'N/A' }}</h3>
                <p class="text-sm text-gray-600 mt-1">
                    {{ optional($consultation->consultantProfile->user)->email ?? 'N/A' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Booking Request Section -->
    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-6 border-2 border-purple-200 shadow-sm">
        <div class="flex items-center mb-4">
            <div class="bg-purple-600 p-3 rounded-xl mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Booking Request</h3>
                <p class="text-sm text-gray-600">Consultation booking details and preferences</p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg p-5 border border-purple-200 space-y-4">
            <div>
                <label class="text-xs font-semibold text-gray-600 uppercase mb-1 block">Topic</label>
                <p class="text-gray-900 font-medium">{{ $consultation->topic }}</p>
            </div>
            
            @if($consultation->details)
            <div>
                <label class="text-xs font-semibold text-gray-600 uppercase mb-1 block">Request Details</label>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $consultation->details }}</p>
            </div>
            @endif
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-semibold text-gray-600 uppercase mb-1 block">Preferred Date</label>
                    <p class="text-gray-900 font-medium">
                        {{ $consultation->preferred_date ? \Carbon\Carbon::parse($consultation->preferred_date)->format('F j, Y') : 'Not specified' }}
                    </p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 uppercase mb-1 block">Preferred Time</label>
                    <p class="text-gray-900 font-medium">
                        {{ $consultation->preferred_time ? \Carbon\Carbon::parse($consultation->preferred_time)->format('g:i A') : 'Not specified' }}
                    </p>
                </div>
            </div>
            
            @if($consultation->scheduled_date)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-xs font-semibold text-gray-600 uppercase mb-1 block">Scheduled Date</label>
                    <p class="text-gray-900 font-medium">
                        {{ \Carbon\Carbon::parse($consultation->scheduled_date)->format('F j, Y') }}
                    </p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 uppercase mb-1 block">Scheduled Time</label>
                    <p class="text-gray-900 font-medium">
                        {{ $consultation->scheduled_time ? \Carbon\Carbon::parse($consultation->scheduled_time)->format('g:i A') : 'Not specified' }}
                    </p>
                </div>
            </div>
            
            @php
                $scheduledDateTime = null;
                if ($consultation->status === 'Proposed' && $consultation->proposed_date && $consultation->proposed_time) {
                    $dateStr = \Carbon\Carbon::parse($consultation->proposed_date)->format('Y-m-d');
                    $timeStr = \Carbon\Carbon::parse($consultation->proposed_time)->format('H:i:s');
                    $scheduledDateTime = \Carbon\Carbon::parse($dateStr . ' ' . $timeStr);
                } elseif ($consultation->scheduled_date && $consultation->scheduled_time) {
                    $dateStr = \Carbon\Carbon::parse($consultation->scheduled_date)->format('Y-m-d');
                    $timeStr = \Carbon\Carbon::parse($consultation->scheduled_time)->format('H:i:s');
                    $scheduledDateTime = \Carbon\Carbon::parse($dateStr . ' ' . $timeStr);
                } elseif ($consultation->preferred_date && $consultation->preferred_time) {
                    $dateStr = \Carbon\Carbon::parse($consultation->preferred_date)->format('Y-m-d');
                    $timeStr = \Carbon\Carbon::parse($consultation->preferred_time)->format('H:i:s');
                    $scheduledDateTime = \Carbon\Carbon::parse($dateStr . ' ' . $timeStr);
                }
            @endphp
            
            @if($scheduledDateTime && in_array($consultation->status, ['Accepted', 'Pending', 'Proposed']))
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border-2 border-blue-300 mb-4">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <div class="text-xs font-semibold text-gray-600 uppercase mb-1">Your Consultation</div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $scheduledDateTime->format('F j, Y') }} at {{ $scheduledDateTime->format('g:i A') }}
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 border-2 border-blue-400 shadow-md min-w-[200px]">
                            <div class="text-center">
                                <div class="text-xs font-semibold text-blue-700 uppercase mb-2" id="clock-label-customer">
                                    @if($scheduledDateTime->isFuture())
                                        Time Remaining
                                    @elseif($scheduledDateTime->isPast())
                                        Time Elapsed
                                    @else
                                        Happening Now
                                    @endif
                                </div>
                                <div class="text-2xl font-bold font-mono mb-1" id="live-clock-customer">
                                    <span id="clock-time-customer" class="@if($scheduledDateTime->isFuture()) text-blue-700 @elseif($scheduledDateTime->isPast()) text-gray-600 @else text-green-600 @endif">--:--:--</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    @if($scheduledDateTime->isFuture())
                                        Until Consultation
                                    @elseif($scheduledDateTime->isPast())
                                        Since Consultation
                                    @else
                                        Live Now
                                    @endif
                                </div>
                                <input type="hidden" id="scheduled-time-customer" value="{{ $scheduledDateTime->timestamp }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @endif

            @if($consultation->meeting_link)
            <div>
                <label class="text-xs font-semibold text-gray-600 uppercase mb-1 block">Meeting Link</label>
                <a href="{{ $consultation->meeting_link }}" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Join Google Meet
                </a>
            </div>
            @endif

            @if(in_array($consultation->status, ['Pending', 'Proposed', 'Expired'], true) && $consultation->proposal_status !== 'pending')
            <div class="border-t border-gray-200 pt-4 mt-4 flex gap-3">
                <a href="{{ route('customer.consultations.edit', $consultation->id) }}"
                   class="inline-flex items-center justify-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Request
                </a>
                <form method="POST" action="{{ route('customer.consultations.cancel', $consultation->id) }}" class="inline-block"
                      onsubmit="return confirm('Are you sure you want to cancel this consultation?');">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel Consultation
                    </button>
                </form>
            </div>
            @endif

            @if($consultation->proposal_status === 'pending' && $consultation->proposed_date)
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-300 rounded-xl p-6 shadow-sm mt-4">
                <div class="flex items-start mb-4">
                    <div class="bg-blue-600 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-lg font-bold text-blue-900 mb-1">New Schedule Proposed</p>
                        <p class="text-sm text-blue-700">Your consultant has suggested a different time slot</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg p-4 mb-4 border border-blue-200">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-xs font-semibold text-gray-600 uppercase">Proposed Date & Time</span>
                    </div>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ \Carbon\Carbon::parse($consultation->proposed_date)->format('F j, Y') }} 
                        <span class="text-gray-600">at</span> 
                        {{ \Carbon\Carbon::parse($consultation->proposed_time)->format('g:i A') }}
                    </p>
                </div>
                
                <form method="POST" action="{{ route('customer.consultations.respond-proposal', $consultation->id) }}" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <button type="submit" name="proposal_response" value="accept" class="inline-flex items-center justify-center bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition shadow-md hover:shadow-lg font-medium flex-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Accept New Time
                    </button>
                    <button type="submit" name="proposal_response" value="decline" class="inline-flex items-center justify-center bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition shadow-md hover:shadow-lg font-medium flex-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Decline
                    </button>
                </form>
            </div>
            @endif

            @if($consultation->status === 'Completed')
                @if($consultation->consultation_summary)
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-3 mt-4">
                    <p class="font-semibold text-purple-900 mb-2">📄 Consultation Report Available</p>
                    @if(auth()->user()->hasSubscriptionFeature('report_export'))
                        <a href="{{ route('customer.consultations.report', $consultation->id) }}" target="_blank" class="inline-block bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 mt-2">
                            Download Report
                        </a>
                    @else
                        <p class="text-sm text-purple-700 mb-2 italic">Report viewing/exporting is not available in the Free Subscription.</p>
                        <a href="{{ route('customer.plans') }}" class="text-xs font-bold text-purple-600 hover:text-purple-800 uppercase tracking-widest">Upgrade to View Report →</a>
                    @endif
                </div>
                @endif
                
                @php
                    $hasRated = \App\Models\ConsultationRating::where('consultation_id', $consultation->id)
                        ->where('rater_id', Auth::id())
                        ->where('rater_type', 'customer')
                        ->exists();
                @endphp
                @if(!$hasRated)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-4">
                    <p class="font-semibold text-yellow-900 mb-2">⭐ Rate Your Consultant</p>
                    @if(auth()->user()->hasSubscriptionFeature('rating'))
                        <a href="{{ route('customer.consultations.rate', $consultation->id) }}" class="inline-block bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 mt-2">
                            Submit Rating
                        </a>
                    @else
                        <p class="text-sm text-yellow-700 mb-2 italic">Rating and feedback features are not available in the Free Subscription.</p>
                        <a href="{{ route('customer.plans') }}" class="text-xs font-bold text-yellow-600 hover:text-yellow-800 uppercase tracking-widest">Upgrade to Rate Expert →</a>
                    @endif
                </div>
                @else
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mt-4">
                    <p class="text-green-800">✅ You have rated this consultation</p>
                </div>
                @endif
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
                        <h3 class="text-lg font-bold text-white">Messages</h3>
                        <p class="text-blue-100 text-sm">Chat with your consultant</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="chat-messages-{{ $consultation->id }}" class="p-6 bg-gray-50" style="min-height: 400px; max-height: 600px; overflow-y: auto;">
            <div class="space-y-4">
                @if($messages->count() > 0)
                    @foreach($messages as $msg)
                        @if($msg->sender_type === 'customer')
                            <!-- Customer Message (Left Side) -->
                            <div class="flex items-start justify-start">
                                <div class="flex items-start space-x-3 max-w-[75%]">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center flex-shrink-0 shadow-md">
                                        <span class="text-white font-semibold text-sm">{{ substr($msg->sender->name ?? 'You', 0, 1) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm border border-gray-200">
                                            <div class="flex items-center mb-1">
                                                <span class="text-sm font-semibold text-gray-900">You</span>
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
                        <p class="text-gray-500 text-sm mt-1">Start a conversation with your consultant</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Message Input Form -->
        <div class="border-t border-gray-200 bg-white p-4">
            <form id="message-form-{{ $consultation->id }}" onsubmit="sendMessage(event, {{ $consultation->id }})" class="flex gap-2">
                @csrf
                <input type="text" 
                       id="message-input-{{ $consultation->id }}"
                       name="message" 
                       placeholder="Type your message..." 
                       required
                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-scroll chat to bottom on load
    document.addEventListener('DOMContentLoaded', function() {
        const chatContainer = document.getElementById('chat-messages-{{ $consultation->id }}');
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    });

    function sendMessage(event, consultationId) {
        event.preventDefault();
        
        const form = document.getElementById('message-form-' + consultationId);
        const input = document.getElementById('message-input-' + consultationId);
        const message = input.value.trim();
        
        if (!message) return;
        
        const formData = new FormData(form);
        const chatContainer = document.getElementById('chat-messages-' + consultationId);
        const submitButton = form.querySelector('button[type="submit"]');
        
        // Disable form while sending
        submitButton.disabled = true;
        submitButton.innerHTML = '<svg class="animate-spin h-5 w-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token');
        
        if (!csrfToken) {
            alert('CSRF token not found. Please refresh the page and try again.');
            submitButton.disabled = false;
            submitButton.innerHTML = '<svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>';
            return;
        }
        
        const messagesUrl = '{{ route("customer.consultations.messages.store", ":id") }}'.replace(':id', consultationId);
        fetch(messagesUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData
        })
        .then(async response => {
            const contentType = response.headers.get('content-type');
            let data;
            
            if (contentType && contentType.includes('application/json')) {
                data = await response.json();
            } else {
                const text = await response.text();
                throw new Error(`Server returned: ${text.substring(0, 200)}`);
            }
            
            if (!response.ok) {
                throw new Error(data.error || data.message || `HTTP error! status: ${response.status}`);
            }
            
            return data;
        })
        .then(data => {
            if (data.success) {
                input.value = '';
                loadMessages(consultationId);
            } else {
                throw new Error(data.error || data.message || 'Failed to send message. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
            const errorMessage = error.message || 'Failed to send message. Please try again.';
            alert(errorMessage);
        })
        .finally(() => {
            // Always re-enable the button
            submitButton.disabled = false;
            submitButton.innerHTML = '<svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>';
            // Focus back on input for next message
            input.focus();
        });
    }

    function loadMessages(consultationId) {
        const messagesUrl = '{{ route("customer.consultations.messages.index", ":id") }}'.replace(':id', consultationId);
        fetch(messagesUrl)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.messages) {
                    const chatContainer = document.getElementById('chat-messages-' + consultationId);
                    if (chatContainer) {
                        const messagesHtml = data.messages.map(msg => {
                            const isCustomer = msg.sender_type === 'customer';
                            const senderName = msg.sender?.name || (isCustomer ? 'You' : 'Consultant');
                            const senderInitial = senderName.charAt(0).toUpperCase();
                            const messageTime = new Date(msg.created_at).toLocaleDateString('en-US', { 
                                month: 'short', 
                                day: 'numeric', 
                                hour: 'numeric', 
                                minute: '2-digit',
                                hour12: true 
                            });
                            
                            if (isCustomer) {
                                return `
                                    <div class="flex items-start justify-start">
                                        <div class="flex items-start space-x-3 max-w-[75%]">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center flex-shrink-0 shadow-md">
                                                <span class="text-white font-semibold text-sm">${senderInitial}</span>
                                            </div>
                                            <div class="flex-1">
                                                <div class="bg-white rounded-2xl rounded-tl-none px-4 py-3 shadow-sm border border-gray-200">
                                                    <div class="flex items-center mb-1">
                                                        <span class="text-sm font-semibold text-gray-900">You</span>
                                                        <span class="mx-2 text-gray-400">•</span>
                                                        <span class="text-xs text-gray-500">${messageTime}</span>
                                                    </div>
                                                    <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">${msg.message}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            } else {
                                return `
                                    <div class="flex items-start justify-end">
                                        <div class="flex items-start space-x-3 max-w-[75%] flex-row-reverse">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center flex-shrink-0 shadow-md">
                                                <span class="text-white font-semibold text-sm">${senderInitial}</span>
                                            </div>
                                            <div class="flex-1">
                                                <div class="bg-blue-600 text-white rounded-2xl rounded-tr-none px-4 py-3 shadow-md">
                                                    <div class="flex items-center mb-1">
                                                        <span class="text-sm font-semibold text-blue-100">${senderName}</span>
                                                        <span class="mx-2 text-blue-300">•</span>
                                                        <span class="text-xs text-blue-200">${messageTime}</span>
                                                    </div>
                                                    <p class="text-white leading-relaxed whitespace-pre-wrap">${msg.message}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }
                        }).join('');
                        
                        chatContainer.querySelector('.space-y-4').innerHTML = messagesHtml;
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                    }
                }
            })
            .catch(error => {
                console.error('Error loading messages:', error);
            });
    }

    // Auto-refresh messages every 5 seconds
    setInterval(() => {
        loadMessages({{ $consultation->id }});
    }, 5000);
    
    // Live clock for customer consultation detail page
    function updateCustomerClock() {
        const scheduledTimeInput = document.getElementById('scheduled-time-customer');
        if (!scheduledTimeInput) return;
        
        const scheduledTimestamp = parseInt(scheduledTimeInput.value);
        const scheduledTime = new Date(scheduledTimestamp * 1000);
        const now = new Date();
        const diff = scheduledTime - now;
        
        const clockElement = document.getElementById('clock-time-customer');
        const labelElement = document.getElementById('clock-label-customer');
        
        if (!clockElement) return;
        
        const absDiff = Math.abs(diff);
        const days = Math.floor(absDiff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((absDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((absDiff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((absDiff % (1000 * 60)) / 1000);
        
        let timeString = '';
        let label = '';
        
        if (diff > 0) {
            // Future consultation - countdown
            label = 'Time Remaining';
            if (days > 0) {
                timeString = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            } else if (hours > 0) {
                timeString = `${hours}h ${minutes}m ${seconds}s`;
            } else if (minutes > 0) {
                timeString = `${minutes}m ${seconds}s`;
            } else {
                timeString = `${seconds}s`;
            }
            clockElement.className = 'text-2xl font-bold font-mono text-blue-700';
        } else if (diff < 0) {
            // Past consultation - elapsed time
            label = 'Time Elapsed';
            if (days > 0) {
                timeString = `${days}d ${hours}h ${minutes}m ${seconds}s ago`;
            } else if (hours > 0) {
                timeString = `${hours}h ${minutes}m ${seconds}s ago`;
            } else if (minutes > 0) {
                timeString = `${minutes}m ${seconds}s ago`;
            } else {
                timeString = `${seconds}s ago`;
            }
            clockElement.className = 'text-2xl font-bold font-mono text-gray-600';
        } else {
            // Happening now
            label = 'Happening Now';
            timeString = 'NOW';
            clockElement.className = 'text-2xl font-bold font-mono text-green-600';
        }
        
        clockElement.textContent = timeString;
        if (labelElement) {
            labelElement.textContent = label;
        }
    }
    
    // Update customer clock immediately and then every second
    if (document.getElementById('scheduled-time-customer')) {
        updateCustomerClock();
        setInterval(updateCustomerClock, 1000);
    }
</script>
@endsection

