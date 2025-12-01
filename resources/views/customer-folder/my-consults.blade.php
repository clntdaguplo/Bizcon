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
                            <th class="text-left px-4 py-2">Preferred Time</th>
                            <th class="text-left px-4 py-2">Status</th>
                            <th class="text-left px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultations ?? [] as $consultation)
                            <tr class="border-t hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2">{{ $consultation->topic }}</td>
                                <td class="px-4 py-2">{{ optional(optional($consultation->consultantProfile)->user)->name ?? '—' }}</td>
                                <td class="px-4 py-2">{{ $consultation->created_at->format('M j, Y') }}</td>
                                <td class="px-4 py-2">
                                    @if($consultation->preferred_date && $consultation->preferred_time)
                                        {{ \Carbon\Carbon::parse($consultation->preferred_date)->format('M j, Y') }} {{ \Carbon\Carbon::parse($consultation->preferred_time)->format('g:i A') }}
                                    @else
                                        —
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
                                    <button class="text-blue-600 hover:text-blue-800 text-sm view-details-btn transition-colors" data-target="details-{{ $consultation->id }}">View</button>
                                </td>
                            </tr>
                            <tr id="details-{{ $consultation->id }}" class="hidden border-t bg-gray-50 transition-all">
                                <td colspan="6" class="px-4 py-4">
                                    <div class="space-y-4">
                                        <div>
                                            <p class="font-semibold text-gray-800 mb-2">Request Details:</p>
                                            @if($consultation->details)
                                                <p class="text-gray-700">{{ $consultation->details }}</p>
                                            @else
                                                <p class="text-gray-500">No details were provided for this request.</p>
                                            @endif
                                        </div>

                                        @if($consultation->proposal_status === 'pending' && $consultation->proposed_date)
                                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                                <p class="font-semibold text-blue-900 mb-2">🔄 New Schedule Proposed</p>
                                                <p class="text-blue-800 mb-3">
                                                    Consultant proposed a new schedule: 
                                                    <strong>{{ \Carbon\Carbon::parse($consultation->proposed_date)->format('M j, Y') }} at {{ \Carbon\Carbon::parse($consultation->proposed_time)->format('g:i A') }}</strong>
                                                </p>
                                                <form method="POST" action="{{ route('customer.consultations.respond-proposal', $consultation->id) }}" class="flex gap-2">
                                                    @csrf
                                                    <button type="submit" name="proposal_response" value="accept" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                                        ✅ Accept new time
                                                    </button>
                                                    <button type="submit" name="proposal_response" value="decline" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                                        ❌ Decline
                                                    </button>
                                                </form>
                                            </div>
                                        @endif

                                        @if($consultation->status === 'Accepted' && $consultation->scheduled_date)
                                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                                <p class="font-semibold text-green-900 mb-2">✅ Scheduled</p>
                                                <p class="text-green-800 mb-2">
                                                    <strong>Date & Time:</strong> 
                                                    {{ \Carbon\Carbon::parse($consultation->scheduled_date)->format('M j, Y') }} at {{ \Carbon\Carbon::parse($consultation->scheduled_time)->format('g:i A') }}
                                                </p>
                                                @if($consultation->meeting_link)
                                                    <a href="{{ $consultation->meeting_link }}" target="_blank" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-2">
                                                        🔗 Join Google Meet
                                                    </a>
                                                @endif
                                            </div>
                                        @endif

                                        @if($consultation->status === 'Completed')
                                            @if($consultation->consultation_summary)
                                                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-3">
                                                    <p class="font-semibold text-purple-900 mb-2">📄 Consultation Report Available</p>
                                                    <a href="{{ route('customer.consultations.report', $consultation->id) }}" target="_blank" class="inline-block bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 mt-2">
                                                        Download Report
                                                    </a>
                                                </div>
                                            @endif
                                            
                                            @php
                                                $hasRated = \App\Models\ConsultationRating::where('consultation_id', $consultation->id)
                                                    ->where('rater_id', Auth::id())
                                                    ->where('rater_type', 'customer')
                                                    ->exists();
                                            @endphp
                                            @if(!$hasRated)
                                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                                    <p class="font-semibold text-yellow-900 mb-2">⭐ Rate Your Consultant</p>
                                                    <a href="{{ route('customer.consultations.rate', $consultation->id) }}" class="inline-block bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 mt-2">
                                                        Submit Rating
                                                    </a>
                                                </div>
                                            @else
                                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                                    <p class="text-green-800">✅ You have rated this consultation</p>
                                                </div>
                                            @endif
                                        @endif

                                        @if(in_array($consultation->status, ['Pending', 'Proposed'], true))
                                            <div class="border-t border-gray-200 pt-4 mt-4">
                                                <form method="POST" action="{{ route('customer.consultations.cancel', $consultation->id) }}" class="inline-block"
                                                      onsubmit="return confirm('Are you sure you want to cancel this consultation?');">
                                                    @csrf
                                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">
                                                        ❌ Cancel Consultation
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-gray-600">
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
    document.addEventListener('DOMContentLoaded', function () {
        const viewButtons = document.querySelectorAll('.view-details-btn');

        viewButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const detailsRow = document.getElementById(targetId);
                const isHidden = detailsRow.classList.toggle('hidden');
                this.textContent = isHidden ? 'View' : 'Hide';
            });
        });
    });
</script>
@endsection
