@extends('consultant-folder.layout')

@section('title', 'Create Consultation Report')
@section('page-title', 'Create Consultation Report')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">{{ $consultation->topic }}</h2>
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

