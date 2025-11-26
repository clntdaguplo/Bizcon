@extends('consultant-folder.layout')

@section('title', 'Profile Management')
@section('page-title', 'My Profile')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Profile Header -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <div class="flex items-center space-x-6">
                <div class="h-24 w-24 rounded-full overflow-hidden bg-gray-200 flex-shrink-0">
                    @if($profile->avatar_path)
                        <img src="{{ asset('storage/'.$profile->avatar_path) }}" 
                             alt="{{ $profile->full_name }}" 
                             class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full flex items-center justify-center text-gray-500 text-3xl font-bold">
                            {{ substr($profile->full_name, 0, 1) }}
                </div>
            @endif
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $profile->full_name }}</h1>
                    <p class="text-blue-600 font-semibold">{{ $profile->expertise }}</p>
                    <div class="flex items-center mt-2">
                        @if($profile->is_verified)
                            <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm text-green-600 font-medium">Verified Consultant</span>
                        @else
                            <span class="text-sm text-gray-500 font-medium">Pending verification</span>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-600">Member since</div>
                    <div class="font-semibold text-gray-900">{{ auth()->user()->created_at->format('M Y') }}</div>
                    </div>
                    </div>
                </div>

        <!-- Profile Form -->
        <form method="POST" action="{{ $profile->exists ? route('consultant.profile.update') : route('consultant.profile.save') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($profile->exists)
                @method('PUT')
            @endif
            
            <!-- Personal Information -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Personal Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $profile->full_name) }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        @error('full_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $profile->email) }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                </div>
                    
                <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number', $profile->phone_number) }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('phone_number')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                </div>
                    
                <div>
                        <label for="age" class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                        <input type="number" name="age" id="age" value="{{ old('age', $profile->age) }}" min="18" max="100"
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
                            <option value="Male" {{ old('sex', $profile->sex) === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('sex', $profile->sex) === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('sex', $profile->sex) === 'Other' ? 'selected' : '' }}>Other</option>
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
                        <label for="expertise" class="block text-sm font-medium text-gray-700 mb-2">Area of Expertise</label>
                        <input type="text" name="expertise" id="expertise" value="{{ old('expertise', $profile->expertise) }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
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
                        @if($profile->avatar_path)
                            <img src="{{ asset('storage/'.$profile->avatar_path) }}" 
                                 alt="{{ $profile->full_name }}" 
                                 class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full flex items-center justify-center text-gray-500 text-2xl font-bold">
                                {{ substr($profile->full_name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">Upload New Photo</label>
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
                    @if($profile->resume_path)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                <div>
                                    <div class="font-medium text-gray-900">Current Resume</div>
                                    <div class="text-sm text-gray-600">{{ basename($profile->resume_path) }}</div>
                                </div>
                            </div>
                            <a href="{{ asset('storage/'.$profile->resume_path) }}" target="_blank" 
                               class="text-blue-600 hover:underline text-sm">View</a>
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
                const preview = document.querySelector('.h-20.w-20 img') || document.querySelector('.h-20.w-20 div');
                if (preview) {
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" class="h-full w-full object-cover">';
                    }
                }
            };
            reader.readAsDataURL(file);
        }
    });
    </script>
@endsection