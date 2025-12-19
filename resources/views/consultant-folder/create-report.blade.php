@extends('consultant-folder.layout')

@section('title', 'Create Consultation Report')
@section('page-title', 'Create Consultation Report')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-2">
                <h2 class="text-2xl font-semibold text-gray-900">{{ $consultation->topic }}</h2>
                @php
                    $customerTier = \App\Services\SubscriptionService::getTier($consultation->customer);
                @endphp
                @if($customerTier === 'Free')
                    <span class="px-2 py-0.5 bg-red-100 text-red-700 text-[10px] font-bold rounded-full border border-red-200 uppercase tracking-wider">Free Trial</span>
                @elseif($customerTier === 'Weekly')
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-full border border-blue-200 uppercase tracking-wider">Weekly</span>
                @elseif($customerTier === 'Quarterly')
                    <span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-[10px] font-bold rounded-full border border-purple-200 uppercase tracking-wider">Quarterly</span>
                @elseif($customerTier === 'Annual')
                    <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-full border border-amber-200 uppercase tracking-wider shadow-sm">Annual</span>
                @endif
            </div>
            <p class="text-gray-600">Client: {{ $consultation->customer->name ?? 'Unknown' }}</p>
            <p class="text-gray-500 text-sm">Consultation Date: 
                @if($consultation->scheduled_date)
                    {{ \Carbon\Carbon::parse($consultation->scheduled_date)->format('M j, Y') }} 
                    @if($consultation->scheduled_time)
                        at {{ \Carbon\Carbon::parse($consultation->scheduled_time)->format('g:i A') }}
                    @endif
                @else
                    Not specified
                @endif
            </p>
        </div>

        @if(!$consultation->customer->hasSubscriptionFeature('report_export'))
            <div class="bg-red-50 border-2 border-red-200 rounded-xl p-6 mb-6">
                <div class="flex items-start">
                    <div class="bg-red-100 p-2 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10m12-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-red-800">Detailed Report Restricted</h3>
                        <p class="text-sm text-red-700 mt-1">
                            Creating detailed reports and generating PDFs is restricted for Free Trial users.
                            Please ask the client to upgrade to a paid plan (**Weekly, Quarterly, or Annual**) to enable full reporting and PDF downloads.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('consultant.consultations') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-semibold">
                                Back to Consultations
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('consultant.consultations.save-report', $consultation->id) }}" class="space-y-6">
            @csrf

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Consultation Summary *</label>
                <textarea name="consultation_summary" rows="6" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Provide a detailed summary of the consultation session..." required>{{ old('consultation_summary', $consultation->consultation_summary) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Summarize what was discussed, key points, and outcomes.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Recommendations *</label>
                <textarea name="recommendations" rows="6" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="List your recommendations for the client..." required>{{ old('recommendations', $consultation->recommendations) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Provide actionable recommendations based on the consultation.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Client Readiness Rating *</label>
                <div class="flex items-center space-x-2">
                    @for($i = 1; $i <= 5; $i++)
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="client_readiness_rating" value="{{ $i }}" 
                                class="mr-1" {{ old('client_readiness_rating', $consultation->client_readiness_rating) == $i ? 'checked' : '' }} required>
                            <span class="text-2xl">{{ $i === 1 ? '😟' : ($i === 2 ? '😐' : ($i === 3 ? '🙂' : ($i === 4 ? '😊' : '🤩'))) }}</span>
                            <span class="ml-1 text-sm text-gray-600">{{ $i }}</span>
                        </label>
                    @endfor
                </div>
                <p class="text-xs text-gray-500 mt-2">Rate how ready the client is to implement your recommendations (1 = Not Ready, 5 = Very Ready)</p>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('consultant.consultations') }}" class="px-4 py-2 border rounded">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save Report</button>
            </div>
        </form>
    </div>
</div>
@endsection

