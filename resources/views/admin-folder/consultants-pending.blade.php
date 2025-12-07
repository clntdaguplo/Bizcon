@extends('admin-folder.layout')

@section('title', 'Pending Consultants')
@section('page-title', 'Pending Consultants')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Pending Consultant Approvals</h2>
                <p class="text-gray-600">Review and approve new consultant applications</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.consultants') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    All Consultants
                </a>
                <a href="{{ route('admin.consultants.rejected') }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Rejected Consultants
                </a>
                <a href="{{ route('admin.consultants.suspended') }}" class="bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700 flex items-center relative">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                    Suspended
                    @php
                        $suspendedCount = \App\Models\ConsultantProfile::where('is_rejected', true)
                            ->where('is_verified', true)
                            ->get()
                            ->filter(function($consultant) {
                                // Filter out expired suspensions (same logic as in controller)
                                if ($consultant->suspended_until && $consultant->suspended_until->isPast()) {
                                    return false;
                                }
                                return true;
                            })
                            ->count();
                    @endphp
                    @if($suspendedCount > 0)
                        <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                            {{ $suspendedCount }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Pending Approvals</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $pending->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Pending Consultants List -->
    <div class="space-y-6">
        @forelse($pending as $p)
            <div class="bg-white rounded-lg shadow border {{ $p->resubmission_count > 0 ? 'border-yellow-400' : 'border-gray-200' }}">
                @if($p->resubmission_count > 0)
                    <div class="px-6 py-3 bg-yellow-50 border-b border-yellow-200 flex items-center">
                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span class="text-yellow-800 font-semibold text-sm">RESUBMISSION #{{ $p->resubmission_count }}</span>
                        @if($p->rejected_at)
                            <span class="ml-3 text-xs text-yellow-700">Previously rejected: {{ $p->rejected_at->format('M d, Y') }}</span>
                        @endif
                    </div>
                @endif

                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center mr-4">
                                    @if($p->avatar_path)
                                        <img src="{{ asset('storage/'.$p->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-gray-600 font-semibold text-lg">{{ substr($p->full_name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $p->full_name }}</h3>
                                    <p class="text-gray-600">{{ $p->email }}</p>
                                </div>
                            </div>
                            <div class="ml-16 text-sm text-gray-500 space-y-1">
                                <p>Submitted: {{ $p->created_at->format('M d, Y \a\t g:i A') }}</p>
                                @if($p->resubmitted_at)
                                    <p class="text-yellow-700 font-medium">Resubmitted: {{ $p->resubmitted_at->format('M d, Y \a\t g:i A') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <form method="POST" action="{{ route('admin.consultants.approve', $p->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Approve
                                </button>
                            </form>
                            <button type="button" onclick="toggleRejectForm({{ $p->id }})" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reject
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <p class="text-gray-900">{{ $p->phone_number }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Expertise</label>
                            <span class="inline-block bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded">{{ $p->expertise }}</span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                            <p class="text-gray-900">{{ $p->age }} years old</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                            <p class="text-gray-900">{{ $p->sex }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Resume</label>
                        <a href="{{ asset('storage/'.$p->resume_path) }}" target="_blank" 
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            View Resume (PDF)
                        </a>
                    </div>

                    @if($p->rejected_at || $p->admin_note)
                        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 rounded">
                            <div class="text-sm">
                                <span class="font-semibold text-red-900">Previous Rejection History:</span>
                                @if($p->rejected_at)
                                    <span class="text-red-700 ml-2">Rejected on {{ $p->rejected_at->format('M d, Y') }}</span>
                                @endif
                                @if($p->admin_note)
                                    <p class="mt-2 text-red-800 text-xs italic">"{{ \Illuminate\Support\Str::limit($p->admin_note, 150) }}"</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Reject Form (Hidden by default) -->
                    <div id="rejectForm{{ $p->id }}" class="hidden border-t border-gray-200 pt-4 mt-4" style="display: none;">
                        <form method="POST" action="{{ route('admin.consultants.reject', $p->id) }}" id="rejectFormSubmit{{ $p->id }}" onsubmit="return validateRejectForm({{ $p->id }});">
                            @csrf
                            
                            @if($errors->any() && old('_token'))
                                <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 rounded">
                                    <div class="flex">
                                        <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-red-800">Please fix the following errors:</p>
                                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label for="reject_reason{{ $p->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                    Rejection Reason <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    id="reject_reason{{ $p->id }}"
                                    name="admin_note" 
                                    rows="4" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('admin_note') border-red-500 @enderror"
                                    placeholder="Please provide a clear reason for rejection (minimum 10 characters). The consultant will receive this message."
                                    required
                                    minlength="10">{{ old('admin_note') }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">This message will be sent to the consultant. Previous rejection history will be preserved.</p>
                                @error('admin_note')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex space-x-2">
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition font-medium">
                                    Confirm Rejection
                                </button>
                                <button type="button" onclick="toggleRejectForm({{ $p->id }})" 
                                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition font-medium">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Pending Approvals</h3>
                <p class="text-gray-600">All consultant applications have been reviewed.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    function toggleRejectForm(id) {
        const formContainer = document.getElementById('rejectForm' + id);
        if (!formContainer) {
            console.error('Reject form container not found for ID:', id);
            alert('Error: Form not found. Please refresh the page and try again.');
            return;
        }
        
        const isHidden = formContainer.classList.contains('hidden') || formContainer.style.display === 'none';
        
        if (isHidden) {
            // Show the form
            formContainer.classList.remove('hidden');
            formContainer.style.display = 'block';
            
            // Focus on textarea
            const textarea = document.getElementById('reject_reason' + id);
            if (textarea) {
                setTimeout(() => {
                    textarea.focus();
                    textarea.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 100);
            }
        } else {
            // Hide the form
            formContainer.classList.add('hidden');
            formContainer.style.display = 'none';
            
            // Reset the form
            const form = document.getElementById('rejectFormSubmit' + id);
            if (form) {
                form.reset();
            }
        }
    }

    // Validate reject form before submission
    function validateRejectForm(id) {
        const textarea = document.getElementById('reject_reason' + id);
        if (!textarea) {
            alert('Error: Textarea not found. Please refresh the page.');
            return false;
        }

        const value = textarea.value.trim();
        if (!value) {
            alert('Please provide a rejection reason.');
            textarea.focus();
            return false;
        }

        if (value.length < 10) {
            alert('The rejection reason must be at least 10 characters long.');
            textarea.focus();
            return false;
        }

        return confirm('Are you sure you want to reject this consultant? This action cannot be undone easily.');
    }

    // Ensure forms are hidden on page load
    document.addEventListener('DOMContentLoaded', function() {
        const rejectForms = document.querySelectorAll('[id^="rejectForm"]');
        rejectForms.forEach(function(form) {
            if (form.id !== 'rejectForm' && form.id.startsWith('rejectForm')) {
                form.style.display = 'none';
            }
        });
        
        // If there are validation errors, show the form for the consultant that had errors
        @if($errors->any() && old('_token'))
            // Check if we need to show a specific form (you might need to pass the consultant ID)
            // For now, we'll show all forms if there are errors
        @endif
    });
</script>
@endsection
