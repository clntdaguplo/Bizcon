@extends('customer-folder.layout')

@section('title', 'My Consultations')
@section('page-title', 'My Consultations')

@section('content')
        <div class="max-w-5xl mx-auto">
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">My Consultations</h1>
                        <p class="text-sm text-gray-500 mt-1">Review your past and upcoming consultation requests.</p>
                    </div>
                </div>

            <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
                <table class="min-w-full">
                    <thead class="bg-gray-50/80">
                        <tr>
                            <th class="text-left px-4 py-2">Topic</th>
                            <th class="text-left px-4 py-2">Consultant</th>
                            <th class="text-left px-4 py-2">Requested</th>
                            <th class="text-left px-4 py-2">Scheduled Time</th>
                            <th class="text-left px-4 py-2">Live Clock</th>
                            <th class="text-left px-4 py-2">Status</th>
                            <th class="text-left px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultations ?? [] as $consultation)
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
                            
                            <tr id="consultation-{{ $consultation->id }}" class="border-t hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2">{{ $consultation->topic }}</td>
                                <td class="px-4 py-2">{{ optional(optional($consultation->consultantProfile)->user)->name ?? '—' }}</td>
                                <td class="px-4 py-2">{{ $consultation->created_at->format('M j, Y') }}</td>
                                <td class="px-4 py-2">
                                    @if($scheduledDateTime)
                                        <div class="text-sm text-gray-900">
                                            {{ $scheduledDateTime->format('M j, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-600">
                                            {{ $scheduledDateTime->format('g:i A') }}
                                        </div>
                                    @elseif($consultation->preferred_date && $consultation->preferred_time)
                                        <div class="text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($consultation->preferred_date)->format('M j, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-600">
                                            {{ \Carbon\Carbon::parse($consultation->preferred_time)->format('g:i A') }}
                                        </div>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @if($scheduledDateTime && in_array($consultation->status, ['Accepted', 'Pending', 'Proposed']))
                                        <div class="flex flex-col">
                                            <div class="text-xs font-semibold text-blue-600 uppercase mb-1" id="clock-label-customer-{{ $consultation->id }}">
                                                @if($scheduledDateTime->isFuture())
                                                    Time Remaining
                                                @elseif($scheduledDateTime->isPast())
                                                    Time Elapsed
                                                @else
                                                    Happening Now
                                                @endif
                                            </div>
                                            <div class="text-sm font-bold font-mono" id="live-clock-customer-{{ $consultation->id }}">
                                                <span id="clock-time-customer-{{ $consultation->id }}" class="@if($scheduledDateTime->isFuture()) text-blue-700 @elseif($scheduledDateTime->isPast()) text-gray-600 @else text-green-600 @endif">--:--:--</span>
                                            </div>
                                            <input type="hidden" id="scheduled-time-customer-{{ $consultation->id }}" value="{{ $scheduledDateTime->timestamp }}">
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @php 
                                        $status = $consultation->status;
                                        $hasProposal = $consultation->proposal_status === 'pending';
                                    @endphp
                                    @if($status === 'Completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Completed</span>
                                    @elseif($status === 'Accepted')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Accepted</span>
                                    @elseif($status === 'Proposed' || $hasProposal)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">🔄 Proposal Pending</span>
                                    @elseif($status === 'Expired')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-800">Expired</span>
                                    @elseif($status === 'Cancelled')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Cancelled</span>
                                    @elseif($status === 'Rejected')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Pending</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 space-x-2">
                                    @if(auth()->user()->hasSubscriptionFeature('view_consultation_details'))
                                    <a href="{{ route('customer.consultations.show', $consultation->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition-colors border border-blue-200 hover:border-blue-300">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Details
                                    </a>
                                    @else
                                    <span class="text-xs text-gray-400 font-bold uppercase italic">Locked</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-gray-600">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    No consultations yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('customer.new-consult') }}"
                       class="inline-flex items-center bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-sm hover:bg-blue-700 transition-colors">
                        ＋ Request New Consultation
                    </a>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
<script>
    // Live clocks for customer consultations
    function updateCustomerConsultationClocks() {
        document.querySelectorAll('[id^="scheduled-time-customer-"]').forEach(function(input) {
            const consultationId = input.id.replace('scheduled-time-customer-', '');
            const scheduledTimestamp = parseInt(input.value);
            const scheduledTime = new Date(scheduledTimestamp * 1000);
            const now = new Date();
            const diff = scheduledTime - now;
            
            const clockElement = document.getElementById('clock-time-customer-' + consultationId);
            const labelElement = document.getElementById('clock-label-customer-' + consultationId);
            
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
                clockElement.className = 'text-sm font-bold font-mono text-blue-700';
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
    
    // Update customer consultation clocks immediately and then every second
    updateCustomerConsultationClocks();
    setInterval(updateCustomerConsultationClocks, 1000);
    
    // If coming from a notification with a highlight param, scroll and highlight the row
    document.addEventListener('DOMContentLoaded', function () {
        const params = new URLSearchParams(window.location.search);
        const highlightId = params.get('highlight');
        if (highlightId) {
            const row = document.getElementById('consultation-' + highlightId);
            if (row) {
                row.classList.add('ring-2', 'ring-blue-400', 'ring-offset-1');
                row.scrollIntoView({ behavior: 'smooth', block: 'center' });

                // Remove highlight after a few seconds
                setTimeout(() => {
                    row.classList.remove('ring-2', 'ring-blue-400', 'ring-offset-1');
                }, 4000);
            }
        }
    });
</script>
@endsection
