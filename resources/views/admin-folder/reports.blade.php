@extends('admin-folder.layout')

@section('title', 'Reports & Analytics')
@section('page-title', 'Reports Center')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg">
        <h1 class="text-2xl font-bold mb-2">Reports Center</h1>
        <p class="text-blue-100">Generate and export detailed insights about your platform's performance.</p>
    </div>

    <!-- Revenue Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Total Revenue</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">₱{{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-green-500">
            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Weekly Plan</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">₱{{ number_format($weeklyRevenue, 2) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-purple-500">
            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Quarterly Plan</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">₱{{ number_format($quarterlyRevenue, 2) }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-amber-500">
            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Annual Plan</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">₱{{ number_format($annualRevenue, 2) }}</p>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Trend Chart -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-8">
                <div class="text-center">
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Sessions/Month</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $thisMonthCount }}</p>
                </div>
                <div class="text-center border-l border-r border-gray-100 px-4">
                     <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Avg</p>
                     <p class="text-2xl font-bold text-gray-900 mt-1">{{ $avgMonth }}</p>
                </div>
                 <div class="text-center">
                     <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Trend</p>
                     <p class="text-2xl font-bold mt-1 {{ $trendPercent >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        {{ $trendPercent > 0 ? '+' : '' }}{{ $trendPercent }}%
                     </p>
                </div>
            </div>
            
            <div class="h-64 relative w-full">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Revenue Breakdown Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Revenue by Plan</h3>
            <div class="flex flex-col space-y-2 mb-4">
                @foreach($revenueLabels as $index => $label)
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center space-x-2">
                             <div class="w-2 h-2 rounded-full" style="background-color: {{ ['#10B981', '#8B5CF6', '#F59E0B'][$index % 3] }}"></div>
                             <span class="text-gray-600">{{ $label }}</span>
                        </div>
                        <span class="font-bold text-gray-900">₱{{ number_format($revenueChartData[$index], 0) }}</span>
                    </div>
                @endforeach
            </div>
            
            <div class="relative flex-1 flex items-center justify-center min-h-[150px]">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Expertise Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Expertise Breakdown</h3>
            <div class="flex flex-col space-y-2 mb-4 overflow-y-auto max-h-32 custom-scrollbar">
                @foreach($expertiseLabels as $index => $label)
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center space-x-2">
                             <div class="w-2 h-2 rounded-full" style="background-color: {{ ['#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#6B7280'][$index % 6] }}"></div>
                             <span class="text-gray-600 truncate max-w-[80px]" title="{{ $label }}">{{ $label }}</span>
                        </div>
                        <span class="font-bold text-gray-900">{{ $expertiseData[$index] }}</span>
                    </div>
                @endforeach
            </div>
            
            <div class="relative flex-1 flex items-center justify-center min-h-[150px]">
                <canvas id="expertiseChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Customer Satisfaction -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Customer Satisfaction</h3>
        <div class="flex flex-col md:flex-row items-center">
            <!-- Average Rating -->
            <div class="flex-shrink-0 text-center px-8 md:border-r border-gray-100 mb-6 md:mb-0 w-full md:w-auto">
                <p class="text-5xl font-extrabold text-yellow-400">{{ $avgRating }}</p>
                <div class="flex items-center justify-center mt-2 space-x-1">
                    @for($i=1; $i<=5; $i++)
                        <svg class="w-5 h-5 {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-sm text-gray-400 mt-2 font-medium">{{ $totalRatings }} Verified Reviews</p>
            </div>
            
            <!-- Rating Bars -->
            <div class="flex-1 w-full pl-0 md:pl-10 space-y-3">
                @for($i=0; $i<5; $i++)
                <div class="flex items-center">
                    <span class="text-sm font-medium text-gray-500 w-12">{{ 5-$i }} Star</span>
                    <div class="flex-1 h-2.5 bg-gray-100 rounded-full mx-3 overflow-hidden">
                        <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $totalRatings > 0 ? ($starCounts[$i]/$totalRatings)*100 : 0 }}%"></div>
                    </div>
                    <span class="text-sm font-bold text-gray-700 w-8 text-right">{{ $starCounts[$i] }}</span>
                </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Export Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Custom Range Report -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 flex flex-col hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Custom Report</h3>
            <p class="text-sm text-gray-500 mb-4 flex-1">Export detailed data for any specific date range.</p>
            
            <form action="{{ route('admin.reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="type" value="custom">
                <div class="space-y-3 mb-4">
                    <div>
                        <label class="text-xs text-gray-400 uppercase font-semibold mb-1 block">Start Date</label>
                        <input type="date" name="start_date" class="w-full text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50" value="{{ now()->startOfWeek()->format('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 uppercase font-semibold mb-1 block">End Date</label>
                        <input type="date" name="end_date" class="w-full text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50" value="{{ now()->endOfWeek()->format('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 uppercase font-semibold mb-1 block">Filter by Expertise</label>
                        <select name="expertise" class="w-full text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2 bg-gray-50 border">
                            <option value="all">All Expertise Areas</option>
                            @foreach($expertiseList as $exp)
                                <option value="{{ $exp }}">{{ $exp }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-3 gap-2">
                    <button type="submit" name="format" value="csv" class="flex flex-col items-center justify-center p-2 border border-gray-200 rounded-lg hover:bg-gray-50 text-xs font-medium text-gray-600 transition group">
                        <span class="mb-1">CSV</span>
                    </button>
                    <button type="submit" name="format" value="excel" class="flex flex-col items-center justify-center p-2 border border-green-200 rounded-lg hover:bg-green-50 text-xs font-medium text-green-700 bg-green-50/30 transition group">
                        <span class="mb-1">Excel</span>
                    </button>
                    <button type="submit" name="format" value="pdf" formtarget="_blank" class="flex flex-col items-center justify-center p-2 border border-red-200 rounded-lg hover:bg-red-50 text-xs font-medium text-red-700 bg-red-50/30 transition group">
                        <span class="mb-1">PDF</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Monthly Report Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 flex flex-col hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Monthly Report</h3>
            <p class="text-sm text-gray-500 mb-6 flex-1">Export data for a specific month or entire year.</p>
            
            <form action="{{ route('admin.reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="type" value="monthly">
                <div class="mb-4 space-y-3">
                    <div>
                        <label class="text-xs text-gray-400 uppercase font-semibold mb-1 block">Select Month</label>
                        <select name="month" class="w-full text-sm border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 px-3 py-2 bg-gray-50 border">
                            <option value="all">All Months (Annual)</option>
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ now()->month == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                     <div>
                        <label class="text-xs text-gray-400 uppercase font-semibold mb-1 block">Select Year</label>
                        <select name="year" class="w-full text-sm border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 px-3 py-2 bg-gray-50 border">
                            @foreach(range(now()->year, now()->year - 2) as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 uppercase font-semibold mb-1 block">Filter by Expertise</label>
                        <select name="expertise" class="w-full text-sm border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 px-3 py-2 bg-gray-50 border">
                            <option value="all">All Expertise Areas</option>
                            @foreach($expertiseList as $exp)
                                <option value="{{ $exp }}">{{ $exp }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-3 gap-2">
                    <button type="submit" name="format" value="csv" class="flex flex-col items-center justify-center p-2 border border-gray-200 rounded-lg hover:bg-gray-50 text-xs font-medium text-gray-600 transition">
                        <span class="mb-1">CSV</span>
                    </button>
                    <button type="submit" name="format" value="excel" class="flex flex-col items-center justify-center p-2 border border-green-200 rounded-lg hover:bg-green-50 text-xs font-medium text-green-700 bg-green-50/50 transition">
                        <span class="mb-1">Excel</span>
                    </button>
                    <button type="submit" name="format" value="pdf" formtarget="_blank" class="flex flex-col items-center justify-center p-2 border border-red-200 rounded-lg hover:bg-red-50 text-xs font-medium text-red-700 bg-red-50/50 transition">
                        <span class="mb-1">PDF</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Consolidated Report Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 flex flex-col hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Consolidated Report</h3>
            <p class="text-sm text-gray-500 mb-6 flex-1">Generate a yearly summary displaying total data grouped by month.</p>
            
            <form action="{{ route('admin.reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="type" value="consolidated">
                <div class="mb-4">
                    <label class="text-xs text-gray-400 uppercase font-semibold mb-1 block">Select Year</label>
                    <select name="year" class="w-full text-sm border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 px-3 py-2 bg-gray-50 border">
                        @foreach(range(now()->year, now()->year - 2) as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="grid grid-cols-3 gap-2 mt-auto">
                    <button type="submit" name="format" value="csv" class="flex flex-col items-center justify-center p-2 border border-gray-200 rounded-lg hover:bg-gray-50 text-xs font-medium text-gray-600 transition">
                        <span class="mb-1">CSV</span>
                    </button>
                    <button type="submit" name="format" value="excel" class="flex flex-col items-center justify-center p-2 border border-green-200 rounded-lg hover:bg-green-50 text-xs font-medium text-green-700 bg-green-50/50 transition">
                        <span class="mb-1">Excel</span>
                    </button>
                    <button type="submit" name="format" value="pdf" formtarget="_blank" class="flex flex-col items-center justify-center p-2 border border-red-200 rounded-lg hover:bg-red-50 text-xs font-medium text-red-700 bg-red-50/50 transition">
                        <span class="mb-1">PDF</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Trend Chart
        const trendCanvas = document.getElementById('trendChart');
        if (trendCanvas) {
            const ctxTrend = trendCanvas.getContext('2d');
            const gradient = ctxTrend.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');
            
            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: 'Completed Consultations',
                        data: {!! json_encode($dataPoints) !!},
                        borderColor: '#4F46E5', // Indigo 600
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#4F46E5',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1F2937',
                            padding: 12,
                            titleFont: { size: 13 },
                            bodyFont: { size: 13 },
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Sessions';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 2], drawBorder: false },
                            ticks: { display: true }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // Expertise Chart
        const expertiseCanvas = document.getElementById('expertiseChart');
        if (expertiseCanvas) {
            const ctxExpertise = expertiseCanvas.getContext('2d');
            new Chart(ctxExpertise, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($expertiseLabels) !!},
                    datasets: [{
                        data: {!! json_encode($expertiseData) !!},
                        backgroundColor: ['#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#6B7280'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1F2937',
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + context.parsed;
                                }
                            }
                        }
                    }
                }
            });
        }
        // Revenue Chart
        const revenueCanvas = document.getElementById('revenueChart');
        if (revenueCanvas) {
            const ctxRevenue = revenueCanvas.getContext('2d');
            new Chart(ctxRevenue, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($revenueLabels) !!},
                    datasets: [{
                        data: {!! json_encode($revenueChartData) !!},
                        backgroundColor: ['#10B981', '#8B5CF6', '#F59E0B'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1F2937',
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    return ' ₱' + context.parsed.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
