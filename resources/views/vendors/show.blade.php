@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ __('vendors.vendor_details') }}</h1>
        <div class="flex space-x-3">
            <a href="{{ route('vendors.edit', $vendor) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-edit mr-2"></i> {{ __('vendors.edit_vendor') }}
            </a>
            <a href="{{ route('vendors.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> {{ __('vendors.back_to_vendors') }}
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Basic Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center mb-6">
            <div class="h-20 w-20 bg-blue-100 rounded-lg flex items-center justify-center mr-6">
                <i class="fas fa-store text-3xl text-blue-600"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $vendor->commercial_name }}</h2>
                <p class="text-gray-600">{{ __('vendors.owner') }}: {{ $vendor->owner_name }}</p>
                <p class="text-sm text-gray-500">{{ __('vendors.vendor_id') }} #{{ $vendor->id }} | {{ __('vendors.created') }}: {{ $vendor->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Commercial Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.commercial_information') }}</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-user text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>{{ __('vendors.owner') }}:</strong> {{ $vendor->owner_name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-building text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>{{ __('vendors.commercial_name') }}:</strong> {{ $vendor->commercial_name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-id-card text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>{{ __('vendors.cr_number') }}:</strong> {{ $vendor->commercial_registration_number ?: __('vendors.not_provided') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>{{ __('vendors.activity_start') }}:</strong> {{ $vendor->activity_start_date ? $vendor->activity_start_date : __('vendors.not_specified') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-tag text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>{{ __('vendors.activity_type') }}:</strong> {{ $vendor->activity_type ? __('vendors.' . $vendor->activity_type) : __('vendors.not_specified') }}</span>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.contact_information') }}</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-phone text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>{{ __('vendors.mobile') }}:</strong> {{ $vendor->mobile }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fab fa-whatsapp text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>{{ __('vendors.whatsapp') }}:</strong> {{ $vendor->whatsapp ?: __('vendors.not_provided') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>{{ __('vendors.email') }}:</strong> {{ $vendor->email ?: __('vendors.not_provided') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>{{ __('vendors.city') }}:</strong> {{ $vendor->city ?: __('vendors.not_specified') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>{{ __('vendors.district') }}:</strong> {{ $vendor->district ?: __('vendors.not_specified') }}</span>
                    </div>
                </div>
            </div>

            <!-- Social Media & Online Presence -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.social_media_online') }}</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fab fa-snapchat text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>{{ __('vendors.snapchat') }}:</strong> {{ $vendor->snapchat ?: __('vendors.not_provided') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fab fa-instagram text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>{{ __('vendors.instagram') }}:</strong> {{ $vendor->instagram ?: __('vendors.not_provided') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-globe text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>{{ __('vendors.location_url') }}:</strong>
                            @if($vendor->location_url)
                                <a href="{{ $vendor->location_url }}" target="_blank" class="text-blue-600 hover:text-blue-800">{{ __('vendors.view_location') }}</a>
                            @else
                                {{ __('vendors.not_provided') }}
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-laptop text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>{{ __('vendors.has_online_platform') }}:</strong>
                            @if($vendor->has_online_platform)
                                <span class="text-green-600">{{ __('vendors.yes') }}</span>
                            @elseif($vendor->has_online_platform === false)
                                <span class="text-red-600">{{ __('vendors.no') }}</span>
                            @else
                                <span class="text-gray-500">{{ __('vendors.not_specified') }}</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscription & Visit Status -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.subscription_visit_status') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center p-4 border rounded-lg {{ $vendor->has_active_subscription ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                <i class="fas fa-crown text-2xl mb-2 {{ $vendor->has_active_subscription ? 'text-green-600' : 'text-gray-400' }}"></i>
                <h4 class="font-medium text-gray-900">{{ __('vendors.subscription_status') }}</h4>
                <p class="text-sm {{ $vendor->has_active_subscription ? 'text-green-600' : 'text-gray-500' }}">
                    @if($vendor->has_active_subscription)
                        <span class="text-green-600">{{ __('vendors.active') }}</span>
                    @else
                        <span class="text-gray-500">{{ __('vendors.inactive') }}</span>
                    @endif
                </p>
                @if($vendor->latest_package)
                    <p class="text-xs text-gray-600 mt-1">
                        <strong>{{ __('vendors.last_subscription') }}:</strong> {{ $vendor->latest_package->name }}
                    </p>
                @endif
            </div>

            <div class="text-center p-4 border rounded-lg bg-blue-50 border-blue-200">
                <i class="fas fa-calendar-check text-2xl mb-2 text-blue-600"></i>
                <h4 class="font-medium text-gray-900">{{ __('vendors.total_visits') }}</h4>
                <p class="text-sm text-blue-600 font-semibold">{{ $vendor->total_visits }}</p>
            </div>

            <div class="text-center p-4 border rounded-lg bg-purple-50 border-purple-200">
                <i class="fas fa-clock text-2xl mb-2 text-purple-600"></i>
                <h4 class="font-medium text-gray-900">{{ __('vendors.recent_visits') }}</h4>
                <p class="text-sm text-purple-600 font-semibold">{{ $vendor->recent_visits_count }} (30 {{ __('vendors.days') }})</p>
            </div>

            <div class="text-center p-4 border rounded-lg bg-orange-50 border-orange-200">
                <i class="fas fa-chart-line text-2xl mb-2 text-orange-600"></i>
                <h4 class="font-medium text-gray-900">{{ __('vendors.visit_frequency') }}</h4>
                <p class="text-sm text-orange-600 font-semibold">
                    @if($vendor->total_visits > 0)
                        {{ number_format($vendor->total_visits / max(1, $vendor->created_at->diffInDays(now())), 1) }} {{ __('vendors.per_month') }}
                    @else
                        0 {{ __('vendors.per_month') }}
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Business Status & Documents -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.business_status_documents') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center p-4 border rounded-lg">
                <i class="fas fa-certificate text-2xl mb-2 {{ $vendor->has_commercial_registration === 'yes' ? 'text-green-600' : ($vendor->has_commercial_registration === 'no' ? 'text-red-600' : 'text-gray-400') }}"></i>
                <h4 class="font-medium text-gray-900">{{ __('vendors.commercial_registration') }}</h4>
                <p class="text-sm text-gray-600">
                    @if($vendor->has_commercial_registration === 'yes')
                        <span class="text-green-600">{{ __('vendors.yes') }}</span>
                    @elseif($vendor->has_commercial_registration === 'no')
                        <span class="text-red-600">{{ __('vendors.no') }}</span>
                    @elseif($vendor->has_commercial_registration === 'not_sure')
                        <span class="text-yellow-600">{{ __('vendors.not_sure') }}</span>
                    @else
                        <span class="text-gray-500">{{ __('vendors.not_specified') }}</span>
                    @endif
                </p>
            </div>

            <div class="text-center p-4 border rounded-lg">
                <i class="fas fa-images text-2xl mb-2 {{ $vendor->has_product_photos ? 'text-green-600' : 'text-gray-400' }}"></i>
                <h4 class="font-medium text-gray-900">{{ __('vendors.product_photos') }}</h4>
                <p class="text-sm text-gray-600">
                    @if($vendor->has_product_photos)
                        <span class="text-green-600">{{ __('vendors.available') }}</span>
                    @elseif($vendor->has_product_photos === false)
                        <span class="text-red-600">{{ __('vendors.not_available') }}</span>
                    @else
                        <span class="text-gray-500">{{ __('vendors.not_specified') }}</span>
                    @endif
                </p>
            </div>

            <div class="text-center p-4 border rounded-lg">
                <i class="fas fa-store text-2xl mb-2 text-blue-600"></i>
                <h4 class="font-medium text-gray-900">{{ __('vendors.shop_front_image') }}</h4>
                <p class="text-sm text-gray-600">
                    @if($vendor->shop_front_image)
                        <span class="text-green-600">{{ __('vendors.uploaded') }}</span>
                    @else
                        <span class="text-gray-500">{{ __('vendors.not_uploaded') }}</span>
                    @endif
                </p>
            </div>

            <div class="text-center p-4 border rounded-lg">
                <i class="fas fa-id-card text-2xl mb-2 text-blue-600"></i>
                <h4 class="font-medium text-gray-900">{{ __('vendors.id_image') }}</h4>
                <p class="text-sm text-gray-600">
                    @if($vendor->id_image)
                        <span class="text-green-600">{{ __('vendors.uploaded') }}</span>
                    @else
                        <span class="text-gray-500">{{ __('vendors.not_uploaded') }}</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Platform Experience Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.platform_experience') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-md font-medium text-gray-900 mb-2">{{ __('vendors.previous_platform_experience') }}</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700">{{ $vendor->previous_platform_experience ?: __('vendors.no_previous_experience') }}</p>
                </div>
            </div>
            <div>
                <h4 class="text-md font-medium text-gray-900 mb-2">{{ __('vendors.previous_platform_issues') }}</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700">{{ $vendor->previous_platform_issues ?: __('vendors.no_previous_issues') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    @if($vendor->notes)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.additional_notes') }}</h3>
        <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-gray-700">{{ $vendor->notes }}</p>
        </div>
    </div>
    @endif

    <!-- Added By Info -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.added_by') }}</h3>
        @if($vendor->added_by && $vendor->added_by_role)
            <p class="text-gray-700">
                {{ $vendor->added_by }}
                <span class="text-xs text-gray-500">
                    (
                    @if(strtolower($vendor->added_by_role) == 'admin' || strtolower($vendor->added_by_role) == 'superadmin')
                        {{ __('vendors.admin') }}
                    @elseif(strtolower($vendor->added_by_role) == 'agent')
                        {{ __('vendors.agent') }}
                    @else
                        {{ ucfirst($vendor->added_by_role) }}
                    @endif
                    )
                </span>
            </p>
        @else
            <p class="text-gray-500">{{ __('vendors.unknown') }}</p>
        @endif
    </div>

    <!-- Vendor Images -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.vendor_images') }}</h3>
        @if(count($vendor->images()) > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($vendor->images() as $image)
                    <div class="border rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $image) }}" alt="Vendor Image" class="w-full h-40 object-cover">
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-image text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">{{ __('vendors.no_images_uploaded') }}</p>
            </div>
        @endif
    </div>

    <!-- Branches -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.branches') }} ({{ $vendor->branches->count() }})</h3>

        @if($vendor->branches->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($vendor->branches as $branch)
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                        <h4 class="font-medium text-gray-900">{{ $branch->name }}</h4>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">{{ $branch->address }}</p>
                    <p class="text-sm text-gray-500">{{ $branch->phone }}</p>
                    @if($branch->email)
                        <p class="text-sm text-gray-500">{{ $branch->email }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-map-marker-alt text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">{{ __('vendors.no_branches_registered') }}</p>
            </div>
        @endif
    </div>

    <!-- Recent Visits -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.recent_visits') }} ({{ $vendor->vendorVisits->count() }})</h3>

        @if($vendor->vendorVisits->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('vendors.agent') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('vendors.branch') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('vendors.visit_date') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('vendors.status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($vendor->vendorVisits->take(10) as $visit)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $visit->agent->name ?? 'N/A' }}</div>
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
