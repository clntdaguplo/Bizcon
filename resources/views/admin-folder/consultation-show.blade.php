@extends('admin-folder.layout')

@section('title', 'Consultation Details')
@section('page-title', 'Consultation Details')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="bg-white rounded-xl shadow p-6 flex items-center justify-between">
        <div>
            <p class="text-xs text-gray-500 uppercase tracking-wide">Session ID</p>
            <p class="text-xl font-semibold text-gray-900">#{{ str_pad($consultation->id, 6, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div>
            @if($consultation->status === 'Completed')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Completed
                </span>
            @elseif($consultation->status === 'Accepted')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    In Progress
                </span>
            @elseif($consultation->status === 'Cancelled')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    Cancelled
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $consultation->status }}
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Consultant</h2>
            <p class="text-sm text-gray-900 font-medium">
                {{ optional(optional($consultation->consultantProfile)->user)->name ?? 'N/A' }}
            </p>
            <p class="text-sm text-gray-500 mt-1">
                {{ $consultation->consultantProfile->expertise ?? 'No expertise listed' }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Customer</h2>
            <p class="text-sm text-gray-900 font-medium">
                {{ optional($consultation->customer)->name ?? 'N/A' }}
            </p>
            <p class="text-sm text-gray-500 mt-1">
                {{ optional($consultation->customer)->email ?? 'N/A' }}
            </p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-6 space-y-4">
        <h2 class="text-lg font-semibold text-gray-900 mb-2">Session Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div>
                <p class="font-medium text-gray-900">Topic</p>
                <p>{{ $consultation->topic }}</p>
            </div>
            <div>
                <p class="font-medium text-gray-900">Requested At</p>
                <p>{{ $consultation->created_at?->format('M j, Y g:i A') }}</p>
            </div>
            <div>
                <p class="font-medium text-gray-900">Preferred Date & Time</p>
                <p>
                    @if($consultation->preferred_date && $consultation->preferred_time)
                        {{ \Carbon\Carbon::parse($consultation->preferred_date)->format('M j, Y') }}
                        at {{ \Carbon\Carbon::parse($consultation->preferred_time)->format('g:i A') }}
                    @else
                        Not specified
                    @endif
                </p>
            </div>
            <div>
                <p class="font-medium text-gray-900">Scheduled Date & Time</p>
                <p>
                    @if($consultation->scheduled_date && $consultation->scheduled_time)
                        {{ \Carbon\Carbon::parse($consultation->scheduled_date)->format('M j, Y') }}
                        at {{ \Carbon\Carbon::parse($consultation->scheduled_time)->format('g:i A') }}
                    @else
                        Not scheduled
                    @endif
                </p>
            </div>
        </div>

        <div class="mt-4">
            <p class="font-medium text-gray-900 mb-1">Details</p>
            <p class="text-sm text-gray-700 whitespace-pre-line">
                {{ $consultation->details ?: 'No additional details provided.' }}
            </p>
        </div>

        @if($consultation->consultation_summary)
            <div class="mt-4 border-t border-gray-200 pt-4">
                <p class="font-medium text-gray-900 mb-1">Consultation Summary</p>
                <p class="text-sm text-gray-700 whitespace-pre-line">{{ $consultation->consultation_summary }}</p>
            </div>
            <div class="mt-4">
                <p class="font-medium text-gray-900 mb-1">Recommendations</p>
                <p class="text-sm text-gray-700 whitespace-pre-line">{{ $consultation->recommendations }}</p>
            </div>
        @endif
    </div>

    <div class="flex justify-end">
        <a href="{{ route('admin.consultations') }}"
           class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 hover:bg-gray-50">
            Back to Consultations
        </a>
    </div>
</div>
@endsection


