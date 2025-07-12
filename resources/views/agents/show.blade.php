@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Agent Details</h1>
        <div class="flex space-x-3">
            <a href="{{ route('agents.edit', $agent) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-edit mr-2"></i> Edit Agent
            </a>
            <a href="{{ route('agents.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Agents
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Agent Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center mb-6">
            <img class="h-20 w-20 rounded-full mr-6" src="https://ui-avatars.com/api/?name={{ urlencode($agent->name) }}&background=1e40af&color=fff&size=80" alt="{{ $agent->name }}">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $agent->name }}</h2>
                <p class="text-gray-600">Agent #{{ str_pad($agent->id, 3, '0', STR_PAD_LEFT) }}</p>
                <p class="text-sm text-gray-500">Member since {{ $agent->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
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

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Location Information</h3>
                <div class="space-y-3">
                    @if($agent->last_latitude && $agent->last_longitude)
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-red-500 mr-3 w-5"></i>
                            <span class="text-gray-700">Active Location</span>
                        </div>
                        <div class="ml-8 text-sm text-gray-600">
                            {{ number_format($agent->last_latitude, 4) }}, {{ number_format($agent->last_longitude, 4) }}
                        </div>
                    @else
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-3 w-5"></i>
                            <span class="text-gray-500">No location data</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Visits -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Vendor Visits</h3>

        @if($agent->vendorVisits->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Branch</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visit Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($agent->vendorVisits->take(10) as $visit)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $visit->vendor->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $visit->branch->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $visit->created_at->format('M d, Y H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Completed
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">No visits recorded yet</p>
            </div>
        @endif
    </div>
</div>
@endsection
