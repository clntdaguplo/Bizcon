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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Consultant</label>
                    <input type="hidden" name="consultant_id" id="consultant_id" value="{{ optional($selectedConsultant)->id }}">
                    <div class="flex items-center gap-3 border border-blue-100 rounded-xl p-3 bg-blue-50/40 {{ $selectedConsultant ? '' : 'hidden' }} shadow-sm" id="selectedConsultant">
                        <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-200 ring-2 ring-blue-200">
                            @if($selectedConsultant && $selectedConsultant->avatar_path)
                                <img src="{{ asset('storage/'.$selectedConsultant->avatar_path) }}" id="selectedConsultantAvatar" class="h-full w-full object-cover" alt="">
                            @else
                                <div class="h-full w-full flex items-center justify-center text-gray-500 text-xl font-bold" id="selectedConsultantAvatar">
                                    @if($selectedConsultant)
                                        {{ substr(optional($selectedConsultant)->full_name, 0, 1) }}
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900" id="selectedConsultantName">{{ optional($selectedConsultant)->full_name }}</div>
                            <div class="text-xs text-gray-600 mt-1" id="selectedConsultantExpertiseCount">
                                @if($selectedConsultant)
                                    @php
                                        $expertiseList = optional($selectedConsultant)->expertise
                                            ? array_filter(array_map('trim', explode(',', optional($selectedConsultant)->expertise)))
                                            : [];
                                    @endphp
                                    @if(!empty($expertiseList))
                                        {{ count($expertiseList) }} expertise area(s) available
                                    @else
                                        <span class="text-gray-500">No expertise listed</span>
                                    @endif
                                @endif
                            </div>
                            <div class="mt-1" id="selectedConsultantRating">
                                @if($selectedConsultant && isset($selectedConsultant->average_rating) && $selectedConsultant->average_rating)
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($selectedConsultant->average_rating))
                                                <span class="text-yellow-500 text-xs">⭐</span>
                                            @else
                                                <span class="text-gray-300 text-xs">☆</span>
                                            @endif
                                        @endfor
                                        <span class="ml-1 text-xs text-gray-500">{{ $selectedConsultant->average_rating }}/5</span>
                                        @if($selectedConsultant->total_ratings > 0)
                                            <span class="ml-1 text-xs text-gray-400">({{ $selectedConsultant->total_ratings }})</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">No ratings yet</span>
                                @endif
                            </div>
                        </div>
                        <button type="button" onclick="showConsultantList()"
                           class="ml-auto inline-flex items-center text-xs font-medium text-blue-600 hover:text-blue-800 hover:underline">
                            Change
                        </button>
                    </div>
                    <div id="consultantListContainer" class="mt-2 hidden">
                        <div class="mb-2">
                            <input type="text" id="consultantSearch" placeholder="Search consultants..." 
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   onkeyup="filterConsultantList()">
                        </div>
                        <div id="consultantList" class="space-y-2 max-h-64 overflow-y-auto border border-gray-200 rounded-lg p-3 bg-gray-50"></div>
                        <div id="consultantListLoading" class="text-center py-4 text-gray-500 text-sm">
                            Loading consultants...
                        </div>
                    </div>
                    @if(!$selectedConsultant)
                        <div id="selectConsultantPrompt" class="mt-2">
                            <p class="text-sm text-gray-600">
                                <button type="button" onclick="showConsultantList()" 
                                        class="text-blue-600 hover:text-blue-800 hover:underline font-medium">
                                    Browse and select a consultant
                                </button> to see their available expertise areas, or 
                                <a href="{{ route('customer.consultants') }}" class="text-blue-600 hover:text-blue-800 hover:underline font-medium">
                                    view all consultants
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
                <div id="topicSection" class="{{ $selectedConsultant ? '' : 'hidden' }}">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Topic / Expertise <span class="text-red-500">*</span></label>
                    <select name="topic" id="topic" 
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                           required>
                        <option value="">Select a topic from consultant's expertise...</option>
                        @if($selectedConsultant)
                            @php
                                $expertiseList = optional($selectedConsultant)->expertise
                                    ? array_filter(array_map('trim', explode(',', optional($selectedConsultant)->expertise)))
                                    : [];
                            @endphp
                            @foreach($expertiseList as $expertise)
                                <option value="{{ $expertise }}">{{ $expertise }}</option>
                            @endforeach
                        @endif
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Choose the expertise area you want to consult about</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Booking Request Details</label>
                    <p class="text-xs text-gray-500 mb-2">Describe your consultation needs and requirements for this booking.</p>
                    <textarea name="details" id="details"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400"
                              rows="4"
                              placeholder="Briefly describe your current situation, goals, and any important background information for this consultation."></textarea>
                    <p class="text-xs text-gray-500 mt-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <strong>Note:</strong> After submitting this booking request, you can message the consultant separately through the chat system.
                    </p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Date <span class="text-red-500">*</span></label>
                        <input name="preferred_date" id="preferred_date" type="date" min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('preferred_date') border-red-500 @enderror"
                               required />
                        @error('preferred_date')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Minimum date is tomorrow (24 hours from now)</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Time <span class="text-red-500">*</span></label>
                        <input name="preferred_time" id="preferred_time" type="time"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('preferred_time') border-red-500 @enderror"
                               required />
                        @error('preferred_time')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-2 flex gap-3">
                    <button type="submit"
                            class="flex-1 sm:flex-initial inline-flex items-center justify-center bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold shadow-sm hover:bg-blue-700 transition-colors">
                        Submit Request
                    </button>
                    <button type="button" id="cancelButton" onclick="resetForm()"
                            class="flex-1 sm:flex-initial inline-flex items-center justify-center bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg text-sm font-semibold shadow-sm hover:bg-gray-300 transition-colors {{ $selectedConsultant ? '' : 'hidden' }}">
                        Cancel / Clear All
                    </button>
                </div>
            </form>
            </div>
        </div>
