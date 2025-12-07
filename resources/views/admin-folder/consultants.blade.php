@extends('admin-folder.layout')

@section('title', 'All Consultants')
@section('page-title', 'All Consultants')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">All Consultants</h2>
                <p class="text-gray-600">Manage and view all consultant accounts</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.consultants.pending') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Pending Approvals
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

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Consultants</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $consultants->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Verified</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $consultants->where('is_verified', true)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $consultants->where('is_verified', false)->where('is_rejected', false)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="GET" action="{{ route('admin.consultants') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Consultants</label>
                <input type="text" 
                       id="search" 
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search by name, email, or expertise..." 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="sm:w-48">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="status" 
                        name="status"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Status</option>
                    <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div class="sm:w-48">
                <label for="expertise" class="block text-sm font-medium text-gray-700 mb-2">Expertise</label>
                <select id="expertise" 
                        name="expertise"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Expertise</option>
                    <option value="Technology & IT Support" {{ request('expertise') === 'Technology & IT Support' ? 'selected' : '' }}>Technology & IT Support</option>
                    <option value="E-commerce Business" {{ request('expertise') === 'E-commerce Business' ? 'selected' : '' }}>E-commerce Business</option>
                    <option value="Marketing Business" {{ request('expertise') === 'Marketing Business' ? 'selected' : '' }}>Marketing Business</option>
                    <option value="Education & Career Coaching" {{ request('expertise') === 'Education & Career Coaching' ? 'selected' : '' }}>Education & Career Coaching</option>
                    <option value="Financial Business" {{ request('expertise') === 'Financial Business' ? 'selected' : '' }}>Financial Business</option>
                </select>
            </div>
            <div class="sm:w-32 flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition font-medium">
                    Search
                </button>
            </div>
            @if(request()->hasAny(['search', 'status', 'expertise']))
            <div class="sm:w-32 flex items-end">
                <a href="{{ route('admin.consultants') }}" class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition font-medium text-center">
                    Clear
                </a>
            </div>
            @endif
        </form>
    </div>

    <!-- Consultants Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Consultant Directory</h3>
            <p class="text-sm text-gray-600">Complete list of all registered consultants</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Consultant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expertise</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($consultants as $consultant)
                        @php
                            $ratings = \App\Models\ConsultationRating::whereHas('consultation', function($q) use ($consultant) {
                                $q->where('consultant_profile_id', $consultant->id);
                            })->where('rater_type', 'customer')->get();
                            $averageRating = $ratings->count() > 0 ? round($ratings->avg('rating'), 1) : null;
                            $totalRatings = $ratings->count();
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center text-xs font-medium text-gray-600 @if($consultant->is_rejected) ring-2 ring-red-500 @endif">
                                        @if($consultant->avatar_path)
                                            <img src="{{ asset('storage/'.$consultant->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                                        @else
                                            <span class="select-none font-semibold text-gray-500">{{ substr($consultant->full_name ?? $consultant->user->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $consultant->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $consultant->full_name ?? 'No full name' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $consultant->user->email }}</div>
                                <div class="text-sm text-gray-500">{{ $consultant->phone_number ?? 'No phone' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $expertise = $consultant->expertise ?? 'Not specified';
                                    if ($expertise !== 'Not specified' && !empty($expertise)) {
                                        $expertiseArray = array_map('trim', explode(',', $expertise));
                                        $expertiseArray = array_filter($expertiseArray, function($item) {
                                            return !empty(trim($item));
                                        });
                                    } else {
                                        $expertiseArray = [];
                                    }
                                @endphp
                                @if(!empty($expertiseArray))
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($expertiseArray as $exp)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                                </svg>
                                                {{ $exp }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                        </svg>
                                        Not specified
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    @if($consultant->is_verified)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Verified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @endif
                                    @if($consultant->has_pending_update)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 animate-pulse">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Update Requested
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($averageRating)
                                    <div class="flex items-center">
                                        <span class="text-yellow-500 text-sm mr-1">{{ number_format($averageRating, 1) }}</span>
                                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="text-xs text-gray-500 ml-1">({{ $totalRatings }})</span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">No ratings</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.consultants.show', $consultant->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition-colors border border-blue-200 hover:border-blue-300">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    View Profile
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <p class="text-gray-500 text-lg">No consultants found</p>
                                <p class="text-gray-400 text-sm">Consultants will appear here once they register</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($consultants->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $consultants->links() }}
            </div>
        @endif
    </div>
</div>

@endsection