@extends('customer-folder.layout')

@section('title', 'My Consultations')
@section('page-title', 'My Consultations')

@section('content')
        <div class="max-w-5xl mx-auto">
            <div class="bg-white p-8 rounded-xl shadow-md">
                <h1 class="text-3xl font-bold mb-6">My Consultations</h1>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
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
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $consultation->topic }}</td>
                                <td class="px-4 py-2">{{ optional(optional($consultation->consultantProfile)->user)->name ?? '—' }}</td>
                                <td class="px-4 py-2">{{ $consultation->created_at->format('Y-m-d') }}</td>
                                <td class="px-4 py-2">
                                    @if($consultation->preferred_date && $consultation->preferred_time)
                                        {{ \Carbon\Carbon::parse($consultation->preferred_date)->format('Y-m-d') }} {{ \Carbon\Carbon::parse($consultation->preferred_time)->format('H:i') }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @php $status = $consultation->status; @endphp
                                    @if($status === 'Completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Completed</span>
                                    @elseif($status === 'Accepted')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">In Progress</span>
                                    @elseif($status === 'Cancelled')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Cancelled</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Pending</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 space-x-2">
                                    <button class="text-blue-600 hover:underline text-sm view-details-btn" data-target="details-{{ $consultation->id }}">View</button>
                                </td>
                            </tr>
                            <tr id="details-{{ $consultation->id }}" class="hidden border-t bg-gray-50">
                                <td colspan="6" class="px-4 py-4">
                                    <div class="prose prose-sm max-w-none">
                                        <p class="font-semibold text-gray-800">Request Details:</p>
                                        @if($consultation->details)
                                            <p>{{ $consultation->details }}</p>
                                        @else
                                            <p class="text-gray-500">No details were provided for this request.</p>
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

                <div class="mt-6">
                    <a href="{{ route('customer.new-consult') }}" class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Request New Consultation</a>
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
