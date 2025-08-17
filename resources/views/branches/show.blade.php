@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ __('branches.branch_details') }}</h1>
        <div class="flex space-x-3">
            <a href="{{ route('branches.edit', $branch) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-edit mr-2"></i> {{ __('branches.edit') }}
            </a>
            <a href="{{ route('branches.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> {{ __('branches.back') }}
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Branch Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center mb-6">
            <div class="h-20 w-20 bg-green-100 rounded-lg flex items-center justify-center mr-6">
                <i class="fas fa-map-marker-alt text-3xl text-green-600"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $branch->name }}</h2>
                <p class="text-gray-600">{{ __('branches.branch') }} #{{ $branch->id }}</p>
                <p class="text-sm text-gray-500">{{ __('branches.created_at', ['date' => $branch->created_at->format('M d, Y')]) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('branches.contact_info') }}</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-phone text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700">{{ $branch->mobile ?? __('branches.no_phone') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700">{{ $branch->email ?? __('branches.no_email') }}</span>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('branches.location_details') }}</h3>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-gray-400 mr-3 w-5 mt-1"></i>
                        <span class="text-gray-700">{{ $branch->address ?? __('branches.no_address') }}</span>
                    </div>
                    @if($branch->city)
                        <div class="flex items-center">
                            <i class="fas fa-city text-gray-400 mr-3 w-5"></i>
                            <span class="text-gray-700">{{ $branch->city }}</span>
                        </div>
                    @endif
                    @if($branch->district)
                        <div class="flex items-center">
                            <i class="fas fa-map text-gray-400 mr-3 w-5"></i>
                            <span class="text-gray-700">{{ $branch->district }}</span>
                        </div>
                    @endif
                    @if($branch->latitude && $branch->longitude)
                        <div class="flex items-center">
                            <i class="fas fa-globe text-gray-400 mr-3 w-5"></i>
                            <span class="text-gray-700">{{ __('branches.map_location') }}: {{ number_format($branch->latitude, 4) }}, {{ number_format($branch->longitude, 4) }}</span>
                        </div>
                    @endif
                    @if($branch->location_url)
                        <div class="flex items-center mt-3">
                            <i class="fas fa-external-link-alt text-gray-400 mr-3 w-5"></i>
                            <a href="{{ $branch->location_url }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ __('branches.view_on_google_maps') }}
                            </a>
                        </div>
                    @elseif($branch->latitude && $branch->longitude)
                        <div class="flex items-center mt-3">
                            <i class="fas fa-external-link-alt text-gray-400 mr-3 w-5"></i>
                            <a href="https://www.google.com/maps?q={{ $branch->latitude }},{{ $branch->longitude }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ __('branches.view_on_google_maps') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('branches.vendor_name') }}</h3>

        @if($branch->vendor)
            <div class="flex items-center">
                <div class="h-16 w-16 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-store text-2xl text-blue-600"></i>
                </div>
                <div>
                    <h4 class="text-xl font-semibold text-gray-900">{{ $branch->vendor->commercial_name ?? $branch->vendor->name }}</h4>
                    <p class="text-gray-600">{{ $branch->vendor->owner_name ?? $branch->vendor->name }}</p>
                    <p class="text-sm text-gray-500">{{ $branch->vendor->activity_type ?? __('branches.no_category') }}</p>
                </div>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-store text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">{{ __('branches.no_vendor_assigned') }}</p>
            </div>
        @endif
    </div>

    <!-- Added By Info -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('branches.added_by') }}</h3>
        @if($branch->added_by && $branch->added_by_role)
            <p class="text-gray-700">
                {{ $branch->added_by }}
                <span class="text-xs text-gray-500">
                    (
                    @if(strtolower($branch->added_by_role) == 'admin' || strtolower($branch->added_by_role) == 'superadmin')
                        {{ __('branches.admin') }}
                    @elseif(strtolower($branch->added_by_role) == 'agent')
                        {{ __('branches.agent') }}
                    @else
                        {{ ucfirst($branch->added_by_role) }}
                    @endif
                    )
                </span>
            </p>
        @else
            <p class="text-gray-500">{{ __('branches.unknown') }}</p>
        @endif
    </div>

    <!-- Branch Photos -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('branches.branch_photos') }}</h3>
        @if($branch->photos->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($branch->photos as $photo)
                    <div class="border rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $photo->photo) }}" alt="{{ __('branches.branch_photo') }}" class="w-full h-40 object-cover">
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-image text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">{{ __('branches.no_photos') }}</p>
            </div>
        @endif
    </div>

    <!-- Recent Visits -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('branches.recent_visits') }}</h3>

        @if($branch->vendorVisits->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('branches.agent') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('branches.vendor') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('branches.visit_date') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('branches.status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($branch->vendorVisits->take(10) as $visit)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $visit->agent->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $visit->vendor->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $visit->created_at->format('M d, Y H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ __('branches.completed') }}
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
                <p class="text-gray-500">{{ __('branches.no_visits_yet') }}</p>
            </div>
        @endif
    </div>
</div>
@endsection