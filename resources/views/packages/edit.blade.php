@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('packages.index') }}" class="text-blue-600 hover:text-blue-700 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">{{ __('packages.edit_package') }}</h1>
        </div>
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('packages.update', $package) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Package Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('packages.package_name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $package->name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: الباقة المميزة' : 'e.g., Premium Package' }}">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('packages.package_description') }}
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="{{ app()->getLocale() == 'ar' ? 'اوصف مميزات وفوائد الباقة' : 'Describe the package features and benefits' }}">{{ old('description', $package->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Price and Limits -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('packages.price') }} (SAR) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500">SAR</span>
                            <input type="number"
                                   id="price"
                                   name="price"
                                   value="{{ old('price', $package->price) }}"
                                   step="0.01"
                                   min="0"
                                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror"
                                   placeholder="0.00">
                        </div>
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Product Limit -->
                    <div>
                        <label for="product_limit" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('packages.product_limit') }}
                        </label>
                        <input type="number"
                               id="product_limit"
                               name="product_limit"
                               value="{{ old('product_limit', $package->product_limit) }}"
                               min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('product_limit') border-red-500 @enderror"
                               placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: 1000' : 'e.g., 1000' }}"
                               style="direction: ltr; text-align: left;">
                        @error('product_limit')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Duration -->
                <div class="mb-6">
                    <label for="duration_in_days" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('packages.duration_in_days') }}
                    </label>
                    <input type="number"
                           id="duration_in_days"
                           name="duration_in_days"
                           value="{{ old('duration_in_days', $package->duration_in_days) }}"
                           min="1"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('duration_in_days') border-red-500 @enderror"
                           placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: 365' : 'e.g., 365' }}"
                           style="direction: ltr; text-align: left;">
                    @error('duration_in_days')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Status -->
                <div class="mb-8">
                    <label class="flex items-center">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $package->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">{{ __('packages.is_active') }}</span>
                    </label>
                    <p class="text-gray-500 text-sm mt-1">{{ app()->getLocale() == 'ar' ? 'الباقات غير المفعلة لن تكون متاحة للاختيار' : 'Inactive packages won\'t be available for selection' }}</p>
                </div>
                <!-- Actions -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('packages.index') }}"
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        {{ __('packages.cancel') }}
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        {{ __('packages.update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
// Auto-format price input
document.getElementById('price').addEventListener('input', function(e) {
    let value = e.target.value;
    if (value && !isNaN(value)) {
        e.target.value = parseFloat(value).toFixed(2);
    }
});
// Character counter for description
document.getElementById('description').addEventListener('input', function(e) {
    const maxLength = 1000;
    const currentLength = e.target.value.length;
    const remaining = maxLength - currentLength;
    if (currentLength > maxLength) {
        e.target.value = e.target.value.substring(0, maxLength);
    }
});
</script>
@endsection
