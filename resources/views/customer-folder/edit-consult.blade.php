@extends('customer-folder.layout')

@section('title', 'Edit Consultation Request')
@section('page-title', 'Edit Consultation Request')

@section('content')
        <div class="max-w-2xl mx-auto">
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Edit Consultation Request</h1>
                        <p class="text-sm text-gray-500 mt-1">Update your consultation request details.</p>
                    </div>
                    <a href="{{ route('customer.my-consults') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        ← Back to My Consultations
                    </a>
                </div>

            <form class="space-y-6" method="POST" action="{{ route('customer.consultations.update', $consultation->id) }}">
                @csrf
                @method('PUT')

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Topic / Purpose *</label>
                    <input name="topic" type="text"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400"
                           placeholder="e.g., Marketing Strategy, IT Support, Career Coaching"
                           value="{{ old('topic', $consultation->topic) }}" required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Consultant</label>
                    <div class="flex items-center gap-3 border border-blue-100 rounded-xl p-3 bg-blue-50/40 shadow-sm">
                        <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-200 ring-2 ring-blue-200">
                            @if($consultation->consultantProfile && $consultation->consultantProfile->avatar_path)
                                <img src="{{ asset('storage/'.$consultation->consultantProfile->avatar_path) }}" class="h-full w-full object-cover" alt="">
                            @endif
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ optional(optional($consultation->consultantProfile)->user)->name ?? 'Unknown' }}</div>
                            @php
                                $expertiseList = optional($consultation->consultantProfile)->expertise
                                    ? array_filter(array_map('trim', explode(',', $consultation->consultantProfile->expertise)))
                                    : [];
                            @endphp
                            @if(!empty($expertiseList))
                                <ul class="text-xs text-gray-600 space-y-0.5 mt-1 list-disc list-inside">
                                    @foreach($expertiseList as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-xs text-gray-500 mt-1">No expertise listed</div>
                            @endif
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Consultant cannot be changed. Create a new request to select a different consultant.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Details</label>
                    <textarea name="details"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400"
                              rows="4"
                              placeholder="Briefly describe your current situation, goals, and any important background.">{{ old('details', $consultation->details) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Date</label>
                        <input name="preferred_date" type="date"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('preferred_date', $consultation->preferred_date ? \Carbon\Carbon::parse($consultation->preferred_date)->format('Y-m-d') : '') }}"
                               min="{{ date('Y-m-d') }}" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Time</label>
                        <input name="preferred_time" type="time"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('preferred_time', $consultation->preferred_time) }}" />
                    </div>
                </div>

                @if($consultation->status === 'Expired')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-sm text-yellow-800">
                            <strong>Note:</strong> This request has expired because the preferred date has passed. 
                            Updating it will reset the status to "Pending" and notify your consultant.
                        </p>
                    </div>
                @endif

                <div class="pt-2 flex gap-3">
                    <button type="submit"
                            class="inline-flex items-center justify-center bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold shadow-sm hover:bg-blue-700 transition-colors">
                        Update Request
                    </button>
                    <a href="{{ route('customer.my-consults') }}"
                       class="inline-flex items-center justify-center bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
            </div>
        </div>
@endsection

