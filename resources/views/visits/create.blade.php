@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('visits.index') }}" class="text-blue-600 hover:text-blue-700 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">{{ __('visits.create_new_visit') }}</h1>
        </div>
        <p class="text-gray-600">{{ __('visits.record_new_visit_description') }}</p>
    </div>

    <!-- Form -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('visits.store') }}" method="POST">
                @csrf

                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="vendor_id" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('visits.vendor') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="vendor_id"
                                name="vendor_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('vendor_id') border-red-500 @enderror">
                            <option value="">{{ __('visits.select_vendor') }}</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->owner_name }} - {{ $vendor->commercial_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('vendor_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="agent_id" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('visits.agent') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="agent_id"
                                name="agent_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('agent_id') border-red-500 @enderror">
                            <option value="">{{ __('visits.select_agent') }}</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                    {{ $agent->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('agent_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Branch and Package -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="branch_id" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('visits.branch') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="branch_id"
                                name="branch_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('branch_id') border-red-500 @enderror">
                            <option value="">{{ __('visits.select_branch') }}</option>
                            <!-- This will be populated via AJAX based on vendor selection -->
                        </select>
                        @error('branch_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="package_id" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('visits.package') }}
                        </label>
                        <select id="package_id"
                                name="package_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('package_id') border-red-500 @enderror">
                            <option value="">{{ __('visits.select_package_optional') }}</option>
                            @foreach($packages as $package)
                                <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                    {{ $package->name }} - SAR {{ number_format($package->price, 2) }}
                                </option>
                            @endforeach
                        </select>
                        @error('package_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Visit Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="visit_date" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('visits.visit_date_time') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local"
                               id="visit_date"
                               name="visit_date"
                               value="{{ old('visit_date') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('visit_date') border-red-500 @enderror">
                        @error('visit_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="visit_end_at" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('visits.end_time') }}
                        </label>
                        <input type="datetime-local"
                               id="visit_end_at"
                               name="visit_end_at"
                               value="{{ old('visit_end_at') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('visit_end_at') border-red-500 @enderror">
                        @error('visit_end_at')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status and Rating -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="visit_status" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('visits.visit_status') }}
                        </label>
                        <select id="visit_status"
                                name="visit_status"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('visit_status') border-red-500 @enderror">
                            <option value="visited" {{ old('visit_status') == 'visited' ? 'selected' : '' }}>{{ __('visits.visited') }}</option>
                            <option value="closed" {{ old('visit_status') == 'closed' ? 'selected' : '' }}>{{ __('visits.closed') }}</option>
                            <option value="not_found" {{ old('visit_status') == 'not_found' ? 'selected' : '' }}>{{ __('visits.not_found') }}</option>
                            <option value="refused" {{ old('visit_status') == 'refused' ? 'selected' : '' }}>{{ __('visits.refused') }}</option>
                        </select>
                        @error('visit_status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="vendor_rating" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('visits.vendor_rating') }}
                        </label>
                        <select id="vendor_rating"
                                name="vendor_rating"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('vendor_rating') border-red-500 @enderror">
                            <option value="">{{ __('visits.select_rating') }}</option>
                            <option value="very_interested" {{ old('vendor_rating') == 'very_interested' ? 'selected' : '' }}>{{ __('visits.very_interested') }}</option>
                            <option value="hesitant" {{ old('vendor_rating') == 'hesitant' ? 'selected' : '' }}>{{ __('visits.hesitant') }}</option>
                            <option value="refused" {{ old('vendor_rating') == 'refused' ? 'selected' : '' }}>{{ __('visits.refused') }}</option>
                            <option value="inappropriate" {{ old('vendor_rating') == 'inappropriate' ? 'selected' : '' }}>{{ __('visits.inappropriate') }}</option>
                        </select>
                        @error('vendor_rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- GPS Coordinates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="gps_latitude" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('visits.gps_latitude') }}
                        </label>
                        <input type="number"
                               id="gps_latitude"
                               name="gps_latitude"
                               value="{{ old('gps_latitude') }}"
                               step="any"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gps_latitude') border-red-500 @enderror"
                               placeholder="e.g., 24.7136">
                        @error('gps_latitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gps_longitude" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('visits.gps_longitude') }}
                        </label>
                        <input type="number"
                               id="gps_longitude"
                               name="gps_longitude"
                               value="{{ old('gps_longitude') }}"
                               step="any"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gps_longitude') border-red-500 @enderror"
                               placeholder="e.g., 46.6753">
                        @error('gps_longitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div class="space-y-6 mb-8">
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('visits.general_notes') }}
                        </label>
                        <textarea id="notes"
                                  name="notes"
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                                  placeholder="{{ __('visits.general_notes_placeholder') }}">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="agent_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('visits.agent_notes_visible') }}
                        </label>
                        <textarea id="agent_notes"
                                  name="agent_notes"
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('agent_notes') border-red-500 @enderror"
                                  placeholder="{{ __('visits.agent_notes_placeholder') }}">{{ old('agent_notes') }}</textarea>
                        @error('agent_notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="internal_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('visits.internal_notes_not_visible') }}
                        </label>
                        <textarea id="internal_notes"
                                  name="internal_notes"
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('internal_notes') border-red-500 @enderror"
                                  placeholder="{{ __('visits.internal_notes_placeholder') }}">{{ old('internal_notes') }}</textarea>
                        @error('internal_notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('visits.index') }}"
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        {{ __('visits.cancel') }}
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        {{ __('visits.create_visit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Set default visit date to current date/time
document.addEventListener('DOMContentLoaded', function() {
    const now = new Date();
    const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);

    if (!document.getElementById('visit_date').value) {
        document.getElementById('visit_date').value = localDateTime;
    }
});

// Auto-fill end time when visit date changes
document.getElementById('visit_date').addEventListener('change', function() {
    const visitDate = new Date(this.value);
    const endDate = new Date(visitDate.getTime() + (60 * 60 * 1000)); // Add 1 hour
    const endDateTime = new Date(endDate.getTime() - endDate.getTimezoneOffset() * 60000).toISOString().slice(0, 16);

    if (!document.getElementById('visit_end_at').value) {
        document.getElementById('visit_end_at').value = endDateTime;
    }
});

// Get current location for GPS coordinates
function getCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('gps_latitude').value = position.coords.latitude;
            document.getElementById('gps_longitude').value = position.coords.longitude;
        }, function(error) {
            console.log('Error getting location:', error);
        });
    }
}

// Add a button to get current location (optional)
// You can add this button to the GPS coordinates section if needed
</script>
@endsection
