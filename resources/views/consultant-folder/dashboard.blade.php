@extends('consultant-folder.layout')

@section('title', 'Consultant Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Welcome Section with Live Clock -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-lg border border-blue-200 p-6 mb-6">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                    <p class="text-gray-600">You're now verified and ready to help clients. Manage appointments, respond to inquiries, and grow your consulting business.</p>
                </div>
                
                <!-- Live Clock Widget -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-2 border-blue-300 min-w-[280px]">
                    <div class="text-center">
                        <div class="flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Current Time</span>
                        </div>
                        <div id="live-clock" class="text-4xl font-bold text-gray-900 mb-2 font-mono">
                            <span id="clock-time">--:--:--</span>
                        </div>
                        <div id="live-date" class="text-sm text-gray-600 font-medium">
                            <span id="clock-date">Loading...</span>
                        </div>
                        <div id="live-day" class="text-xs text-gray-500 mt-1">
                            <span id="clock-day">--</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">{{ $stats['pending_consultations'] ?? 0 }}</div>
                <div class="text-sm text-blue-800">Pending Requests</div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">{{ $stats['accepted_consultations'] ?? 0 }}</div>
                <div class="text-sm text-green-800">Accepted</div>
            </div>
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2">{{ $stats['completed_consultations'] ?? 0 }}</div>
                <div class="text-sm text-purple-800">Completed</div>
            </div>
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-6 text-center">
                <div class="text-3xl font-bold text-orange-600 mb-2">{{ $stats['total_earnings'] ?? 0 }}</div>
                <div class="text-sm text-orange-800">Total Earnings</div>
            </div>
        </div>

        <!-- Main Widgets -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Consultations -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">Recent Consultations</h2>
                    <a href="{{ route('consultant.consultations') }}" class="text-blue-600 hover:underline text-sm">View All</a>
                </div>
                <div class="space-y-3">
                    @forelse($recent_consultations ?? [] as $consultation)
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
                        
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 hover:border-blue-300 transition-colors">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">{{ $consultation->customer->name ?? 'Unknown Customer' }}</div>
                                    <div class="text-sm text-gray-600">{{ $consultation->topic }}</div>
                                    @if($consultation->status === 'Completed' && $consultation->client_readiness_rating)
                                        <div class="flex items-center mt-1">
                                            <span class="text-xs text-gray-500 mr-1">Readiness:</span>
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $consultation->client_readiness_rating)
                                                    <span class="text-yellow-500 text-xs">⭐</span>
                                                @else
                                                    <span class="text-gray-300 text-xs">☆</span>
                                                @endif
                                            @endfor
                                        </div>
                                    @endif
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full ml-2
                                    @if($consultation->status === 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif($consultation->status === 'Accepted') bg-green-100 text-green-800
                                    @elseif($consultation->status === 'Completed') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $consultation->status }}
                                </span>
                            </div>
                            
                            @if($scheduledDateTime && in_array($consultation->status, ['Accepted', 'Pending', 'Proposed']))
                                <div class="mt-2 pt-2 border-t border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center text-xs text-gray-600">
                                            <svg class="w-3 h-3 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ $scheduledDateTime->format('M j, Y') }} at {{ $scheduledDateTime->format('g:i A') }}</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xs font-semibold text-blue-600 uppercase" id="clock-label-dashboard-{{ $consultation->id }}">
                                                @if($scheduledDateTime->isFuture())
                                                    Time Remaining
                                                @elseif($scheduledDateTime->isPast())
                                                    Time Elapsed
                                                @else
                                                    Happening Now
                                                @endif
                                            </div>
                                            <div class="text-sm font-bold text-blue-700 font-mono" id="live-clock-dashboard-{{ $consultation->id }}">
                                                <span id="clock-time-dashboard-{{ $consultation->id }}" class="@if($scheduledDateTime->isFuture()) text-blue-700 @elseif($scheduledDateTime->isPast()) text-gray-600 @else text-green-600 @endif">--:--:--</span>
                                            </div>
                                            <input type="hidden" id="scheduled-time-dashboard-{{ $consultation->id }}" value="{{ $scheduledDateTime->timestamp }}">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p>No consultations yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('consultant.consultations') }}" 
                       class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <div>
                            <div class="font-medium text-gray-900">View All Consultations</div>
                            <div class="text-sm text-gray-600">Manage your consultation requests</div>
                        </div>
                    </a>
                    <a href="{{ route('consultant.respond') }}" 
                       class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <div class="font-medium text-gray-900">Respond to Requests</div>
                            <div class="text-sm text-gray-600">Accept or reject consultation requests</div>
                        </div>
                    </a>
                    <a href="{{ route('consultant.profile.manage') }}" 
                       class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                        <svg class="w-6 h-6 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div>
                            <div class="font-medium text-gray-900">Update Profile</div>
                            <div class="text-sm text-gray-600">Manage your consultant profile</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Clock Script -->
    <script>
        function updateClock() {
            const now = new Date();
            
            // Get time components
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            // Format time (12-hour format with AM/PM)
            let hours12 = now.getHours() % 12;
            if (hours12 === 0) hours12 = 12;
            const ampm = now.getHours() >= 12 ? 'PM' : 'AM';
            const time12Hour = `${String(hours12).padStart(2, '0')}:${minutes}:${seconds} ${ampm}`;
            
            // 24-hour format
            const time24Hour = `${hours}:${minutes}:${seconds}`;
            
            // Update time display
            document.getElementById('clock-time').textContent = time24Hour;
            
            // Get date components
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 
                          'July', 'August', 'September', 'October', 'November', 'December'];
            
            const dayName = days[now.getDay()];
            const monthName = months[now.getMonth()];
            const date = now.getDate();
            const year = now.getFullYear();
            
            // Update date display
            document.getElementById('clock-date').textContent = `${monthName} ${date}, ${year}`;
            document.getElementById('clock-day').textContent = dayName;
        }
        
        // Update clock immediately
        updateClock();
        
        // Update clock every second
        setInterval(updateClock, 1000);
        
        // Live clocks for Recent Consultations
        function updateDashboardConsultationClocks() {
            document.querySelectorAll('[id^="scheduled-time-dashboard-"]').forEach(function(input) {
                const consultationId = input.id.replace('scheduled-time-dashboard-', '');
                const scheduledTimestamp = parseInt(input.value);
                const scheduledTime = new Date(scheduledTimestamp * 1000);
                const now = new Date();
                const diff = scheduledTime - now;
                
                const clockElement = document.getElementById('clock-time-dashboard-' + consultationId);
                const labelElement = document.getElementById('clock-label-dashboard-' + consultationId);
                
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
                        timeString = `${days}d ${hours}h`;
                    } else if (hours > 0) {
                        timeString = `${hours}h ${minutes}m`;
                    } else if (minutes > 0) {
                        timeString = `${minutes}m ${seconds}s`;
                    } else {
                        timeString = `${seconds}s`;
                    }
                    clockElement.className = 'text-sm font-bold font-mono text-blue-700';
                } else if (diff < 0) {
                    // Past consultation - elapsed time
                    label = 'Time Elapsed';
                    if (days > 0) {
                        timeString = `${days}d ${hours}h ago`;
                    } else if (hours > 0) {
                        timeString = `${hours}h ${minutes}m ago`;
                    } else if (minutes > 0) {
                        timeString = `${minutes}m ago`;
                    } else {
                        timeString = `${seconds}s ago`;
                    }
                    clockElement.className = 'text-sm font-bold font-mono text-gray-600';
                } else {
                    // Happening now
                    label = 'Happening Now';
                    timeString = 'NOW';
                    clockElement.className = 'text-sm font-bold font-mono text-green-600';
                }
                
                clockElement.textContent = timeString;
                if (labelElement) {
                    labelElement.textContent = label;
                }
            });
        }
        
        // Update consultation clocks immediately and then every second
        updateDashboardConsultationClocks();
        setInterval(updateDashboardConsultationClocks, 1000);
    </script>
@endsection