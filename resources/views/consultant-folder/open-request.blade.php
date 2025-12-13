@extends('consultant-folder.layout')

@section('title', 'Open Request')
@section('page-title', 'Open Consultation Request')

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('consultant.consultations') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white rounded-lg border border-gray-300 hover:bg-gray-50 hover:text-gray-900 transition shadow-sm hover:shadow">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Inbox
            </a>
        </div>

        <!-- Header Card -->
        <div class="bg-gradient-to-br from-white to-blue-50 rounded-xl shadow-lg border border-gray-200 p-8 mb-6">
            <div class="flex items-start justify-between mb-6">
                <div class="flex-1">
                    <div class="flex items-center mb-3">
                        <div class="bg-blue-100 p-3 rounded-xl mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $consultation->topic }}</h2>
                            <div class="flex items-center mt-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                From: <span class="font-medium text-gray-900 ml-1">{{ $consultation->customer->name ?? 'Unknown' }}</span>
                            </div>
                            <div class="flex items-center mt-1 text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Requested: {{ $consultation->created_at->format('M j, Y g:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Request Section -->
            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-6 border-2 border-purple-200 mb-6">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-600 p-3 rounded-xl mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Booking Request</h3>
                        <p class="text-sm text-gray-600">Customer consultation booking details</p>
                        @if(isset($customerSubscription) && $customerSubscription && $customerSubscription->plan_type === 'free_trial')
                            <p class="text-xs font-semibold text-red-600 mt-1">Note: Free trial valid only 20 minutes.</p>
                        @endif
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
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                </div>
            </div>

            <!-- Chat Messages Section -->
            @php
                $messages = collect([]);
                if (\Illuminate\Support\Facades\Schema::hasTable('consultation_messages')) {
                    $messages = $consultation->messages()->with('sender')->get();
                }
            @endphp
            
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
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
                                <p class="text-blue-100 text-sm">Chat with the customer</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="chat-messages-{{ $consultation->id }}" class="p-6 bg-gray-50" style="min-height: 300px; max-height: 500px; overflow-y: auto;">
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
                                                <span class="text-white font-semibold text-sm">{{ substr($msg->sender->name ?? 'You', 0, 1) }}</span>
                                            </div>
                                            <div class="flex-1">
                                                <div class="bg-blue-600 text-white rounded-2xl rounded-tr-none px-4 py-3 shadow-md">
                                                    <div class="flex items-center mb-1">
                                                        <span class="text-sm font-semibold text-blue-100">You</span>
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
                                <p class="text-gray-500 text-sm mt-1">Start a conversation with the customer</p>
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

            <div class="bg-white rounded-lg p-5 border border-gray-200">
                <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Customer Preferred Schedule
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-xs font-medium text-gray-600 mb-1 uppercase">Date</span>
                        <p class="text-gray-900 font-semibold">
                            {{ $consultation->preferred_date ? \Carbon\Carbon::parse($consultation->preferred_date)->format('F j, Y') : 'Not specified' }}
                        </p>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-gray-600 mb-1 uppercase">Time</span>
                        <p class="text-gray-900 font-semibold">
                            {{ $consultation->preferred_time ? \Carbon\Carbon::parse($consultation->preferred_time)->format('g:i A') : 'Not specified' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

            @if($consultation->status === 'Accepted')
                @php
                    $scheduledDateTime = null;
                    if ($consultation->scheduled_date && $consultation->scheduled_time) {
                        $dateStr = $consultation->scheduled_date instanceof \Carbon\Carbon 
                            ? $consultation->scheduled_date->format('Y-m-d') 
                            : \Carbon\Carbon::parse($consultation->scheduled_date)->format('Y-m-d');
                        $timeStr = is_string($consultation->scheduled_time) 
                            ? $consultation->scheduled_time 
                            : \Carbon\Carbon::parse($consultation->scheduled_time)->format('H:i:s');
                        $scheduledDateTime = \Carbon\Carbon::parse($dateStr . ' ' . $timeStr);
                    } elseif ($consultation->preferred_date && $consultation->preferred_time) {
                        $dateStr = $consultation->preferred_date instanceof \Carbon\Carbon 
                            ? $consultation->preferred_date->format('Y-m-d') 
                            : \Carbon\Carbon::parse($consultation->preferred_date)->format('Y-m-d');
                        $timeStr = is_string($consultation->preferred_time) 
                            ? $consultation->preferred_time 
                            : \Carbon\Carbon::parse($consultation->preferred_time)->format('H:i:s');
                        $scheduledDateTime = \Carbon\Carbon::parse($dateStr . ' ' . $timeStr);
                    }
                @endphp
                
                <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-xl p-6">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="bg-green-600 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="font-semibold text-green-900 text-lg">✅ Scheduled Consultation</p>
                            </div>
                            @if($consultation->scheduled_date)
                                <p class="text-green-800 mb-1">
                                    <strong>Date &amp; Time:</strong>
                                    {{ \Carbon\Carbon::parse($consultation->scheduled_date)->format('M j, Y') }}
                                    at
                                    {{ \Carbon\Carbon::parse($consultation->scheduled_time)->format('g:i A') }}
                                </p>
                            @elseif($consultation->preferred_date)
                                <p class="text-green-800 mb-1">
                                    <strong>Preferred Date &amp; Time:</strong>
                                    {{ \Carbon\Carbon::parse($consultation->preferred_date)->format('M j, Y') }}
                                    at
                                    {{ \Carbon\Carbon::parse($consultation->preferred_time)->format('g:i A') }}
                                </p>
                            @endif
                        </div>
                        
                        @if($scheduledDateTime)
                            <div class="bg-white rounded-lg p-4 border-2 border-green-400 shadow-md min-w-[200px]">
                                <div class="text-center">
                                    <div class="text-xs font-semibold text-green-700 uppercase mb-2" id="clock-label-detail">
                                        @if($scheduledDateTime->isFuture())
                                            Time Remaining
                                        @elseif($scheduledDateTime->isPast())
                                            Time Elapsed
                                        @else
                                            Happening Now
                                        @endif
                                    </div>
                                    <div class="text-2xl font-bold font-mono mb-1" id="live-clock-detail">
                                        <span id="clock-time-detail" class="@if($scheduledDateTime->isFuture()) text-blue-700 @elseif($scheduledDateTime->isPast()) text-gray-600 @else text-green-600 @endif">--:--:--</span>
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
                                    <input type="hidden" id="scheduled-time-detail" value="{{ $scheduledDateTime->timestamp }}">
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-3">
                        @if($consultation->meeting_link)
                            <div class="mb-3">
                                <p class="text-sm font-medium text-green-900 mb-2">Meeting Link Generated:</p>
                                <a href="{{ $consultation->meeting_link }}"
                                   target="_blank"
                                   class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    🔗 Join Google Meet
                                </a>
                            </div>
                        @elseif($consultation->scheduled_date || $consultation->preferred_date)
                            <form method="POST" action="{{ route('consultant.consultations.generate-meet-link', $consultation->id) }}" class="inline-block">
                                @csrf
                                <button type="submit" 
                                        class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                                        onclick="return confirm('Generate Google Meet link? The client will be automatically notified with the meeting link.');">
                                    🔗 Generate Google Meet Link
                                </button>
                            </form>
                            <p class="text-xs text-gray-600 mt-2">
                                <strong>Note:</strong> Clicking this button will generate a meeting link and automatically send a message to the client with the link.
                            </p>
                        @else
                            <p class="text-sm text-gray-600">Please schedule a date and time first before generating a meeting link.</p>
                        @endif
                    </div>
                </div>
            @endif

            @if(in_array($consultation->status, ['Pending', 'Proposed']))
                <form method="POST" action="{{ route('consultant.consultations.respond', $consultation->id) }}" class="space-y-4" id="responseForm">
                    @csrf

                    @if($errors->has('conflict'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <strong>⚠️ Schedule Conflict:</strong> {{ $errors->first('conflict') }}
                        </div>
                    @endif

                    <div class="bg-white rounded-xl p-6 border border-gray-200 mb-6">
                        <label class="block text-sm font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Response Type
                        </label>
                        <div class="space-y-3">
                            <label class="flex items-start p-4 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-green-500 hover:bg-green-50 transition-all group" id="accept-option">
                                <input type="radio" name="response_type" value="accept" class="mt-1 mr-4 w-5 h-5 text-green-600 focus:ring-green-500" required>
                                <div class="flex-1">
                                    <div class="flex items-center mb-1">
                                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-green-700 font-semibold text-base">Accept (Same Date & Time)</span>
                                    </div>
                                    <p class="text-sm text-gray-600 ml-7">Confirm the consultation using the client's original preferred date and time.</p>
                                </div>
                            </label>
                            <label class="flex items-start p-4 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all group" id="propose-option">
                                <input type="radio" name="response_type" value="propose" class="mt-1 mr-4 w-5 h-5 text-blue-600 focus:ring-blue-500" required>
                                <div class="flex-1">
                                    <div class="flex items-center mb-1">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        <span class="text-blue-700 font-semibold text-base">Propose New Schedule</span>
                                    </div>
                                    <p class="text-sm text-gray-600 ml-7">Suggest a different date and time that works better for you.</p>
                                </div>
                            </label>
                            <label class="flex items-start p-4 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-red-500 hover:bg-red-50 transition-all group">
                                <input type="radio" name="response_type" value="reject" class="mt-1 mr-4 w-5 h-5 text-red-600 focus:ring-red-500" required>
                                <div class="flex-1">
                                    <div class="flex items-center mb-1">
                                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span class="text-red-700 font-semibold text-base">Reject Request</span>
                                    </div>
                                    <p class="text-sm text-gray-600 ml-7">Decline this consultation request. Please provide a reason in your message.</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl p-6 border border-gray-200">
                        <label class="block text-sm font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Message to Client (Optional)
                        </label>
                        <textarea 
                            name="response_message" 
                            rows="5" 
                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all placeholder-gray-400 text-gray-700 shadow-sm" 
                            placeholder="Type a professional message to the client here. You can provide additional context, ask clarifying questions, or explain your decision..."></textarea>
                        <p class="mt-2 text-xs text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            This message will be sent to the client along with your response.
                        </p>
                    </div>

                    <!-- Accept Schedule Box (read-only preview of chosen date/time) -->
                    <div id="accept-schedule-box" class="hidden bg-green-50 rounded-xl p-6 border-2 border-green-200 mb-6">
                        <label class="block text-sm font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Scheduled Date & Time (Confirmation)
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="block text-xs font-medium text-gray-600 mb-2 uppercase">Date</span>
                                <div class="px-4 py-3 border-2 border-gray-300 rounded-lg bg-white text-gray-900 font-semibold">
                                    {{ $consultation->preferred_date ? \Carbon\Carbon::parse($consultation->preferred_date)->format('F j, Y') : 'Not specified' }}
                                </div>
                            </div>
                            <div>
                                <span class="block text-xs font-medium text-gray-600 mb-2 uppercase">Time</span>
                                <div class="px-4 py-3 border-2 border-gray-300 rounded-lg bg-white text-gray-900 font-semibold">
                                    {{ $consultation->preferred_time ? \Carbon\Carbon::parse($consultation->preferred_time)->format('g:i A') : 'Not specified' }}
                                </div>
                            </div>
                        </div>
                        <div class="bg-green-100 border border-green-200 rounded-lg p-3 mt-4 flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm text-green-800">This date and time will be confirmed with the client upon submission.</p>
                        </div>
                    </div>

                    <!-- Propose Schedule Box -->
                    <div id="propose-schedule-box" class="hidden bg-blue-50 rounded-xl p-6 border-2 border-blue-200 mb-6">
                        <label class="block text-sm font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Proposed Schedule
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date <span class="text-red-500">*</span></label>
                                <input type="date" name="proposed_date" id="proposed_date" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" min="{{ date('Y-m-d') }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Time <span class="text-red-500">*</span></label>
                                <input type="time" name="proposed_time" id="proposed_time" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                        </div>
                        <div class="bg-blue-100 border border-blue-200 rounded-lg p-3 flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm text-blue-800">The client will be notified and can accept or decline your proposed time.</p>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('consultant.consultations') }}" class="inline-flex items-center px-5 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md hover:shadow-lg font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Submit Response
                        </button>
                    </div>
                </form>
            @elseif($consultation->status === 'Accepted')
                <!-- Completion Section for Accepted Consultations -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border-2 border-green-200 mb-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-600 p-3 rounded-xl mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Complete Consultation</h3>
                            <p class="text-sm text-gray-600">Mark this consultation as completed after the session</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg p-5 border border-green-200 space-y-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    Once you mark this consultation as <strong>Completed</strong>, you'll be able to:
                                </p>
                                <ul class="mt-2 space-y-1.5 text-sm text-gray-600 ml-4">
                                    <li class="flex items-start">
                                        <span class="text-green-600 mr-2">✓</span>
                                        <span>Create a detailed consultation report with summary and recommendations</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-green-600 mr-2">✓</span>
                                        <span>Customer can rate and provide feedback</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-green-600 mr-2">✓</span>
                                        <span>Generate a PDF report document</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        @if($consultation->scheduled_date)
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm font-semibold text-blue-900">Scheduled Session</span>
                            </div>
                            <p class="text-sm text-blue-800">
                                {{ \Carbon\Carbon::parse($consultation->scheduled_date)->format('F j, Y') }}
                                @if($consultation->scheduled_time)
                                    at {{ \Carbon\Carbon::parse($consultation->scheduled_time)->format('g:i A') }}
                                @endif
                            </p>
                            @php
                                $scheduledDateForCheck = $consultation->scheduled_date instanceof \Carbon\Carbon 
                                    ? $consultation->scheduled_date 
                                    : \Carbon\Carbon::parse($consultation->scheduled_date);
                                $scheduledDateTimeForCheck = null;
                                if ($consultation->scheduled_date && $consultation->scheduled_time) {
                                    $dateStr = $consultation->scheduled_date instanceof \Carbon\Carbon 
                                        ? $consultation->scheduled_date->format('Y-m-d') 
                                        : \Carbon\Carbon::parse($consultation->scheduled_date)->format('Y-m-d');
                                    $timeStr = is_string($consultation->scheduled_time) 
                                        ? $consultation->scheduled_time 
                                        : \Carbon\Carbon::parse($consultation->scheduled_time)->format('H:i:s');
                                    $scheduledDateTimeForCheck = \Carbon\Carbon::parse($dateStr . ' ' . $timeStr);
                                }
                            @endphp
                            @if($scheduledDateForCheck->isPast() && 
                                (!$consultation->scheduled_time || ($scheduledDateTimeForCheck && $scheduledDateTimeForCheck->isPast())))
                                <p class="text-xs text-green-700 font-medium mt-2">✓ Session date has passed - Ready to mark as completed</p>
                            @else
                                <p class="text-xs text-orange-700 font-medium mt-2">⏰ Session is scheduled for a future date</p>
                            @endif
                        </div>
                        @endif
                        
                        <form method="POST" action="{{ route('consultant.consultations.complete', $consultation->id) }}" 
                              onsubmit="return confirm('Are you sure you want to mark this consultation as completed? After completion, you can create a detailed report.');">
                            @csrf
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition shadow-lg hover:shadow-xl font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Mark Consultation as Completed
                            </button>
                        </form>
                        
                        <p class="text-xs text-gray-500 text-center mt-2">
                            After completion, you'll be redirected to create a consultation report
                        </p>
                    </div>
                </div>
            @else
                <div class="mt-4 rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <p class="text-sm text-gray-700">
                        This consultation has already been <strong>{{ $consultation->status }}</strong>.
                        @if($consultation->status === 'Completed')
                            @if($consultation->consultation_summary)
                                <a href="{{ route('consultant.consultations.report.view', $consultation->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium ml-2" target="_blank">
                                    View Report →
                                </a>
                            @else
                                <a href="{{ route('consultant.consultations.report', $consultation->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium ml-2">
                                    Create Report →
                                </a>
                            @endif
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[name="response_type"]');
        const acceptBox = document.getElementById('accept-schedule-box');
        const proposeBox = document.getElementById('propose-schedule-box');
        const acceptOption = document.getElementById('accept-option');
        const proposeOption = document.getElementById('propose-option');
        const proposedDate = document.getElementById('proposed_date');
        const proposedTime = document.getElementById('proposed_time');
        const form = document.getElementById('responseForm');
        
        function updateRequiredFields() {
            const selectedValue = document.querySelector('input[name="response_type"]:checked')?.value;
            
            // Remove required from all fields first
            proposedDate.removeAttribute('required');
            proposedTime.removeAttribute('required');
            
            // Add required only if propose is selected
            if (selectedValue === 'propose') {
                proposedDate.setAttribute('required', 'required');
                proposedTime.setAttribute('required', 'required');
            }
        }
        
        radios.forEach(r => {
            r.addEventListener('change', function() {
                // Remove all active states first
                document.querySelectorAll('label[id$="-option"]').forEach(label => {
                    label.classList.remove('border-green-500', 'bg-green-50', 'border-blue-500', 'bg-blue-50', 'border-red-500', 'bg-red-50', 'border-gray-300');
                    label.classList.add('border-gray-300');
                });
                
                if (this.value === 'accept') {
                    acceptBox.classList.remove('hidden');
                    proposeBox.classList.add('hidden');
                    acceptOption.classList.remove('border-gray-300');
                    acceptOption.classList.add('border-green-500', 'bg-green-50');
                } else if (this.value === 'propose') {
                    proposeBox.classList.remove('hidden');
                    acceptBox.classList.add('hidden');
                    proposeOption.classList.remove('border-gray-300');
                    proposeOption.classList.add('border-blue-500', 'bg-blue-50');
                } else if (this.value === 'reject') {
                    acceptBox.classList.add('hidden');
                    proposeBox.classList.add('hidden');
                    const rejectOption = document.querySelector('label:has(input[value="reject"])');
                    if (rejectOption) {
                        rejectOption.classList.remove('border-gray-300');
                        rejectOption.classList.add('border-red-500', 'bg-red-50');
                    }
                }
                updateRequiredFields();
            });
        });
        
        // Handle form submission
        form.addEventListener('submit', function(e) {
            const selectedValue = document.querySelector('input[name="response_type"]:checked')?.value;
            
            if (selectedValue === 'propose') {
                if (!proposedDate.value || !proposedTime.value) {
                    e.preventDefault();
                    alert('Please fill in both the proposed date and time.');
                    return false;
                }
            }
        });
        
        // Initial update
        updateRequiredFields();
        
        // Auto-scroll chat to bottom on load
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
        
        // Disable form while sending
        form.querySelector('button[type="submit"]').disabled = true;
        
        fetch('{{ route("consultant.consultations.messages.store", ":id") }}'.replace(':id', consultationId), {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.error || 'Failed to send message');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                input.value = '';
                loadMessages(consultationId);
            } else {
                alert(data.error || 'Failed to send message. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'Failed to send message. Please try again.');
        })
        .finally(() => {
            form.querySelector('button[type="submit"]').disabled = false;
        });
    }
    
    function loadMessages(consultationId) {
        fetch('{{ route("consultant.consultations.messages.index", ":id") }}'.replace(':id', consultationId))
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const chatContainer = document.getElementById('chat-messages-' + consultationId);
                    const messagesDiv = chatContainer.querySelector('.space-y-4');
                    
                    messagesDiv.innerHTML = '';
                    
                    if (data.messages && data.messages.length > 0) {
                        data.messages.forEach(msg => {
                            const isCustomer = msg.sender_type === 'customer';
                            const senderName = isCustomer ? (msg.sender?.name || 'Customer') : 'You';
                            const senderInitial = senderName.charAt(0).toUpperCase();
                            const time = new Date(msg.created_at).toLocaleString('en-US', { 
                                month: 'short', 
                                day: 'numeric', 
                                hour: 'numeric', 
                                minute: '2-digit' 
                            });
                            
                            const messageHTML = `
                                <div class="flex items-start justify-${isCustomer ? 'start' : 'end'}">
                                    <div class="flex items-start space-x-3 max-w-[75%] ${isCustomer ? '' : 'flex-row-reverse'}">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-${isCustomer ? 'green' : 'blue'}-400 to-${isCustomer ? 'green' : 'blue'}-600 flex items-center justify-center flex-shrink-0 shadow-md">
                                            <span class="text-white font-semibold text-sm">${senderInitial}</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="bg-${isCustomer ? 'white' : 'blue-600'} ${isCustomer ? 'rounded-2xl rounded-tl-none border border-gray-200 shadow-sm' : 'rounded-2xl rounded-tr-none shadow-md text-white'} px-4 py-3">
                                                <div class="flex items-center mb-1">
                                                    <span class="text-sm font-semibold ${isCustomer ? 'text-gray-900' : 'text-blue-100'}">${senderName}</span>
                                                    <span class="mx-2 ${isCustomer ? 'text-gray-400' : 'text-blue-300'}">•</span>
                                                    <span class="text-xs ${isCustomer ? 'text-gray-500' : 'text-blue-200'}">${time}</span>
                                                </div>
                                                <p class="${isCustomer ? 'text-gray-800' : 'text-white'} leading-relaxed whitespace-pre-wrap">${msg.message}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            
                            messagesDiv.innerHTML += messageHTML;
                        });
                    } else {
                        messagesDiv.innerHTML = `
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p class="text-gray-600 font-medium">No messages yet</p>
                                <p class="text-gray-500 text-sm mt-1">Start a conversation with the customer</p>
                            </div>
                        `;
                    }
                    
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
            })
            .catch(error => console.error('Error loading messages:', error));
    }
    
    // Live clock for consultation detail page
    function updateDetailClock() {
        const scheduledTimeInput = document.getElementById('scheduled-time-detail');
        if (!scheduledTimeInput) return;
        
        const scheduledTimestamp = parseInt(scheduledTimeInput.value);
        const scheduledTime = new Date(scheduledTimestamp * 1000);
        const now = new Date();
        const diff = scheduledTime - now;
        
        const clockElement = document.getElementById('clock-time-detail');
        const labelElement = document.getElementById('clock-label-detail');
        
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
                timeString = `${days}d ${hours}h ${minutes}m`;
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
                timeString = `${days}d ${hours}h ${minutes}m ago`;
            } else if (hours > 0) {
                timeString = `${hours}h ${minutes}m ago`;
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
    
    // Update detail clock immediately and then every second
    if (document.getElementById('scheduled-time-detail')) {
        updateDetailClock();
        setInterval(updateDetailClock, 1000);
    }
</script>
@endsection

