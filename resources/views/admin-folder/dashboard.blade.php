@extends('admin-folder.layout')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome back, {{ Auth::user()->name }}!</h2>
        <p class="text-gray-600">Here's what's happening with your platform today.</p>
    </div>

    <!-- Key Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending Approvals</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $pendingApprovals ?? 0 }}</p>
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
                    <p class="text-sm font-medium text-gray-600">Active Consultants</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $consultants->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Customers</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $customers->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Consultations</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalConsultations ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Users Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Right Column: Recent Consultants and Customers -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Recent Consultants -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Consultants</h3>
                    <p class="text-sm text-gray-600">Latest consultant registrations</p>
                </div>
                <div class="p-6">
                    @forelse($consultants->take(5) as $consultant)
                        <div class="flex items-center py-3 border-b border-gray-100 last:border-b-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 @if($consultant->is_rejected) ring-2 ring-red-500 @endif">
                                <span class="text-sm font-medium text-blue-600">{{ substr($consultant->full_name ?? $consultant->user->name ?? 'C', 0, 1) }}</span>
                            </div>
                            <div class="ml-4 flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $consultant->full_name ?? $consultant->user->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $consultant->expertise ?? 'No expertise set' }}</p>
                            </div>
                            <div class="text-right flex-shrink-0 ml-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Verified
                                </span>
                                <p class="text-xs text-gray-500 mt-1 whitespace-nowrap">{{ $consultant->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <p class="text-gray-500">No consultants yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Customers -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Customers</h3>
                    <p class="text-sm text-gray-600">Latest customer registrations</p>
                </div>
                <div class="p-6">
                    @forelse($customers->take(5) as $customer)
                        <div class="flex items-center py-3 border-b border-gray-100 last:border-b-0">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-green-600">{{ substr($customer->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $customer->name }}</p>
                                <p class="text-xs text-gray-500">{{ $customer->email }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Active
                                </span>
                                <p class="text-xs text-gray-500 mt-1">{{ $customer->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="text-gray-500">No customers yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monthly Consultations Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Monthly Consultations</h3>
            <div class="relative h-48">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Status Breakdown Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Breakdown</h3>
            <div class="relative h-48">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Topics and Most Booked Consultant -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Most Common Topics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Most Common Topics</h3>
            @if($topTopics && $topTopics->count() > 0)
                <div class="space-y-3">
                    @foreach($topTopics as $topic => $count)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700">{{ $topic }}</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No consultation topics yet</p>
            @endif
        </div>

        <!-- Most Booked Consultant -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Most Booked Consultant</h3>
            @if($mostBookedConsultant)
                <div class="text-center py-8">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ $mostBookedConsultant['count'] }}</div>
                    <p class="text-lg text-gray-700 mb-1">{{ $mostBookedConsultant['consultant'] }}</p>
                    <p class="text-sm text-gray-500">Total Consultations</p>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No consultations yet</p>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.manage-users') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="p-2 bg-blue-100 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Manage Users</p>
                    <p class="text-sm text-gray-500">Approve & manage</p>
                </div>
            </a>

            <a href="{{ route('admin.consultations') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="p-2 bg-green-100 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Consultations</p>
                    <p class="text-sm text-gray-500">Monitor sessions</p>
                </div>
            </a>

            <a href="{{ route('admin.reports') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="p-2 bg-purple-100 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Reports</p>
                    <p class="text-sm text-gray-500">View analytics</p>
                </div>
            </a>

            <a href="{{ route('admin.settings') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="p-2 bg-gray-100 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Settings</p>
                    <p class="text-sm text-gray-500">Configure system</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Consultations Chart
    const monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx) {
        const monthlyData = @json($monthlyData ?? []);
        new Chart(monthlyCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: monthlyData.map(d => d.month),
                datasets: [{
                    label: 'Consultations',
                    data: monthlyData.map(d => d.count),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Status Breakdown Chart
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        const statusData = @json($statusBreakdown ?? []);
        new Chart(statusCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusData),
                datasets: [{
                    data: Object.values(statusData),
                    backgroundColor: [
                        'rgb(59, 130, 246)',   // Blue for Pending
                        'rgb(16, 185, 129)',   // Green for Accepted
                        'rgb(139, 92, 246)',   // Purple for Completed
                        'rgb(239, 68, 68)',    // Red for Rejected
                        'rgb(156, 163, 175)'   // Gray for others
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
</script>
@endsection