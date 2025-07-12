<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoldenStation Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af',
                        secondary: '#64748b',
                        success: '#059669',
                        warning: '#d97706',
                        danger: '#dc2626',
                        info: '#0891b2'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-primary">
                            <i class="fas fa-gem mr-2"></i>GoldenStation
                        </h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="flex items-center text-gray-700 hover:text-primary focus:outline-none">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                        </button>
                    </div>
                    <div class="relative">
                        <button class="flex items-center text-gray-700 hover:text-primary focus:outline-none">
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'User' }}&background=1e40af&color=fff" alt="Profile">
                            <span class="ml-2">{{ auth()->user()->name ?? 'User' }}</span>
                            <i class="fas fa-chevron-down ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg min-h-screen">
            <div class="p-4">
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-primary bg-blue-50 rounded-lg">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('agents.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-users mr-3"></i>
                        Agents
                    </a>
                    <a href="{{ route('vendors.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-store mr-3"></i>
                        Vendors
                    </a>
                    <a href="{{ route('branches.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-map-marker-alt mr-3"></i>
                        Branches
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-calendar-check mr-3"></i>
                        Visits
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-box mr-3"></i>
                        Packages
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-chart-bar mr-3"></i>
                        Reports
                    </a>
                    @if(app()->environment('local'))
                    <a href="{{ route('telescope') }}" target="_blank" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-telescope mr-3"></i>
                        Telescope
                    </a>
                    @endif
                    <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-cog mr-3"></i>
                        Settings
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Dashboard</h2>
                <p class="text-gray-600 mt-2">Welcome back! Here's what's happening with your business today.</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Agents -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-primary">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-primary">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Agents</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['totalAgents'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-green-600 text-sm font-medium">
                            <i class="fas fa-arrow-up"></i> Active
                        </span>
                        <span class="text-gray-600 text-sm">agents in system</span>
                    </div>
                </div>

                <!-- Total Vendors -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-success">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-success">
                            <i class="fas fa-store text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Vendors</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['totalVendors'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-green-600 text-sm font-medium">
                            <i class="fas fa-arrow-up"></i> Registered
                        </span>
                        <span class="text-gray-600 text-sm">vendors</span>
                    </div>
                </div>

                <!-- Total Branches -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-warning">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-warning">
                            <i class="fas fa-map-marker-alt text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Branches</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['totalBranches'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-green-600 text-sm font-medium">
                            <i class="fas fa-arrow-up"></i> Active
                        </span>
                        <span class="text-gray-600 text-sm">branches</span>
                    </div>
                </div>

                <!-- Total Visits -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-info">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-cyan-100 text-info">
                            <i class="fas fa-calendar-check text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Visits</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['totalVisits'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-green-600 text-sm font-medium">
                            <i class="fas fa-arrow-up"></i> Completed
                        </span>
                        <span class="text-gray-600 text-sm">visits</span>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Visits Chart -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Monthly Visits</h3>
                            <p class="text-sm text-gray-500">Visit trends throughout the year</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">Total Visits</span>
                        </div>
                    </div>
                    <div class="relative" style="height: 300px;">
                        <canvas id="visitsChart"></canvas>
                    </div>
                    <div class="mt-4 grid grid-cols-3 gap-4 text-center">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <p class="text-2xl font-bold text-blue-600">{{ array_sum($monthlyVisits ?? []) }}</p>
                            <p class="text-xs text-gray-500">Total This Year</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <p class="text-2xl font-bold text-green-600">{{ max($monthlyVisits ?? [0]) }}</p>
                            <p class="text-xs text-gray-500">Peak Month</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <p class="text-2xl font-bold text-orange-600">{{ round(array_sum($monthlyVisits ?? [0]) / max(count($monthlyVisits ?? []), 1)) }}</p>
                            <p class="text-xs text-gray-500">Avg/Month</p>
                        </div>
                    </div>
                </div>

                <!-- Agent Performance -->
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

                    @if(($topAgents ?? collect())->count() > 0)
                        <div class="space-y-4">
                            @foreach($topAgents as $index => $agent)
                            <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-100 hover:shadow-md transition-shadow">
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
                                        <div class="flex items-center mt-1">
                                            <div class="flex items-center">
                                                <i class="fas fa-map-marker-alt text-green-500 text-xs mr-1"></i>
                                                <span class="text-xs text-gray-600">{{ $agent->vendor_visits_count }} visits</span>
                                            </div>
                                            @if($agent->vendor_visits_count > 0)
                                                <div class="ml-3 flex items-center">
                                                    <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                                                    <span class="text-xs text-gray-600">Top Performer</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-blue-600">{{ $agent->vendor_visits_count }}</div>
                                    <div class="text-xs text-gray-500">visits</div>
                                    @if($index === 0 && $agent->vendor_visits_count > 0)
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-crown mr-1"></i> #1
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-users text-gray-400 text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">No Agents Found</h4>
                            <p class="text-gray-500 mb-4">Start by adding some agents to see their performance here.</p>
                            <a href="{{ route('agents.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i> Add First Agent
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Activity & Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Activity -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                    <div class="space-y-4">
                        @forelse($recentActivity ?? [] as $activity)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-{{ $activity['color'] }}-100 rounded-full flex items-center justify-center">
                                    <i class="{{ $activity['icon'] }} text-{{ $activity['color'] }}-600 text-sm"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                                <p class="text-sm text-gray-500">{{ $activity['description'] }}</p>
                                <p class="text-xs text-gray-400">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-clock text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">No recent activity</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('vendors.create') }}" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="fas fa-plus-circle text-primary mr-3"></i>
                            Add New Vendor
                        </a>
                        <a href="{{ route('agents.create') }}" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="fas fa-user-plus text-success mr-3"></i>
                            Register Agent
                        </a>
                        <a href="{{ route('branches.create') }}" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="fas fa-map-marker-plus text-warning mr-3"></i>
                            Add Branch
                        </a>
                        <a href="#" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="fas fa-file-export text-info mr-3"></i>
                            Export Report
                        </a>
                        <a href="#" class="flex items-center p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="fas fa-cog text-secondary mr-3"></i>
                            System Settings
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Visits Chart with real data and improved design
        const ctx = document.getElementById('visitsChart').getContext('2d');

        // Get monthly visits data from PHP
        const monthlyVisitsData = @json($monthlyVisits ?? []);

        // Create labels for all months
        const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const visitData = [];

        // Fill in data for each month
        for (let i = 1; i <= 12; i++) {
            visitData.push(monthlyVisitsData[i] || 0);
        }

        // Create gradient for chart
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.05)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Visits',
                    data: visitData,
                    borderColor: '#3b82f6',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#1e40af',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#3b82f6',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            title: function(context) {
                                return context[0].label + ' Visits';
                            },
                            label: function(context) {
                                return context.parsed.y + ' visits';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            },
                            padding: 10
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            },
                            padding: 10
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        });
    </script>
</body>
</html>
