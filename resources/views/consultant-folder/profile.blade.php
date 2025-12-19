@extends('consultant-folder.layout')

@section('title', 'Profile Management')
@section('page-title', 'My Profile')

@section('content')
    <div class="max-w-4xl mx-auto">
        @php
            // Consider profile "complete" when required fields are present.
            $isComplete = false;
            if (isset($profile) && $profile->exists) {
                $isComplete = !empty($profile->full_name)
                    && !empty($profile->expertise)
                    && !empty($profile->avatar_path)
                    && !empty($profile->resume_path)
                    && !empty($profile->address)
                    && !empty($profile->age)
                    && !empty($profile->sex);
            }
            // show the note only when profile is not complete
            $showProfileNote = ! $isComplete;
        @endphp
        @if ($showProfileNote)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded-xl mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zM9 7h2v5H9V7zm0 6h2v2H9v-2z" />
                    </svg>
                    <div class="ml-3">
                        <p class="font-medium">Complete your profile to get verified and accept consultation bookings</p>
                        <p class="text-sm mt-1 text-yellow-700">Fill out all required fields and upload your photo/resume.
                            Verification allows you to accept booking requests.</p>
                    </div>
                </div>
            </div>
        @endif
        <!-- Profile Header -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">

            <div class="flex items-center space-x-6">

                <div class="h-24 w-24 rounded-full overflow-hidden bg-gray-200 flex-shrink-0 flex items-center justify-center">
                    @if ($profile->avatar_path)
                        <img src="{{ asset('storage/' . $profile->avatar_path) }}" alt="{{ $profile->full_name }}"
                             class="h-full w-full object-cover">
                    @else
                        @php
                            $name = $profile->full_name ?: ($profile->user->name ?? '');
                            $initials = collect(explode(' ', trim($name)))
                                ->filter()
                                ->take(2)
                                ->map(fn ($part) => mb_substr($part, 0, 1))
                                ->implode('');
                            if ($initials === '') {
                                $initials = 'C';
                            }
                        @endphp
                        <span class="text-2xl font-semibold text-gray-600 select-none">
                            {{ mb_strtoupper($initials) }}
                        </span>
                    @endif
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $profile->full_name }}</h1>
                    <p class="text-blue-600 font-semibold">{{ $profile->expertise }}</p>
                    <div class="flex items-center flex-wrap mt-2 gap-3">
                        <div class="flex items-center">
                            @if ($profile->is_verified)
                                <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-green-600 font-medium">Verified Consultant</span>
                            @else
                                <span class="text-sm text-gray-500 font-medium">Pending verification</span>
                            @endif
                        </div>
                        <div class="flex items-center">
                            @if ($averageRating)
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($averageRating))
                                        <span class="text-yellow-500 text-lg">⭐</span>
                                    @else
                                        <span class="text-gray-300 text-lg">☆</span>
                                    @endif
                                @endfor
                                <span class="ml-2 text-sm text-gray-600">{{ $averageRating }}/5 ({{ $totalRatings }}
                                    {{ $totalRatings == 1 ? 'rating' : 'ratings' }})</span>
                            @else
                                <span class="text-xs text-gray-500">No ratings yet</span>
                            @endif
                        </div>
                        <div class="flex items-center">
                            @if ($profile->google_token)
                                <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700 border border-green-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Google Calendar Connected
                                </span>
                            @else
                                <a href="{{ route('google.connect') }}"
                                   class="inline-flex items-center rounded-full bg-white px-3 py-1 text-xs font-medium text-blue-700 border border-blue-300 hover:bg-blue-50 transition">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M21.35 11.1H12v2.8h5.35c-.25 1.4-1.5 4.1-5.35 4.1-3.22 0-5.85-2.66-5.85-5.9s2.63-5.9 5.85-5.9c1.83 0 3.06.78 3.76 1.45l2.57-2.5C16.66 3.7 14.63 2.8 12 2.8 6.96 2.8 2.9 6.86 2.9 11.9S6.96 21 12 21c6.25 0 8.35-4.38 8.35-7.1 0-.48-.05-.84-.1-1.2z" />
                                    </svg>
                                    Connect Google Calendar
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-600">Member since</div>
                    <div class="font-semibold text-gray-900">{{ auth()->user()->created_at->format('M Y') }}</div>
                </div>
            </div>
        </div>

        @if ($profile->exists)
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Client Feedback</h3>
                @if ($averageRating)
                    <div class="flex items-center mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($averageRating))
                                <span class="text-yellow-500 text-2xl">⭐</span>
                            @else
                                <span class="text-gray-200 text-2xl">☆</span>
                            @endif
                        @endfor
                        <span class="ml-3 text-sm text-gray-700 font-medium">{{ $averageRating }}/5 based on
                            {{ $totalRatings }} {{ $totalRatings == 1 ? 'rating' : 'ratings' }}</span>
                    </div>
                    <p class="text-sm text-gray-500">Improve your rating by delivering great experiences and requesting
                        feedback from clients.</p>
                @else
                    <p class="text-sm text-gray-500">Once you complete consultations, your client ratings will appear here.
                    </p>
                @endif
            </div>
        @endif

        {{-- Pending Update Notice --}}
        @if($profile->has_pending_update && $profile->previous_values)
            <div class="bg-purple-50 border-l-4 border-purple-500 rounded-lg shadow p-6 mb-6">
                <div class="flex items-start justify-between">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-purple-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-purple-900 mb-1">Profile Update Pending Approval</h3>
                            <p class="text-sm text-purple-800 mb-2">
                                Your profile update request was submitted on {{ $profile->update_requested_at->format('M d, Y \a\t g:i A') }} and is awaiting admin approval.
                            </p>
                            <p class="text-xs text-purple-700">
                                You can cancel this update request to restore your profile to the previous approved values.
                            </p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('consultant.profile.cancel-update') }}" 
                          onsubmit="return confirm('Are you sure you want to cancel this update request? Your profile will be restored to the previous approved values.');"
                          class="ml-4">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel Update
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- Profile Form -->
        <form method="POST"
            action="{{ $profile->exists ? route('consultant.profile.update') : route('consultant.profile.save') }}"
            enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if ($profile->exists)
                @method('PUT')
            @endif

            <!-- Personal Information -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Personal Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        @php
                            $defaultFullName = $profile->full_name ?: (auth()->user()->name ?? '');
                        @endphp
                        <input type="text" name="full_name" id="full_name"
                            value="{{ old('full_name', $defaultFullName) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        @error('full_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        @php
                            $defaultEmail = $profile->email ?: (auth()->user()->email ?? '');
                        @endphp
                        <input type="email" name="email" id="email" value="{{ old('email', $defaultEmail) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" name="phone_number" id="phone_number"
                            value="{{ old('phone_number', $profile->phone_number) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('phone_number')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                        <input type="number" name="age" id="age" value="{{ old('age', $profile->age) }}"
                            min="18" max="100"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('age')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sex" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                        <select name="sex" id="sex"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('sex', $profile->sex) === 'Male' ? 'selected' : '' }}>Male
                            </option>
                            <option value="Female" {{ old('sex', $profile->sex) === 'Female' ? 'selected' : '' }}>Female
                            </option>
                            <option value="Other" {{ old('sex', $profile->sex) === 'Other' ? 'selected' : '' }}>Other
                            </option>
                        </select>
                        @error('sex')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Professional Information</h2>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Areas of Expertise <span class="text-xs text-gray-500">(select up to 5)</span>
                        </label>
                        @php
                            $expertiseOptions = [
                                'Business Strategy',
                                'Startup & Entrepreneurship',
                                'Marketing & Branding',
                                'Financial & Investment',
                                'Technology & IT Support',
                                'Legal Consultation',
                                'Human Resources (HR) Consultation',
                                'E-commerce & Online Business',
                                'Career & Professional Development',
                                'Healthcare & Wellness',
                            ];
                            $selectedExpertise = old('expertise');
                            if (!is_array($selectedExpertise)) {
                                $selectedExpertise = $profile->expertise
                                    ? array_map('trim', explode(',', $profile->expertise))
                                    : [];
                            }
                        @endphp
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach ($expertiseOptions as $option)
                                <label
                                    class="flex items-start space-x-2 text-sm text-gray-700 border border-gray-200 rounded-lg p-3 hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" name="expertise[]" value="{{ $option }}"
                                        class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                        {{ in_array($option, $selectedExpertise, true) ? 'checked' : '' }}>
                                    <span>{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('expertise')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <textarea name="address" id="address" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('address', $profile->address) }}</textarea>
                        @error('address')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Profile Picture -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Profile Picture</h2>
                <div class="flex items-center space-x-6">
                    <div class="h-20 w-20 rounded-full overflow-hidden bg-gray-200 flex-shrink-0">
                        @if ($profile->avatar_path)
                            <img src="{{ asset('storage/' . $profile->avatar_path) }}" alt="{{ $profile->full_name }}"
                                class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full flex items-center justify-center text-gray-500 text-2xl font-bold">
                                {{ substr($profile->full_name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">Upload New
                            Photo</label>
                        <input type="file" name="avatar" id="avatar" accept="image/*"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF. Max size 2MB.</p>
                        @error('avatar')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Resume -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Resume</h2>
                <div class="space-y-4">
                    @if ($profile->resume_path)
                        <div class="flex flex-col p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center mb-3">
                                <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <div>
                                    <div class="font-medium text-gray-900">Current Resume</div>
                                    <div class="text-sm text-gray-600">{{ basename($profile->resume_path) }}</div>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $profile->resume_path) }}" target="_blank"
                                class="inline-flex items-center justify-center w-fit px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition border border-blue-200">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Resume
                            </a>
                        </div>
                    @endif

                    <div>
                        <label for="resume" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $profile->resume_path ? 'Update Resume' : 'Upload Resume' }}
                        </label>
                        <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">PDF, DOC or DOCX. Max size 5MB.</p>
                        @error('resume')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('dashboard.consultant') }}"
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Update Profile
                </button>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
    <script>
        // Preview uploaded avatar
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.querySelector('.h-20.w-20 img') || document.querySelector(
                        '.h-20.w-20 div');
                    if (preview) {
                        if (preview.tagName === 'IMG') {
                            preview.src = e.target.result;
                        } else {
                            preview.innerHTML = '<img src="' + e.target.result +
                                '" alt="Preview" class="h-full w-full object-cover">';
                        }
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
