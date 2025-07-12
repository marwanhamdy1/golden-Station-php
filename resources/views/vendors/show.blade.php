@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Vendor Details</h1>
        <div class="flex space-x-3">
            <a href="{{ route('vendors.edit', $vendor) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-edit mr-2"></i> Edit Vendor
            </a>
            <a href="{{ route('vendors.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Vendors
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
                <p class="text-gray-600">Owner: {{ $vendor->owner_name }}</p>
                <p class="text-sm text-gray-500">Vendor #{{ str_pad($vendor->id, 3, '0', STR_PAD_LEFT) }} | Created: {{ $vendor->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Commercial Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Commercial Information</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-user text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>Owner:</strong> {{ $vendor->owner_name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-building text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>Commercial Name:</strong> {{ $vendor->commercial_name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-id-card text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>CR Number:</strong> {{ $vendor->commercial_registration_number ?: 'Not provided' }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>Activity Start:</strong> {{ $vendor->activity_start_date ? $vendor->activity_start_date : 'Not specified' }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-tag text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>Activity Type:</strong> {{ $vendor->activity_type ? ucfirst($vendor->activity_type) : 'Not specified' }}</span>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-phone text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>Mobile:</strong> {{ $vendor->mobile }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fab fa-whatsapp text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>WhatsApp:</strong> {{ $vendor->whatsapp ?: 'Not provided' }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>Email:</strong> {{ $vendor->email ?: 'Not provided' }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>City:</strong> {{ $vendor->city ?: 'Not specified' }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>District:</strong> {{ $vendor->district ?: 'Not specified' }}</span>
                    </div>
                </div>
            </div>

            <!-- Social Media & Online Presence -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Social Media & Online</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fab fa-snapchat text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>Snapchat:</strong> {{ $vendor->snapchat ?: 'Not provided' }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fab fa-instagram text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>Instagram:</strong> {{ $vendor->instagram ?: 'Not provided' }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-globe text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>Location URL:</strong>
                            @if($vendor->location_url)
                                <a href="{{ $vendor->location_url }}" target="_blank" class="text-blue-600 hover:text-blue-800">View Location</a>
                            @else
                                Not provided
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-laptop text-gray-400 mr-3 w-5"></i>
                        <span class="text-gray-700"><strong>Has Online Platform:</strong>
                            @if($vendor->has_online_platform)
                                <span class="text-green-600">Yes</span>
                            @elseif($vendor->has_online_platform === false)
                                <span class="text-red-600">No</span>
                            @else
                                <span class="text-gray-500">Not specified</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Business Status & Documents -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Business Status & Documents</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center p-4 border rounded-lg">
                <i class="fas fa-certificate text-2xl mb-2 {{ $vendor->has_commercial_registration === 'yes' ? 'text-green-600' : ($vendor->has_commercial_registration === 'no' ? 'text-red-600' : 'text-gray-400') }}"></i>
                <h4 class="font-medium text-gray-900">Commercial Registration</h4>
                <p class="text-sm text-gray-600">
                    @if($vendor->has_commercial_registration === 'yes')
                        <span class="text-green-600">Yes</span>
                    @elseif($vendor->has_commercial_registration === 'no')
                        <span class="text-red-600">No</span>
                    @elseif($vendor->has_commercial_registration === 'not_sure')
                        <span class="text-yellow-600">Not Sure</span>
                    @else
                        <span class="text-gray-500">Not specified</span>
                    @endif
                </p>
            </div>

            <div class="text-center p-4 border rounded-lg">
                <i class="fas fa-images text-2xl mb-2 {{ $vendor->has_product_photos ? 'text-green-600' : 'text-gray-400' }}"></i>
                <h4 class="font-medium text-gray-900">Product Photos</h4>
                <p class="text-sm text-gray-600">
                    @if($vendor->has_product_photos)
                        <span class="text-green-600">Available</span>
                    @elseif($vendor->has_product_photos === false)
                        <span class="text-red-600">Not Available</span>
                    @else
                        <span class="text-gray-500">Not specified</span>
                    @endif
                </p>
            </div>

            <div class="text-center p-4 border rounded-lg">
                <i class="fas fa-store text-2xl mb-2 text-blue-600"></i>
                <h4 class="font-medium text-gray-900">Shop Front Image</h4>
                <p class="text-sm text-gray-600">
                    @if($vendor->shop_front_image)
                        <span class="text-green-600">Uploaded</span>
                    @else
                        <span class="text-gray-500">Not uploaded</span>
                    @endif
                </p>
            </div>

            <div class="text-center p-4 border rounded-lg">
                <i class="fas fa-id-card text-2xl mb-2 text-blue-600"></i>
                <h4 class="font-medium text-gray-900">ID Image</h4>
                <p class="text-sm text-gray-600">
                    @if($vendor->id_image)
                        <span class="text-green-600">Uploaded</span>
                    @else
                        <span class="text-gray-500">Not uploaded</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Platform Experience Information -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Platform Experience</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-md font-medium text-gray-900 mb-2">Previous Platform Experience</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700">{{ $vendor->previous_platform_experience ?: 'No previous experience recorded' }}</p>
                </div>
            </div>
            <div>
                <h4 class="text-md font-medium text-gray-900 mb-2">Previous Platform Issues</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700">{{ $vendor->previous_platform_issues ?: 'No issues recorded' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    @if($vendor->notes)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Notes</h3>
        <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-gray-700">{{ $vendor->notes }}</p>
        </div>
    </div>
    @endif

    <!-- Branches -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Branches ({{ $vendor->branches->count() }})</h3>

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
                <p class="text-gray-500">No branches registered yet</p>
            </div>
        @endif
    </div>

    <!-- Recent Visits -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Visits ({{ $vendor->vendorVisits->count() }})</h3>

        @if($vendor->vendorVisits->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Branch</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visit Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
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
