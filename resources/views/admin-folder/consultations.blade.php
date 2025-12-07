@extends('admin-folder.layout')

@section('title', 'Consultations')
@section('page-title', 'Consultation Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-lg p-8">
        <div class="flex items-center">
            <div class="bg-white bg-opacity-20 p-4 rounded-xl mr-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">Consultation Management</h2>
                <p class="text-blue-100">Monitor and manage all consultation sessions</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Sessions</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalCount ?? $consultations->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Completed</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $completedCount ?? 0 }}</p>
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
                    <p class="text-sm font-medium text-gray-600">In Progress</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $inProgressCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Cancelled</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $cancelledCount ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Search -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.consultations') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Sessions</label>
                <input type="text" 
                       id="search" 
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search by consultant, customer, or topic..." 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="sm:w-48">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="status" 
                        name="status"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in-progress" {{ request('status') === 'in-progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="sm:w-48">
                <label for="date_filter" class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                <select id="date_filter" 
                        name="date_filter"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Time</option>
                    <option value="today" {{ request('date_filter') === 'today' ? 'selected' : '' }}>Today</option>
                    <option value="week" {{ request('date_filter') === 'week' ? 'selected' : '' }}>This Week</option>
                    <option value="month" {{ request('date_filter') === 'month' ? 'selected' : '' }}>This Month</option>
                </select>
            </div>
            <div class="sm:w-32 flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition font-medium">
                    Search
                </button>
            </div>
            @if(request()->hasAny(['search', 'status', 'date_filter']))
            <div class="sm:w-32 flex items-end">
                <a href="{{ route('admin.consultations') }}" class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition font-medium text-center">
                    Clear
                </a>
            </div>
            @endif
        </form>
    </div>

    <!-- Sessions Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-xl">
            <div class="flex items-center">
                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Consultation Sessions</h3>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Session ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Consultant</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Topic</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($consultations as $consultation)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                    #{{ str_pad($consultation->id, 6, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full overflow-hidden bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                        @if($consultation->consultantProfile->avatar_path)
                                            <img src="{{ asset('storage/'.$consultation->consultantProfile->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xs font-semibold text-blue-700">{{ substr($consultation->consultantProfile->user->name ?? 'N/A', 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $consultation->consultantProfile->user->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">
                                            @if($consultation->consultantProfile->expertise)
                                                @php
                                                    $expertiseArray = array_map('trim', explode(',', $consultation->consultantProfile->expertise));
                                                    $firstExpertise = $expertiseArray[0] ?? 'N/A';
                                                @endphp
                                                {{ $firstExpertise }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full overflow-hidden bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                                        @if($consultation->customer->avatar_path ?? null)
                                            <img src="{{ asset('storage/'.$consultation->customer->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xs font-semibold text-green-700">{{ substr($consultation->customer->name ?? 'N/A', 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $consultation->customer->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $consultation->customer->email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                    {{ $consultation->topic }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($consultation->preferred_date && $consultation->preferred_time)
                                    <div class="flex items-center text-sm text-gray-900">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="font-medium">{{ \Carbon\Carbon::parse($consultation->preferred_date)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center text-xs text-gray-500 mt-1">
                                        <svg class="w-3 h-3 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($consultation->preferred_time)->format('g:i A') }}
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Not scheduled</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($consultation->status === 'Completed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Completed
                                    </span>
                                @elseif($consultation->status === 'Accepted')
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        In Progress
                                    </span>
                                @elseif($consultation->status === 'Cancelled')
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Cancelled
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $consultation->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.consultations.show', $consultation->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition-colors border border-blue-200 hover:border-blue-300">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-500 text-lg">No consultation sessions found</p>
                                <p class="text-gray-400 text-sm">Consultation sessions will appear here once they are created</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($consultations->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $consultations->links() }}
            </div>
        @endif
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-blue-50 rounded-t-xl">
            <div class="flex items-center">
                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
            </div>
            <p class="text-sm text-gray-600 mt-1">Latest session completions and status changes</p>
        </div>
        <div class="p-6">
            @if(isset($recentActivity) && $recentActivity->count() > 0)
                <div class="space-y-4">
                    @foreach($recentActivity->take(10) as $activity)
                        <div class="flex items-start space-x-4 p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <div class="flex-shrink-0">
                                @if($activity->status === 'Completed')
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-md">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                @elseif($activity->status === 'Accepted')
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center shadow-md">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                @elseif($activity->status === 'Cancelled')
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center shadow-md">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-md">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                @if($activity->status === 'Completed')
                                    <div class="flex items-center mb-1">
                                        <p class="text-sm font-semibold text-gray-900">
                                            <span class="text-green-600">✓ Session Completed</span>
                                        </p>
                                    </div>
                                    <p class="text-sm text-gray-700 mb-1">
                                        <span class="font-medium">{{ $activity->consultantProfile->user->name ?? 'Consultant' }}</span> 
                                        completed session with 
                                        <span class="font-medium">{{ $activity->customer->name ?? 'Customer' }}</span>
                                    </p>
                                    <p class="text-xs text-gray-600 mb-2">
                                        Topic: <span class="font-medium text-gray-900">{{ $activity->topic }}</span>
                                    </p>
                                    @if($activity->consultation_summary)
                                        <p class="text-xs text-gray-500 italic mb-2">
                                            Report available: {{ Str::limit($activity->consultation_summary, 80) }}
                                        </p>
                                    @endif
                                    <div class="flex items-center justify-between mt-2">
                                        <p class="text-xs text-gray-500">
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Completed {{ $activity->updated_at->diffForHumans() }}
                                        </p>
                                        <a href="{{ route('admin.consultations.show', $activity->id) }}" 
                                           class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                            View Details →
                                        </a>
                                    </div>
                                @else
                                    <div class="flex items-center mb-1">
                                        <p class="text-sm font-semibold text-gray-900">
                                            Status Changed: <span class="capitalize">{{ strtolower($activity->status) }}</span>
                                        </p>
                                    </div>
                                    <p class="text-sm text-gray-700 mb-1">
                                        Consultation for 
                                        <span class="font-medium">{{ $activity->topic }}</span>
                                        @if($activity->customer)
                                            with <span class="font-medium">{{ $activity->customer->name }}</span>
                                        @endif
                                    </p>
                                    <div class="flex items-center justify-between mt-2">
                                        <p class="text-xs text-gray-500">
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Updated {{ $activity->updated_at->diffForHumans() }}
                                        </p>
                                        <a href="{{ route('admin.consultations.show', $activity->id) }}" 
                                           class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                            View Details →
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <p class="text-gray-500 font-medium">No recent activity</p>
                    <p class="text-gray-400 text-sm mt-1">Session completions and status changes will appear here</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection