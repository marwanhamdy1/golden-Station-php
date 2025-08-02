@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ __('agents.agent_details') }}</h1>
        <div class="flex space-x-3">
            <a href="{{ route('agents.edit', $agent) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-edit mr-2"></i> {{ __('agents.edit_agent') }}
            </a>
            <a href="{{ route('agents.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> {{ __('agents.back_to_agents') }}
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Agent Profile Card -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="flex flex-col md:flex-row items-start md:items-center mb-6">
            <div class="flex items-center mb-4 md:mb-0">
                <img class="h-24 w-24 rounded-full mr-6 border-4 border-blue-100"
                     src="https://ui-avatars.com/api/?name={{ urlencode($agent->name) }}&background=1e40af&color=fff&size=96"
                     alt="{{ $agent->name }}">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-1">{{ $agent->name }}</h2>
                    <p class="text-gray-600 text-lg">{{ __('Agent') }} #{{ str_pad($agent->id, 3, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-sm text-gray-500">{{ __('agents.member_since') }} {{ $agent->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">{{ __('agents.total_visits') }}</p>
                        <p class="text-2xl font-bold">{{ number_format($statistics['total_visits']) }}</p>
                    </div>
                    <i class="fas fa-calendar-check text-blue-200 text-2xl"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">{{ __('agents.total_branches') }}</p>
                        <p class="text-2xl font-bold">{{ number_format($statistics['total_branches']) }}</p>
                    </div>
                    <i class="fas fa-building text-green-200 text-2xl"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm">{{ __('agents.this_week') }}</p>
                        <p class="text-2xl font-bold">{{ number_format($statistics['recent_visits']) }}</p>
                    </div>
                    <i class="fas fa-clock text-purple-200 text-2xl"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm">{{ __('agents.this_month') }}</p>
                        <p class="text-2xl font-bold">{{ number_format($statistics['this_month_visits']) }}</p>
                    </div>
                    <i class="fas fa-chart-line text-orange-200 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Contact & Location Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-address-card mr-2 text-blue-600"></i>
                    {{ __('agents.contact_information') }}
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700">{{ $agent->email }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-phone text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700">{{ $agent->phone }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-map-marker-alt mr-2 text-red-600"></i>
                    {{ __('agents.location_information') }}
                </h3>
                <div class="space-y-3">
                    @if($agent->last_latitude && $agent->last_longitude)
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-red-500 mr-3 w-5"></i>
                            <span class="text-gray-700">{{ __('agents.active_location') }}</span>
                        </div>
                        <div class="ml-8 text-sm text-gray-600 font-mono">
                            {{ number_format($agent->last_latitude, 6) }}, {{ number_format($agent->last_longitude, 6) }}
                        </div>
                        <div class="ml-8">
                            <a href="https://maps.google.com/?q={{ $agent->last_latitude }},{{ $agent->last_longitude }}"
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                <i class="fas fa-external-link-alt mr-1"></i>
                                {{ __('agents.view_on_map') }}
                            </a>
                        </div>
                    @else
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-3 w-5"></i>
                            <span class="text-gray-500">{{ __('agents.no_location_data') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tabbed Content -->
    <div class="bg-white rounded-xl shadow-lg">
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <a href="{{ route('agents.show', ['agent' => $agent, 'tab' => 'overview']) }}"
                   class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'overview' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-chart-pie mr-2"></i>
                    {{ __('agents.overview') }}
                </a>
                <a href="{{ route('agents.show', ['agent' => $agent, 'tab' => 'visits']) }}"
                   class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'visits' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    {{ __('agents.vendor_visits') }} ({{ number_format($statistics['total_visits']) }})
                </a>
                <a href="{{ route('agents.show', ['agent' => $agent, 'tab' => 'branches']) }}"
                   class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'branches' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-building mr-2"></i>
                    {{ __('agents.branches') }} ({{ number_format($statistics['total_branches']) }})
                </a>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            @if($activeTab === 'overview')
                @include('agents.partials.overview', ['agent' => $agent, 'vendorVisits' => $vendorVisits, 'branches' => $branches])
            @elseif($activeTab === 'visits')
                @include('agents.partials.visits', ['agent' => $agent, 'vendorVisits' => $vendorVisits])
            @elseif($activeTab === 'branches')
                @include('agents.partials.branches', ['agent' => $agent, 'branches' => $branches])
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-refresh location if needed
    @if($agent->last_latitude && $agent->last_longitude)
    console.log('Agent last known location:', {{ $agent->last_latitude }}, {{ $agent->last_longitude }});
    @endif
</script>
@endpush
@endsection