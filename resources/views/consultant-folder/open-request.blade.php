@extends('consultant-folder.layout')

@section('title', 'Open Request')
@section('page-title', 'Open Consultation Request')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900">{{ $consultation->topic }}</h2>
                    <p class="text-gray-600">From: {{ $consultation->customer->name ?? 'Unknown' }}</p>
                    <p class="text-gray-500 text-sm">Requested: {{ $consultation->created_at->format('M j, Y g:i A') }}</p>
                </div>
                <div>
                    <a href="{{ route('consultant.consultations') }}" class="text-sm text-blue-600 hover:underline">Back to Inbox</a>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h4 class="font-medium text-gray-900 mb-2">Request Details</h4>
                <p class="text-gray-700">{{ $consultation->details }}</p>
            </div>

            <div class="mb-6">
                <h4 class="font-medium text-gray-900 mb-2">Customer Preferred Schedule</h4>
                <p class="text-gray-700">Date: {{ $consultation->preferred_date ? \Carbon\Carbon::parse($consultation->preferred_date)->format('M j, Y') : 'Not specified' }}</p>
                <p class="text-gray-700">Time: {{ $consultation->preferred_time ? \Carbon\Carbon::parse($consultation->preferred_time)->format('g:i A') : 'Not specified' }}</p>
            </div>

            <form method="POST" action="{{ route('consultant.consultations.respond', $consultation->id) }}" class="space-y-4" id="responseForm">
                @csrf

                @if($errors->has('conflict'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <strong>⚠️ Schedule Conflict:</strong> {{ $errors->first('conflict') }}
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Response</label>
                    <div class="space-y-3">
                        <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition" id="accept-option">
                            <input type="radio" name="response_type" value="accept" class="mr-3" required>
                            <div>
                                <span class="text-green-700 font-semibold">✅ Accept (same date & time)</span>
                                <p class="text-sm text-gray-600">Confirm the consultation using the client's original date and time.</p>
                            </div>
                        </label>
                        <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition" id="propose-option">
                            <input type="radio" name="response_type" value="propose" class="mr-3" required>
                            <div>
                                <span class="text-blue-700 font-semibold">🔄 Propose new schedule</span>
                                <p class="text-sm text-gray-600">Suggest a different date and time to the client</p>
                            </div>
                        </label>
                        <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="response_type" value="reject" class="mr-3" required>
                            <div>
                                <span class="text-red-700 font-semibold">❌ Reject</span>
                                <p class="text-sm text-gray-600">Decline this consultation request</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message (optional)</label>
                    <textarea name="response_message" rows="4" class="w-full border rounded px-3 py-2" placeholder="Add a message to the client..."></textarea>
                </div>

                <!-- Accept Schedule Box (read-only preview of chosen date/time) -->
                <div id="accept-schedule-box" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Scheduled Date & Time</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                        <div>
                            <span class="block text-xs text-gray-500 mb-1">Date</span>
                            <div class="px-3 py-2 border border-gray-200 rounded bg-gray-50">
                                {{ $consultation->preferred_date ? \Carbon\Carbon::parse($consultation->preferred_date)->format('M j, Y') : 'Not specified' }}
                            </div>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-500 mb-1">Time</span>
                            <div class="px-3 py-2 border border-gray-200 rounded bg-gray-50">
                                {{ $consultation->preferred_time ? \Carbon\Carbon::parse($consultation->preferred_time)->format('g:i A') : 'Not specified' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Propose Schedule Box -->
                <div id="propose-schedule-box" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Proposed Schedule</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Date *</label>
                            <input type="date" name="proposed_date" id="proposed_date" class="w-full border rounded px-3 py-2" min="{{ date('Y-m-d') }}">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Time *</label>
                            <input type="time" name="proposed_time" id="proposed_time" class="w-full border rounded px-3 py-2">
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">The client will be notified and can accept or decline your proposed time.</p>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('consultant.consultations') }}" class="px-4 py-2 border rounded">Cancel</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Submit Response</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[name="response_type"]');
        const acceptBox = document.getElementById('accept-schedule-box');
        const proposeBox = document.getElementById('propose-schedule-box');
        const acceptOption = document.getElementById('accept-option');
        const proposeOption = document.getElementById('propose-option');
        const proposedDate = document.getElementById('proposed_date');
        const proposedTime = document.getElementById('proposed_time');
        const form = document.getElementById('responseForm');
        
        function updateRequiredFields() {
            const selectedValue = document.querySelector('input[name="response_type"]:checked')?.value;
            
            // Remove required from all fields first
            proposedDate.removeAttribute('required');
            proposedTime.removeAttribute('required');
            
            // Add required only if propose is selected
            if (selectedValue === 'propose') {
                proposedDate.setAttribute('required', 'required');
                proposedTime.setAttribute('required', 'required');
            }
        }
        
        radios.forEach(r => {
            r.addEventListener('change', function() {
                if (this.value === 'accept') {
                    acceptBox.classList.remove('hidden');
                    proposeBox.classList.add('hidden');
                    acceptOption.classList.add('border-green-500', 'bg-green-50');
                    acceptOption.classList.remove('border-gray-300');
                    proposeOption.classList.remove('border-blue-500', 'bg-blue-50');
                    proposeOption.classList.add('border-gray-300');
                } else if (this.value === 'propose') {
                    proposeBox.classList.remove('hidden');
                    acceptBox.classList.add('hidden');
                    proposeOption.classList.add('border-blue-500', 'bg-blue-50');
                    proposeOption.classList.remove('border-gray-300');
                    acceptOption.classList.remove('border-green-500', 'bg-green-50');
                    acceptOption.classList.add('border-gray-300');
                } else {
                    acceptBox.classList.add('hidden');
                    proposeBox.classList.add('hidden');
                    acceptOption.classList.remove('border-green-500', 'bg-green-50');
                    acceptOption.classList.add('border-gray-300');
                    proposeOption.classList.remove('border-blue-500', 'bg-blue-50');
                    proposeOption.classList.add('border-gray-300');
                }
                updateRequiredFields();
            });
        });
        
        // Handle form submission
        form.addEventListener('submit', function(e) {
            const selectedValue = document.querySelector('input[name="response_type"]:checked')?.value;
            
            if (selectedValue === 'propose') {
                if (!proposedDate.value || !proposedTime.value) {
                    e.preventDefault();
                    alert('Please fill in both the proposed date and time.');
                    return false;
                }
            }
        });
        
        // Initial update
        updateRequiredFields();
    });
</script>
@endsection
