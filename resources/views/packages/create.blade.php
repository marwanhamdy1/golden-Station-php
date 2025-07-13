@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('packages.index') }}" class="text-blue-600 hover:text-blue-700 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Create New Package</h1>
        </div>
        <p class="text-gray-600">Add a new service package to your offerings</p>
    </div>

    <!-- Form -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('packages.store') }}" method="POST">
                @csrf

                <!-- Package Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Package Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="e.g., Premium Package">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Describe the package features and benefits">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price and Limits -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Price (SAR) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500">SAR</span>
                            <input type="number"
                                   id="price"
                                   name="price"
                                   value="{{ old('price', 0) }}"
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
                            Product Limit
                        </label>
                        <input type="number"
                               id="product_limit"
                               name="product_limit"
                               value="{{ old('product_limit') }}"
                               min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('product_limit') border-red-500 @enderror"
                               placeholder="e.g., 1000">
                        @error('product_limit')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Duration -->
                <div class="mb-6">
                    <label for="duration_in_days" class="block text-sm font-medium text-gray-700 mb-2">
                        Duration (Days)
                    </label>
                    <input type="number"
                           id="duration_in_days"
                           name="duration_in_days"
                           value="{{ old('duration_in_days') }}"
                           min="1"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('duration_in_days') border-red-500 @enderror"
                           placeholder="e.g., 365">
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
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Active Package</span>
                    </label>
                    <p class="text-gray-500 text-sm mt-1">Inactive packages won't be available for selection</p>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('packages.index') }}"
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        Create Package
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

    // You can add a character counter display here if needed
    if (currentLength > maxLength) {
        e.target.value = e.target.value.substring(0, maxLength);
    }
});
</script>
@endsection
