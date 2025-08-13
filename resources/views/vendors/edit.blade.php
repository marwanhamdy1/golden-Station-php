@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ __('vendors.edit_vendor') }}</h1>
        <a href="{{ route('vendors.show', $vendor) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> {{ __('vendors.back') }}
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('vendors.update', $vendor) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.basic_information') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.owner_name') }} *</label>
                        <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name', $vendor->owner_name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('owner_name') border-red-500 @enderror"
                               placeholder="{{ __('vendors.enter_owner_name') }}" required>
                        @error('owner_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="commercial_name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.commercial_name') }} *</label>
                        <input type="text" id="commercial_name" name="commercial_name" value="{{ old('commercial_name', $vendor->commercial_name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('commercial_name') border-red-500 @enderror"
                               placeholder="{{ __('vendors.enter_commercial_name') }}" required>
                        @error('commercial_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="commercial_registration_number" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.commercial_registration_number') }}</label>
                        <input type="text" id="commercial_registration_number" name="commercial_registration_number" value="{{ old('commercial_registration_number', $vendor->commercial_registration_number) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('commercial_registration_number') border-red-500 @enderror"
                               placeholder="CR123456789">
                        @error('commercial_registration_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.mobile_number') }} *</label>
                        <input type="tel" id="mobile" name="mobile" value="{{ old('mobile', $vendor->mobile) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mobile') border-red-500 @enderror"
                               placeholder="+966501234567" required>
                        @error('mobile')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.contact_info') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.whatsapp') }}</label>
                        <input type="tel" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $vendor->whatsapp) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('whatsapp') border-red-500 @enderror"
                               placeholder="+966501234567">
                        @error('whatsapp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.email_address') }}</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $vendor->email) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="info@company.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.location') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.city') }}</label>
                        <input type="text" name="city" id="city" value="{{ old('city', $vendor->city) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('city') border-red-500 @enderror"
                               placeholder="{{ __('vendors.enter_city') }}">
                        @error('city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.district') }}</label>
                        <input type="text" id="district" name="district" value="{{ old('district', $vendor->district) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('district') border-red-500 @enderror"
                               placeholder="{{ __('vendors.enter_district') }}">
                        @error('district')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="location_url" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.location_url') }}</label>
                        <input type="url" id="location_url" name="location_url" value="{{ old('location_url', $vendor->location_url) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('location_url') border-red-500 @enderror"
                               placeholder="https://maps.google.com/...">
                        @error('location_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Business Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.basic_information') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="activity_type" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.activity_type') }}</label>
                        <select name="activity_type" id="activity_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('activity_type') border-red-500 @enderror">
                            <option value="">{{ __('vendors.select_activity_type') }}</option>
                            <option value="wholesale" {{ old('activity_type', $vendor->activity_type) == 'wholesale' ? 'selected' : '' }}>{{ __('vendors.wholesale') }}</option>
                            <option value="retail" {{ old('activity_type', $vendor->activity_type) == 'retail' ? 'selected' : '' }}>{{ __('vendors.retail') }}</option>
                            <option value="both" {{ old('activity_type', $vendor->activity_type) == 'both' ? 'selected' : '' }}>{{ __('vendors.both') }}</option>
                        </select>
                        @error('activity_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="activity_start_date" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.activity_start_date') }}</label>
                        <input type="date" id="activity_start_date" name="activity_start_date" value="{{ old('activity_start_date', $vendor->activity_start_date) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('activity_start_date') border-red-500 @enderror">
                        @error('activity_start_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="has_commercial_registration" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.has_commercial_registration') }}</label>
                        <select name="has_commercial_registration" id="has_commercial_registration" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('has_commercial_registration') border-red-500 @enderror">
                            <option value="">{{ __('vendors.select_status') }}</option>
                            <option value="yes" {{ old('has_commercial_registration', $vendor->has_commercial_registration) == 'yes' ? 'selected' : '' }}>{{ __('vendors.yes') }}</option>
                            <option value="no" {{ old('has_commercial_registration', $vendor->has_commercial_registration) == 'no' ? 'selected' : '' }}>{{ __('vendors.no') }}</option>
                            <option value="not_sure" {{ old('has_commercial_registration', $vendor->has_commercial_registration) == 'not_sure' ? 'selected' : '' }}>{{ __('vendors.not_sure') }}</option>
                        </select>
                        @error('has_commercial_registration')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="has_online_platform" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.has_online_platform') }}</label>
                        <select name="has_online_platform" id="has_online_platform" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('has_online_platform') border-red-500 @enderror">
                            <option value="">{{ __('vendors.select_status') }}</option>
                            <option value="1" {{ old('has_online_platform', $vendor->has_online_platform) == '1' ? 'selected' : '' }}>{{ __('vendors.yes') }}</option>
                            <option value="0" {{ old('has_online_platform', $vendor->has_online_platform) == '0' ? 'selected' : '' }}>{{ __('vendors.no') }}</option>
                        </select>
                        @error('has_online_platform')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="has_product_photos" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.has_product_photos') }}</label>
                        <select name="has_product_photos" id="has_product_photos" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('has_product_photos') border-red-500 @enderror">
                            <option value="">{{ __('vendors.select_status') }}</option>
                            <option value="1" {{ old('has_product_photos', $vendor->has_product_photos) == '1' ? 'selected' : '' }}>{{ __('vendors.yes') }}</option>
                            <option value="0" {{ old('has_product_photos', $vendor->has_product_photos) == '0' ? 'selected' : '' }}>{{ __('vendors.no') }}</option>
                        </select>
                        @error('has_product_photos')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.social_media') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="snapchat" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.snapchat') }}</label>
                        <input type="text" id="snapchat" name="snapchat" value="{{ old('snapchat', $vendor->snapchat) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('snapchat') border-red-500 @enderror"
                               placeholder="{{ __('vendors.snapchat_username') }}">
                        @error('snapchat')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="instagram" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.instagram') }}</label>
                        <input type="text" id="instagram" name="instagram" value="{{ old('instagram', $vendor->instagram) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('instagram') border-red-500 @enderror"
                               placeholder="{{ __('vendors.instagram_username') }}">
                        @error('instagram')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Platform Experience Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.previous_platform_experience') }}</h3>
                <div class="space-y-4">
                    <div>
                        <label for="previous_platform_experience" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.previous_platform_experience') }}</label>
                        <textarea name="previous_platform_experience" id="previous_platform_experience" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('previous_platform_experience') border-red-500 @enderror"
                                  placeholder="{{ __('vendors.describe_platform_experience') }}">{{ old('previous_platform_experience', $vendor->previous_platform_experience) }}</textarea>
                        @error('previous_platform_experience')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="previous_platform_issues" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.previous_platform_issues') }}</label>
                        <textarea name="previous_platform_issues" id="previous_platform_issues" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('previous_platform_issues') border-red-500 @enderror"
                                  placeholder="{{ __('vendors.describe_platform_issues') }}">{{ old('previous_platform_issues', $vendor->previous_platform_issues) }}</textarea>
                        @error('previous_platform_issues')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('vendors.additional_information') }}</h3>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">{{ __('vendors.notes') }}</label>
                    <textarea name="notes" id="notes" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                              placeholder="{{ __('vendors.additional_notes') }}">{{ old('notes', $vendor->notes) }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('vendors.show', $vendor) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg">
                    {{ __('vendors.cancel') }}
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg flex items-center">
                    <i class="fas fa-save mr-2"></i> {{ __('vendors.update') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
