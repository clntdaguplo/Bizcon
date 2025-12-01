@extends('consultant-folder.layout')

@section('title', 'Consultant Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Welcome Section -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-600">You're now verified and ready to help clients. Manage appointments, respond to inquiries, and grow your consulting business.</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">{{ $stats['pending_consultations'] ?? 0 }}</div>
                <div class="text-sm text-blue-800">Pending Requests</div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">{{ $stats['accepted_consultations'] ?? 0 }}</div>
                <div class="text-sm text-green-800">Accepted</div>
            </div>
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2">{{ $stats['completed_consultations'] ?? 0 }}</div>
                <div class="text-sm text-purple-800">Completed</div>
            </div>
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-6 text-center">
                <div class="text-3xl font-bold text-orange-600 mb-2">{{ $stats['total_earnings'] ?? 0 }}</div>
                <div class="text-sm text-orange-800">Total Earnings</div>
            </div>
        </div>

        <!-- Main Widgets -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Consultations -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">Recent Consultations</h2>
                    <a href="{{ route('consultant.consultations') }}" class="text-blue-600 hover:underline text-sm">View All</a>
                </div>
                <div class="space-y-3">
                    @forelse($recent_consultations ?? [] as $consultation)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">{{ $consultation->customer->name ?? 'Unknown Customer' }}</div>
                                <div class="text-sm text-gray-600">{{ $consultation->topic }}</div>
                                @if($consultation->status === 'Completed' && $consultation->client_readiness_rating)
                                    <div class="flex items-center mt-1">
                                        <span class="text-xs text-gray-500 mr-1">Readiness:</span>
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $consultation->client_readiness_rating)
                                                <span class="text-yellow-500 text-xs">⭐</span>
                                            @else
                                                <span class="text-gray-300 text-xs">☆</span>
                                            @endif
                                        @endfor
                                    </div>
                                @endif
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($consultation->status === 'Pending') bg-yellow-100 text-yellow-800
                                @elseif($consultation->status === 'Accepted') bg-green-100 text-green-800
                                @elseif($consultation->status === 'Completed') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $consultation->status }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p>No consultations yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('consultant.consultations') }}" 
                       class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <div>
                            <div class="font-medium text-gray-900">View All Consultations</div>
                            <div class="text-sm text-gray-600">Manage your consultation requests</div>
                        </div>
                    </a>
                    <a href="{{ route('consultant.respond') }}" 
                       class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <div class="font-medium text-gray-900">Respond to Requests</div>
                            <div class="text-sm text-gray-600">Accept or reject consultation requests</div>
                        </div>
                    </a>
                    <a href="{{ route('consultant.profile.manage') }}" 
                       class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                        <svg class="w-6 h-6 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div>
                            <div class="font-medium text-gray-900">Update Profile</div>
                            <div class="text-sm text-gray-600">Manage your consultant profile</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection