@extends('customer-folder.layout')

@section('title', 'Request Consultation')
@section('page-title', 'Request a Consultation')

@section('content')
        <div class="max-w-2xl mx-auto">
            <div class="bg-white p-8 rounded-xl shadow-md">
                <h1 class="text-3xl font-bold mb-6">Request a Consultation</h1>

            <form class="space-y-4" method="POST" action="{{ route('customer.consultations.store') }}">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Topic</label>
                    <input name="topic" type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Marketing Strategy" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Consultant</label>
                    <input type="hidden" name="consultant_id" value="{{ optional($selectedConsultant)->id }}">
                    <div class="flex items-center gap-3 border border-gray-200 rounded-md p-3 {{ $selectedConsultant ? '' : 'hidden' }}" id="selectedConsultant">
                        <div class="h-10 w-10 rounded-full overflow-hidden bg-gray-200">
                            @if($selectedConsultant && $selectedConsultant->avatar_path)
                                <img src="{{ asset('storage/'.$selectedConsultant->avatar_path) }}" class="h-full w-full object-cover" alt="">
                            @endif
                        </div>
                        <div>
                            <div class="font-medium">{{ optional($selectedConsultant)->full_name }}</div>
                            <div class="text-sm text-gray-600">{{ optional($selectedConsultant)->expertise }}</div>
                        </div>
                        <a href="{{ route('customer.consultants') }}" class="ml-auto text-sm text-blue-600 hover:underline">Change</a>
                    </div>
                    @if(!$selectedConsultant)
                        <a href="{{ route('customer.consultants') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mt-1">Choose a consultant</a>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Details</label>
                    <textarea name="details" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4" placeholder="Describe your needs"></textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Date</label>
                        <input name="preferred_date" type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Time</label>
                        <input name="preferred_time" type="time" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Submit Request</button>
                </div>
            </form>
            </div>
        </div>
@endsection


