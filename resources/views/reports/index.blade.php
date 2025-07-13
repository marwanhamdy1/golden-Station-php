@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Reports & Analytics</h1>
        <p class="text-gray-600 mt-2">Comprehensive insights into your business performance</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-calendar-check text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Visits</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['totalVisits'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-store text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Vendors</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['totalVendors'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Agents</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['totalAgents'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-box text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Packages</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['totalPackages'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Monthly Visits Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Monthly Visits</h3>
                    <p class="text-sm text-gray-500">Visit trends throughout the year</p>
                </div>
            </div>
            <div class="relative" style="height: 300px;">
                <canvas id="monthlyVisitsChart"></canvas>
            </div>
        </div>

        <!-- Visit Status Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Visit Status Distribution</h3>
                    <p class="text-sm text-gray-500">Breakdown by visit status</p>
                </div>
            </div>
            <div class="relative" style="height: 300px;">
                <canvas id="visitStatusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Agents and Vendor Ratings -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Top Performing Agents -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Top Performing Agents</h3>
                    <p class="text-sm text-gray-500">Agents with highest visit counts</p>
                </div>
                <a href="{{ route('agents.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            @if($topAgents->count() > 0)
                <div class="space-y-4">
                    @foreach($topAgents as $index => $agent)
                    <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-100">
                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full text-white font-bold text-lg mr-4">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex items-center flex-1">
                            <img class="h-12 w-12 rounded-full border-2 border-gray-200"
                                 src="https://ui-avatars.com/api/?name={{ urlencode($agent->name) }}&background=1e40af&color=fff&size=48"
                                 alt="{{ $agent->name }}">
                            <div class="ml-4 flex-1">
                                <h4 class="text-sm font-semibold text-gray-900">{{ $agent->name }}</h4>
                                <p class="text-xs text-gray-500">Agent #{{ str_pad($agent->id, 3, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-blue-600">{{ $agent->vendor_visits_count }}</p>
                                <p class="text-xs text-gray-500">visits</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">No agent data available</p>
                </div>
            @endif
        </div>

        <!-- Vendor Ratings -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Vendor Ratings</h3>
                    <p class="text-sm text-gray-500">Distribution of vendor interest levels</p>
                </div>
            </div>

            @if($vendorRatings->count() > 0)
                <div class="space-y-4">
                    @foreach($vendorRatings as $rating)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            @php
                                $ratingColors = [
                                    'very_interested' => 'text-green-600',
                                    'hesitant' => 'text-yellow-600',
                                    'refused' => 'text-red-600',
                                    'inappropriate' => 'text-red-600'
                                ];
                                $color = $ratingColors[$rating->vendor_rating] ?? 'text-gray-600';
                            @endphp
                            <span class="w-3 h-3 rounded-full bg-current {{ $color }} mr-3"></span>
                            <span class="text-sm font-medium text-gray-700">
                                {{ ucfirst(str_replace('_', ' ', $rating->vendor_rating)) }}
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-gray-900">{{ $rating->count }}</p>
                            <p class="text-xs text-gray-500">vendors</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-chart-pie text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">No rating data available</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Visits Chart
const monthlyVisitsCtx = document.getElementById('monthlyVisitsChart').getContext('2d');
new Chart(monthlyVisitsCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Visits',
            data: @json(array_values($monthlyVisits)),
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Visit Status Chart
const visitStatusCtx = document.getElementById('visitStatusChart').getContext('2d');
new Chart(visitStatusCtx, {
    type: 'doughnut',
    data: {
        labels: @json($visitStats->pluck('visit_status')->map(function($status) { return ucfirst(str_replace('_', ' ', $status)); })),
        datasets: [{
            data: @json($visitStats->pluck('count')),
            backgroundColor: [
                'rgb(34, 197, 94)',
                'rgb(59, 130, 246)',
                'rgb(234, 179, 8)',
                'rgb(239, 68, 68)'
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
</script>
@endsection