@endsection

@section('scripts')
<script>
const consultantList = document.getElementById('consultantList');
const topicSelect = document.getElementById('topic');
const consultantIdInput = document.getElementById('consultant_id');
const selectedConsultantDiv = document.getElementById('selectedConsultant');
const selectedConsultantName = document.getElementById('selectedConsultantName');
const selectedConsultantExpertiseCount = document.getElementById('selectedConsultantExpertiseCount');
const selectConsultantPrompt = document.getElementById('selectConsultantPrompt');
const topicSection = document.getElementById('topicSection');
const cancelButton = document.getElementById('cancelButton');
// Avatar will be accessed through parent container

let allConsultantsData = []; // Store all consultants for filtering

// Function to check if form has any input and show/hide cancel button
function checkFormState() {
    const hasConsultant = consultantIdInput.value && consultantIdInput.value !== '';
    const hasTopic = topicSelect && topicSelect.value && topicSelect.value !== '';
    const detailsField = document.getElementById('details');
    const hasDetails = detailsField && detailsField.value.trim() !== '';
    const preferredDateField = document.getElementById('preferred_date');
    const hasDate = preferredDateField && preferredDateField.value !== '';
    const preferredTimeField = document.getElementById('preferred_time');
    const hasTime = preferredTimeField && preferredTimeField.value !== '';
    
    const hasAnyInput = hasConsultant || hasTopic || hasDetails || hasDate || hasTime;
    
    if (cancelButton) {
        if (hasAnyInput) {
            cancelButton.classList.remove('hidden');
        } else {
            cancelButton.classList.add('hidden');
        }
    }
}

