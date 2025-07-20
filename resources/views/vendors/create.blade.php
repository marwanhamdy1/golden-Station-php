@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Add New Vendor</h1>
            <a href="{{ route('vendors.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Vendors
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('vendors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Owner Name -->
                    <div>
                        <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-2">Owner Name *</label>
                        <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('owner_name') border-red-500 @enderror"
                               placeholder="Enter owner's full name">
                        @error('owner_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Commercial Name -->
                    <div>
                        <label for="commercial_name" class="block text-sm font-medium text-gray-700 mb-2">Commercial Name *</label>
                        <input type="text" name="commercial_name" id="commercial_name" value="{{ old('commercial_name') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('commercial_name') border-red-500 @enderror"
                               placeholder="Enter commercial/business name">
                        @error('commercial_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Commercial Registration Number -->
                    <div>
                        <label for="commercial_registration_number" class="block text-sm font-medium text-gray-700 mb-2">Commercial Registration Number</label>
                        <input type="text" name="commercial_registration_number" id="commercial_registration_number" value="{{ old('commercial_registration_number') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('commercial_registration_number') border-red-500 @enderror"
                               placeholder="CR123456789">
                        @error('commercial_registration_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mobile -->
                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-700 mb-2">Mobile Number *</label>
                        <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('mobile') border-red-500 @enderror"
                               placeholder="+966501234567">
                        @error('mobile')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- WhatsApp -->
                    <div>
                        <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">WhatsApp</label>
                        <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('whatsapp') border-red-500 @enderror"
                               placeholder="+966501234567">
                        @error('whatsapp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="info@company.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                        <select name="city" id="city" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('city') border-red-500 @enderror">
                            <option value="">Select City</option>
                            <option value="Riyadh" {{ old('city') == 'Riyadh' ? 'selected' : '' }}>Riyadh</option>
                            <option value="Jeddah" {{ old('city') == 'Jeddah' ? 'selected' : '' }}>Jeddah</option>
                            <option value="Dammam" {{ old('city') == 'Dammam' ? 'selected' : '' }}>Dammam</option>
                            <option value="Mecca" {{ old('city') == 'Mecca' ? 'selected' : '' }}>Mecca</option>
                            <option value="Medina" {{ old('city') == 'Medina' ? 'selected' : '' }}>Medina</option>
                        </select>
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- District -->
                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-2">District</label>
                        <input type="text" name="district" id="district" value="{{ old('district') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('district') border-red-500 @enderror"
                               placeholder="Enter district">
                        @error('district')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Activity Type -->
                    <div>
                        <label for="activity_type" class="block text-sm font-medium text-gray-700 mb-2">Activity Type</label>
                        <select name="activity_type" id="activity_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('activity_type') border-red-500 @enderror">
                            <option value="">Select Activity Type</option>
                            <option value="wholesale" {{ old('activity_type') == 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                            <option value="retail" {{ old('activity_type') == 'retail' ? 'selected' : '' }}>Retail</option>
                            <option value="both" {{ old('activity_type') == 'both' ? 'selected' : '' }}>Both</option>
                        </select>
                        @error('activity_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Activity Start Date -->
                    <div>
                        <label for="activity_start_date" class="block text-sm font-medium text-gray-700 mb-2">Activity Start Date</label>
                        <input type="date" name="activity_start_date" id="activity_start_date" value="{{ old('activity_start_date') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('activity_start_date') border-red-500 @enderror">
                        @error('activity_start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Has Commercial Registration -->
                    <div>
                        <label for="has_commercial_registration" class="block text-sm font-medium text-gray-700 mb-2">Has Commercial Registration</label>
                        <select name="has_commercial_registration" id="has_commercial_registration" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('has_commercial_registration') border-red-500 @enderror">
                            <option value="">Select Status</option>
                            <option value="yes" {{ old('has_commercial_registration') == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('has_commercial_registration') == 'no' ? 'selected' : '' }}>No</option>
                            <option value="not_sure" {{ old('has_commercial_registration') == 'not_sure' ? 'selected' : '' }}>Not Sure</option>
                        </select>
                        @error('has_commercial_registration')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Has Online Platform -->
                    <div>
                        <label for="has_online_platform" class="block text-sm font-medium text-gray-700 mb-2">Has Online Platform</label>
                        <select name="has_online_platform" id="has_online_platform" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('has_online_platform') border-red-500 @enderror">
                            <option value="">Select Status</option>
                            <option value="1" {{ old('has_online_platform') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('has_online_platform') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('has_online_platform')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Has Product Photos -->
                    <div>
                        <label for="has_product_photos" class="block text-sm font-medium text-gray-700 mb-2">Has Product Photos</label>
                        <select name="has_product_photos" id="has_product_photos" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('has_product_photos') border-red-500 @enderror">
                            <option value="">Select Status</option>
                            <option value="1" {{ old('has_product_photos') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('has_product_photos') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('has_product_photos')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Social Media -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Social Media</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="snapchat" class="block text-sm font-medium text-gray-700 mb-2">Snapchat</label>
                            <input type="text" name="snapchat" id="snapchat" value="{{ old('snapchat') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('snapchat') border-red-500 @enderror"
                                   placeholder="snapchat_username">
                            @error('snapchat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="instagram" class="block text-sm font-medium text-gray-700 mb-2">Instagram</label>
                            <input type="text" name="instagram" id="instagram" value="{{ old('instagram') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('instagram') border-red-500 @enderror"
                                   placeholder="instagram_username">
                            @error('instagram')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="location_url" class="block text-sm font-medium text-gray-700 mb-2">Location URL</label>
                            <input type="url" name="location_url" id="location_url" value="{{ old('location_url') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('location_url') border-red-500 @enderror"
                                   placeholder="https://maps.google.com/...">
                            @error('location_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="previous_platform_experience" class="block text-sm font-medium text-gray-700 mb-2">Previous Platform Experience</label>
                            <textarea name="previous_platform_experience" id="previous_platform_experience" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('previous_platform_experience') border-red-500 @enderror"
                                      placeholder="Describe any previous experience with online platforms...">{{ old('previous_platform_experience') }}</textarea>
                            @error('previous_platform_experience')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="previous_platform_issues" class="block text-sm font-medium text-gray-700 mb-2">Previous Platform Issues</label>
                            <textarea name="previous_platform_issues" id="previous_platform_issues" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('previous_platform_issues') border-red-500 @enderror"
                                      placeholder="Describe any issues or problems experienced with previous platforms...">{{ old('previous_platform_issues') }}</textarea>
                            @error('previous_platform_issues')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                                      placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Vendor Images -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Vendor Images</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="shop_front_image" class="block text-sm font-medium text-gray-700 mb-2">Shop Front Image</label>
                            <input type="file" name="shop_front_image" id="shop_front_image" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label for="commercial_registration_image" class="block text-sm font-medium text-gray-700 mb-2">Commercial Registration Image</label>
                            <input type="file" name="commercial_registration_image" id="commercial_registration_image" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label for="id_image" class="block text-sm font-medium text-gray-700 mb-2">ID Image</label>
                            <input type="file" name="id_image" id="id_image" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label for="natural_photos[]" class="block text-sm font-medium text-gray-700 mb-2">Natural Photos (Multiple)</label>
                            <input type="file" name="natural_photos[]" id="natural_photos" class="w-full px-3 py-2 border border-gray-300 rounded-lg" multiple>
                        </div>
                        <div>
                            <label for="license_photos[]" class="block text-sm font-medium text-gray-700 mb-2">License Photos (Multiple)</label>
                            <input type="file" name="license_photos[]" id="license_photos" class="w-full px-3 py-2 border border-gray-300 rounded-lg" multiple>
                        </div>
                        <div>
                            <label for="other_attachments" class="block text-sm font-medium text-gray-700 mb-2">Other Attachments</label>
                            <input type="file" name="other_attachments" id="other_attachments" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('vendors.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">
                        Cancel
                    </a>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                        <i class="fas fa-save mr-2"></i> Create Vendor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
