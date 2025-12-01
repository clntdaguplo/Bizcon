@extends('admin-folder.layout')

@section('title', 'Reports & Analytics')
@section('page-title', 'Reports & Analytics')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Reports & Analytics</h2>
        <p class="text-gray-600">Comprehensive insights and performance metrics</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-semibold text-gray-900">$0</p>
                    <p class="text-xs text-gray-500">No revenue data available</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Sessions</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $consultations->count() }}</p>
                    <p class="text-xs text-gray-500">Total consultation sessions</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Active Consultants</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $consultants->count() }}</p>
                    <p class="text-xs text-gray-500">Verified consultants</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Customers</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $customers->count() }}</p>
                    <p class="text-xs text-gray-500">Registered customers</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Date Range -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label for="date-range" class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                <select id="date-range" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="7">Last 7 days</option>
                    <option value="30" selected>Last 30 days</option>
                    <option value="90">Last 90 days</option>
                    <option value="365">Last year</option>
                </select>
            </div>
            <div class="sm:w-48">
                <label for="report-type" class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                <select id="report-type" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="overview">Overview</option>
                    <option value="consultants">Consultant Performance</option>
                    <option value="customers">Customer Analytics</option>
                    <option value="sessions">Session Analytics</option>
                </select>
            </div>
            <div class="sm:w-32">
                <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Generate
                </button>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Revenue Trend</h3>
                <p class="text-sm text-gray-600">Monthly revenue performance</p>
            </div>
            <div class="p-6">
                <div class="h-64">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Session Distribution -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Session Distribution</h3>
                <p class="text-sm text-gray-600">By consultant expertise</p>
            </div>
            <div class="p-6">
                <div class="h-64">
                    <canvas id="sessionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performers and Service Performance -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Consultants -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Top Performing Consultants</h3>
                <p class="text-sm text-gray-600">Based on session count</p>
            </div>
            <div class="p-6">
                @php
                    $topConsultants = $consultants->map(function($consultant) use ($consultations) {
                        $sessionCount = $consultations->where('consultant_profile_id', $consultant->id)->count();
                        return [
                            'consultant' => $consultant,
                            'sessions' => $sessionCount
                        ];
                    })->sortByDesc('sessions')->take(5);
                @endphp
                @if($topConsultants->where('sessions', '>', 0)->count() > 0)
                    <div class="space-y-4">
                        @foreach($topConsultants->where('sessions', '>', 0) as $item)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-blue-600">{{ substr($item['consultant']->user->name ?? 'N/A', 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $item['consultant']->user->name ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500">{{ $item['consultant']->expertise ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">{{ $item['sessions'] }} {{ $item['sessions'] === 1 ? 'session' : 'sessions' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg">No consultant performance data</p>
                        <p class="text-gray-400 text-sm">Consultants will appear here once they have sessions</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Service Performance -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Service Performance</h3>
                <p class="text-sm text-gray-600">Popularity by expertise/topic</p>
            </div>
            <div class="p-6">
                @php
                    $topics = $consultations->groupBy('topic')->map(function($items, $topic) use ($consultations) {
                        $count = $items->count();
                        $total = $consultations->count();
                        $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
                        return [
                            'topic' => $topic,
                            'count' => $count,
                            'percentage' => $percentage
                        ];
                    })->sortByDesc('count')->take(5);
                @endphp
                @if($topics->count() > 0)
                    <div class="space-y-4">
                        @foreach($topics as $topicData)
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $topicData['topic'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $topicData['count'] }} {{ $topicData['count'] === 1 ? 'session' : 'sessions' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">{{ $topicData['percentage'] }}%</p>
                                    <div class="w-20 bg-gray-200 rounded-full h-2 mt-1">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $topicData['percentage'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg">No service performance data</p>
                        <p class="text-gray-400 text-sm">Service statistics will appear here once consultations are created</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Export Options -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Export Reports</h3>
        <div class="flex flex-wrap gap-4">
            <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export PDF
            </button>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Excel
            </button>
            <button class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                Export CSV
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue Chart - Empty for now
const revenueCtx = document.getElementById('revenueChart');
if (revenueCtx) {
    new Chart(revenueCtx.getContext('2d'), {
        type: 'line',
        data: {
            labels: ['No data available'],
            datasets: [{
                label: 'Revenue ($)',
                data: [0],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Session Distribution Chart (by consultant expertise)
@php
    $expertiseGroups = $consultations->groupBy(function($consultation) {
        return $consultation->consultantProfile?->expertise ?? 'Unknown';
    })->take(4);
    $expertiseLabels = $expertiseGroups->keys()->toArray();
    $expertiseCounts = $expertiseGroups->map->count()->values()->toArray();
@endphp
const sessionCtx = document.getElementById('sessionChart');
if (sessionCtx) {
    new Chart(sessionCtx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($expertiseLabels ?: ['No data']) !!},
            datasets: [{
                data: {!! json_encode($expertiseCounts ?: [0]) !!},
                backgroundColor: [
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(139, 92, 246)',
                    'rgb(156, 163, 175)'
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