// Add event listeners to all form fields to check state
document.addEventListener('DOMContentLoaded', function() {
    // Check initial state
    checkFormState();
    
    // Listen to topic changes
    if (topicSelect) {
        topicSelect.addEventListener('change', checkFormState);
    }
    
    // Listen to details changes
    const detailsField = document.getElementById('details');
    if (detailsField) {
        detailsField.addEventListener('input', checkFormState);
    }
    
    // Listen to date changes
    const preferredDateField = document.getElementById('preferred_date');
    if (preferredDateField) {
        preferredDateField.addEventListener('change', checkFormState);
    }
    
    // Listen to time changes
    const preferredTimeField = document.getElementById('preferred_time');
    if (preferredTimeField) {
        preferredTimeField.addEventListener('change', checkFormState);
    }
    
    // Listen to consultant selection changes
    if (consultantIdInput) {
        consultantIdInput.addEventListener('change', checkFormState);
    }
});

function clearConsultant() {
    consultantIdInput.value = '';
    selectedConsultantDiv.classList.add('hidden');
    topicSection.classList.add('hidden');
    topicSelect.value = '';
    selectConsultantPrompt.classList.add('hidden');
    // Show consultant list container and load consultants
    const consultantListContainer = document.getElementById('consultantListContainer');
    const consultantSearch = document.getElementById('consultantSearch');
    if (consultantListContainer) {
        consultantListContainer.classList.remove('hidden');
    }
    if (consultantSearch) {
        consultantSearch.value = '';
    }
    loadAllConsultants();
    // Check if cancel button should be hidden (if no other inputs)
    checkFormState();
}

function showConsultantList() {
    clearConsultant();
}

function filterConsultantList() {
    const searchInput = document.getElementById('consultantSearch');
    const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
    
    if (!searchTerm) {
        renderConsultantList(allConsultantsData);
        return;
    }
    
    const filtered = allConsultantsData.filter(consultant => {
        const name = (consultant.full_name || '').toLowerCase();
        const expertise = (consultant.expertise || '').toLowerCase();
        const email = (consultant.email || '').toLowerCase();
        return name.includes(searchTerm) || expertise.includes(searchTerm) || email.includes(searchTerm);
    });
    
    renderConsultantList(filtered);
}

