@extends('customer-folder.layout')

@section('title', 'Request Consultation')
@section('page-title', 'Request a Consultation')

@section('content')
        <div class="max-w-2xl mx-auto">
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Request a Consultation</h1>
                        <p class="text-sm text-gray-500 mt-1">Tell us what you need and we’ll match you with the right expert.</p>
                    </div>
                    <div class="hidden sm:flex flex-col items-end text-xs text-gray-400">
                        <span class="uppercase tracking-wide">Step 1</span>
                        <span>Submit request</span>
                    </div>
                </div>

            <form class="space-y-6" method="POST" action="{{ route('customer.consultations.store') }}">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Topic</label>
                    <input name="topic" type="text"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400"
                           placeholder="e.g., Marketing Strategy, IT Support, Career Coaching" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Consultant</label>
                    <input type="hidden" name="consultant_id" value="{{ optional($selectedConsultant)->id }}">
                    <div class="flex items-center gap-3 border border-blue-100 rounded-xl p-3 bg-blue-50/40 {{ $selectedConsultant ? '' : 'hidden' }} shadow-sm" id="selectedConsultant">
                        <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-200 ring-2 ring-blue-200">
                            @if($selectedConsultant && $selectedConsultant->avatar_path)
                                <img src="{{ asset('storage/'.$selectedConsultant->avatar_path) }}" class="h-full w-full object-cover" alt="">
                            @endif
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ optional($selectedConsultant)->full_name }}</div>
                            @php
                                $expertiseList = optional($selectedConsultant)->expertise
                                    ? array_filter(array_map('trim', explode(',', optional($selectedConsultant)->expertise)))
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
                        <a href="{{ route('customer.consultants') }}"
                           class="ml-auto inline-flex items-center text-xs font-medium text-blue-600 hover:text-blue-800 hover:underline">
                            Change
                        </a>
                    </div>
                    @if(!$selectedConsultant)
                        <a href="{{ route('customer.consultants') }}"
                           class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 mt-1">
                            <span class="mr-1">＋</span> Choose a consultant
                        </a>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Details</label>
                    <textarea name="details"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400"
                              rows="4"
                              placeholder="Briefly describe your current situation, goals, and any important background."></textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Date</label>
                        <input name="preferred_date" type="date"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Time</label>
                        <input name="preferred_time" type="time"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold shadow-sm hover:bg-blue-700 transition-colors">
                        Submit Request
                    </button>
                </div>
            </form>
            </div>
        </div>
@endsection


