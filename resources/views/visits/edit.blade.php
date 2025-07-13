@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('visits.index') }}" class="text-blue-600 hover:text-blue-700 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Visit</h1>
        </div>
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('visits.update', $visit) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="vendor_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Vendor <span class="text-red-500">*</span>
                        </label>
                        <select id="vendor_id" name="vendor_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('vendor_id') border-red-500 @enderror">
                            <option value="">Select Vendor</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ old('vendor_id', $visit->vendor_id) == $vendor->id ? 'selected' : '' }}>
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
                            Agent <span class="text-red-500">*</span>
                        </label>
                        <select id="agent_id" name="agent_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('agent_id') border-red-500 @enderror">
                            <option value="">Select Agent</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ old('agent_id', $visit->agent_id) == $agent->id ? 'selected' : '' }}>
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
                            Branch <span class="text-red-500">*</span>
                        </label>
                        <select id="branch_id" name="branch_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('branch_id') border-red-500 @enderror">
                            <option value="">Select Branch</option>
                            @foreach($vendors->find(old('vendor_id', $visit->vendor_id))->branches ?? [] as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id', $visit->branch_id) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="package_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Package
                        </label>
                        <select id="package_id" name="package_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('package_id') border-red-500 @enderror">
                            <option value="">Select Package (Optional)</option>
                            @foreach($packages as $package)
                                <option value="{{ $package->id }}" {{ old('package_id', $visit->package_id) == $package->id ? 'selected' : '' }}>
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
                            Visit Date & Time <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" id="visit_date" name="visit_date" value="{{ old('visit_date', $visit->visit_date ? $visit->visit_date->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('visit_date') border-red-500 @enderror">
                        @error('visit_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="visit_end_at" class="block text-sm font-medium text-gray-700 mb-2">
                            End Time
                        </label>
                        <input type="datetime-local" id="visit_end_at" name="visit_end_at" value="{{ old('visit_end_at', $visit->visit_end_at ? $visit->visit_end_at->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('visit_end_at') border-red-500 @enderror">
                        @error('visit_end_at')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Status and Rating -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="visit_status" class="block text-sm font-medium text-gray-700 mb-2">
                            Visit Status
                        </label>
                        <select id="visit_status" name="visit_status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('visit_status') border-red-500 @enderror">
                            <option value="visited" {{ old('visit_status', $visit->visit_status) == 'visited' ? 'selected' : '' }}>Visited</option>
                            <option value="closed" {{ old('visit_status', $visit->visit_status) == 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="not_found" {{ old('visit_status', $visit->visit_status) == 'not_found' ? 'selected' : '' }}>Not Found</option>
                            <option value="refused" {{ old('visit_status', $visit->visit_status) == 'refused' ? 'selected' : '' }}>Refused</option>
                        </select>
                        @error('visit_status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="vendor_rating" class="block text-sm font-medium text-gray-700 mb-2">
                            Vendor Rating
                        </label>
                        <select id="vendor_rating" name="vendor_rating" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('vendor_rating') border-red-500 @enderror">
                            <option value="">Select Rating</option>
                            <option value="very_interested" {{ old('vendor_rating', $visit->vendor_rating) == 'very_interested' ? 'selected' : '' }}>Very Interested</option>
                            <option value="hesitant" {{ old('vendor_rating', $visit->vendor_rating) == 'hesitant' ? 'selected' : '' }}>Hesitant</option>
                            <option value="refused" {{ old('vendor_rating', $visit->vendor_rating) == 'refused' ? 'selected' : '' }}>Refused</option>
                            <option value="inappropriate" {{ old('vendor_rating', $visit->vendor_rating) == 'inappropriate' ? 'selected' : '' }}>Inappropriate</option>
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
                            GPS Latitude
                        </label>
                        <input type="number" id="gps_latitude" name="gps_latitude" value="{{ old('gps_latitude', $visit->gps_latitude) }}" step="any" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gps_latitude') border-red-500 @enderror" placeholder="e.g., 24.7136">
                        @error('gps_latitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="gps_longitude" class="block text-sm font-medium text-gray-700 mb-2">
                            GPS Longitude
                        </label>
                        <input type="number" id="gps_longitude" name="gps_longitude" value="{{ old('gps_longitude', $visit->gps_longitude) }}" step="any" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gps_longitude') border-red-500 @enderror" placeholder="e.g., 46.6753">
                        @error('gps_longitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Notes -->
                <div class="space-y-6 mb-8">
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            General Notes
                        </label>
                        <textarea id="notes" name="notes" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror" placeholder="General notes about the visit">{{ old('notes', $visit->notes) }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="agent_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Agent Notes (Visible to Vendor)
                        </label>
                        <textarea id="agent_notes" name="agent_notes" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('agent_notes') border-red-500 @enderror" placeholder="Notes that will be visible to the vendor">{{ old('agent_notes', $visit->agent_notes) }}</textarea>
                        @error('agent_notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="internal_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Internal Notes (Not Visible to Vendor)
                        </label>
                        <textarea id="internal_notes" name="internal_notes" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('internal_notes') border-red-500 @enderror" placeholder="Internal notes for team reference">{{ old('internal_notes', $visit->internal_notes) }}</textarea>
                        @error('internal_notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Actions -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('visits.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">Cancel</a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">Update Visit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
// Set default visit date to current date/time if empty
document.addEventListener('DOMContentLoaded', function() {
    if (!document.getElementById('visit_date').value) {
        const now = new Date();
        const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
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
</script>
@endsection