function renderConsultantList(consultants) {
    const consultantList = document.getElementById('consultantList');
    const loadingDiv = document.getElementById('consultantListLoading');
    
    if (loadingDiv) {
        loadingDiv.classList.add('hidden');
    }
    
    if (!consultantList) return;
    
    if (!consultants || consultants.length === 0) {
        consultantList.innerHTML = `
            <div class="text-sm text-gray-500 p-4 text-center">
                No consultants found. <a href="{{ route('customer.consultants') }}" class="text-blue-600 hover:underline">Browse all consultants</a>.
            </div>
        `;
        return;
    }

    consultantList.innerHTML = consultants.map((consultant) => {
        const expertiseList = consultant.expertise 
            ? consultant.expertise.split(',').map(e => e.trim()).filter(e => e)
            : [];
        const expertisePreview = expertiseList.length > 0 
            ? (expertiseList.length === 1 ? expertiseList[0] : `${expertiseList.length} expertise areas`)
            : 'No expertise';
        
        const avatar = consultant.avatar_path
            ? `<img src="{{ asset('storage/') }}/${consultant.avatar_path}" class="h-full w-full object-cover" alt="">`
            : `<div class="h-full w-full flex items-center justify-center text-gray-500 text-xl font-bold">${consultant.full_name ? consultant.full_name.charAt(0).toUpperCase() : '?'}</div>`;

        const consultantJson = JSON.stringify(consultant).replace(/"/g, '&quot;');
        return `
            <div class="border border-gray-200 rounded-lg p-3 hover:bg-white hover:shadow-sm cursor-pointer transition consultant-item bg-white" 
                 data-consultant='${consultantJson}'>
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full overflow-hidden bg-gray-200 flex-shrink-0">
                        ${avatar}
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900">${consultant.full_name || 'N/A'}</div>
                        <div class="text-xs text-gray-600">${expertisePreview}</div>
                        ${consultant.average_rating ? `
                            <div class="flex items-center mt-1">
                                ${Array.from({length: 5}, (_, i) => 
                                    i < Math.round(consultant.average_rating) 
                                        ? '<span class="text-yellow-500 text-xs">⭐</span>' 
                                        : '<span class="text-gray-300 text-xs">☆</span>'
                                ).join('')}
                                <span class="ml-1 text-xs text-gray-500">${consultant.average_rating}/5</span>
                                ${consultant.total_ratings > 0 ? `<span class="ml-1 text-xs text-gray-400">(${consultant.total_ratings})</span>` : ''}
                            </div>
                        ` : '<div class="text-xs text-gray-400 mt-1">No ratings yet</div>'}
                    </div>
                </div>
            </div>
        `;
    }).join('');
    
    // Add click handlers
    consultantList.querySelectorAll('.consultant-item').forEach(item => {
        item.addEventListener('click', function() {
            const consultantData = JSON.parse(this.getAttribute('data-consultant').replace(/&quot;/g, '"'));
            selectConsultant(consultantData);
            // Hide consultant list container
            const consultantListContainer = document.getElementById('consultantListContainer');
            if (consultantListContainer) {
                consultantListContainer.classList.add('hidden');
            }
        });
    });
}

function selectConsultant(consultant) {
    consultantIdInput.value = consultant.id;
    selectedConsultantName.textContent = consultant.full_name;
    
    // Update expertise count
    const expertiseList = consultant.expertise 
        ? consultant.expertise.split(',').map(e => e.trim()).filter(e => e)
        : [];
    selectedConsultantExpertiseCount.textContent = expertiseList.length > 0 
        ? `${expertiseList.length} expertise area(s) available`
        : 'No expertise listed';
    
    // Update avatar
    const avatarContainer = selectedConsultantDiv.querySelector('div.h-12.w-12');
    if (avatarContainer) {
        if (consultant.avatar_path) {
            avatarContainer.innerHTML = `<img src="{{ asset('storage/') }}/${consultant.avatar_path}" class="h-full w-full object-cover" alt="">`;
        } else {
            const initial = consultant.full_name ? consultant.full_name.charAt(0).toUpperCase() : '?';
            avatarContainer.innerHTML = `<div class="h-full w-full flex items-center justify-center text-gray-500 text-xl font-bold">${initial}</div>`;
        }
    }
    
    // Update rating display
    if (selectedConsultantRating) {
        if (consultant.average_rating) {
            const stars = Array.from({length: 5}, (_, i) => 
                i < Math.round(consultant.average_rating) 
                    ? '<span class="text-yellow-500 text-xs">⭐</span>' 
                    : '<span class="text-gray-300 text-xs">☆</span>'
            ).join('');
            selectedConsultantRating.innerHTML = `
                <div class="flex items-center mt-1">
                    ${stars}
                    <span class="ml-1 text-xs text-gray-500">${consultant.average_rating}/5</span>
                    ${consultant.total_ratings > 0 ? `<span class="ml-1 text-xs text-gray-400">(${consultant.total_ratings})</span>` : ''}
                </div>
            `;
        } else {
            selectedConsultantRating.innerHTML = '<span class="text-xs text-gray-400">No ratings yet</span>';
        }
    }
    
    // Populate topic dropdown with consultant's expertise
    topicSelect.innerHTML = '<option value="">Select a topic from consultant\'s expertise...</option>';
    if (expertiseList.length > 0) {
        expertiseList.forEach(expertise => {
            const option = document.createElement('option');
            option.value = expertise;
            option.textContent = expertise;
            topicSelect.appendChild(option);
        });
    } else {
        const option = document.createElement('option');
        option.value = '';
        option.textContent = 'No expertise available';
        option.disabled = true;
        topicSelect.appendChild(option);
    }
    
    selectedConsultantDiv.classList.remove('hidden');
    topicSection.classList.remove('hidden');
    const consultantListContainer = document.getElementById('consultantListContainer');
    if (consultantListContainer) {
        consultantListContainer.classList.add('hidden');
    }
    selectConsultantPrompt.classList.add('hidden');
    
    // Show cancel button when consultant is selected
    checkFormState();
}

function loadAllConsultants() {
    const loadingDiv = document.getElementById('consultantListLoading');
    const consultantList = document.getElementById('consultantList');
    
    if (loadingDiv) {
        loadingDiv.classList.remove('hidden');
    }
    if (consultantList) {
        consultantList.innerHTML = '';
    }
    
    fetch(`{{ route('customer.consultants.api.all') }}`)
        .then(response => response.json())
        .then(data => {
            if (!data.success || !data.data || data.data.length === 0) {
                allConsultantsData = [];
                if (consultantList) {
                    consultantList.innerHTML = `
                        <div class="text-sm text-gray-500 p-4 text-center">
                            No consultants available. <a href="{{ route('customer.consultants') }}" class="text-blue-600 hover:underline">Browse all consultants</a>.
                        </div>
                    `;
                }
                if (loadingDiv) {
                    loadingDiv.classList.add('hidden');
                }
                return;
            }

            allConsultantsData = data.data;
            renderConsultantList(allConsultantsData);
        })
        .catch(error => {
            console.error('Error fetching consultants:', error);
            allConsultantsData = [];
            if (consultantList) {
                consultantList.innerHTML = `
                    <div class="text-sm text-red-500 p-4 text-center">
                        Error loading consultants. Please try again or <a href="{{ route('customer.consultants') }}" class="text-blue-600 hover:underline">browse all consultants</a>.
                    </div>
                `;
            }
            if (loadingDiv) {
                loadingDiv.classList.add('hidden');
            }
        });
}

// Reset form function - clears all inputs
function resetForm() {
    if (confirm('Are you sure you want to clear all inputs? This will remove everything you have entered.')) {
        // Clear consultant selection
        consultantIdInput.value = '';
        selectedConsultantDiv.classList.add('hidden');
        topicSection.classList.add('hidden');
        
        // Clear topic dropdown
        if (topicSelect) {
            topicSelect.innerHTML = '<option value="">Select a topic from consultant\'s expertise...</option>';
            topicSelect.value = '';
        }
        
        // Clear all form fields
        const detailsField = document.getElementById('details');
        if (detailsField) detailsField.value = '';
        
        const preferredDateField = document.getElementById('preferred_date');
        if (preferredDateField) preferredDateField.value = '';
        
        const preferredTimeField = document.getElementById('preferred_time');
        if (preferredTimeField) preferredTimeField.value = '';
        
        // Hide consultant list container
        const consultantListContainer = document.getElementById('consultantListContainer');
        if (consultantListContainer) {
            consultantListContainer.classList.add('hidden');
        }
        
        // Clear consultant search
        const consultantSearch = document.getElementById('consultantSearch');
        if (consultantSearch) {
            consultantSearch.value = '';
        }
        
        // Show prompt
        selectConsultantPrompt.classList.remove('hidden');
        
        // Hide cancel button
        checkFormState();
        
        // Clear any validation errors
        const form = document.querySelector('form');
        if (form) {
            form.reset();
        }
    }
}

// Load consultants if no consultant is selected and user wants to select one
// Initialize if consultant is pre-selected
@if($selectedConsultant)
document.addEventListener('DOMContentLoaded', function() {
    @php
        $expertiseList = optional($selectedConsultant)->expertise
            ? array_filter(array_map('trim', explode(',', optional($selectedConsultant)->expertise)))
            : [];
        $consultantData = [
            'id' => $selectedConsultant->id,
            'full_name' => $selectedConsultant->full_name,
            'expertise' => $selectedConsultant->expertise,
            'avatar_path' => $selectedConsultant->avatar_path,
            'average_rating' => optional($selectedConsultant)->average_rating ?? null,
            'total_ratings' => optional($selectedConsultant)->total_ratings ?? 0,
        ];
    @endphp
    const preSelectedConsultant = @json($consultantData);
    selectConsultant(preSelectedConsultant);
    checkFormState();
});
@endif
</script>
@endsection

