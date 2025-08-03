@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('packages.index') }}" class="text-blue-600 hover:text-blue-700 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">
                {{ app()->getLocale() == 'ar' ? 'إنشاء باقة جديدة' : 'Create New Package' }}
            </h1>
        </div>
        <p class="text-gray-600">
            {{ app()->getLocale() == 'ar' ? 'أضف باقة خدمة جديدة إلى عروضك' : 'Add a new service package to your offerings' }}
        </p>
    </div>

    <!-- Form -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('packages.store') }}" method="POST">
                @csrf

                <!-- Package Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ app()->getLocale() == 'ar' ? 'اسم الباقة' : 'Package Name' }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: الباقة المميزة' : 'e.g., Premium Package' }}">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ app()->getLocale() == 'ar' ? 'الوصف' : 'Description' }}
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="{{ app()->getLocale() == 'ar' ? 'اوصف مميزات وفوائد الباقة' : 'Describe the package features and benefits' }}">{{ old('description') }}</textarea>
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
                                   inputmode="decimal"
                                   pattern="[0-9]*\.?[0-9]*"
                                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror"
                                   placeholder="0.00"
                                   style="direction: ltr; text-align: left;">
                        </div>
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Limit -->
                    <div>
                        <label for="product_limit" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'حد المنتجات' : 'Product Limit' }}
                        </label>
                        <input type="number"
                               id="product_limit"
                               name="product_limit"
                               value="{{ old('product_limit') }}"
                               min="1"
                               inputmode="numeric"
                               pattern="[0-9]*"
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
                        {{ app()->getLocale() == 'ar' ? 'المدة (بالأيام)' : 'Duration (Days)' }}
                    </label>
                    <input type="number"
                           id="duration_in_days"
                           name="duration_in_days"
                           value="{{ old('duration_in_days') }}"
                           min="1"
                           inputmode="numeric"
                           pattern="[0-9]*"
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
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">
                            {{ app()->getLocale() == 'ar' ? 'باقة مفعلة' : 'Active Package' }}
                        </span>
                    </label>
                    <p class="text-gray-500 text-sm mt-1">
                        {{ app()->getLocale() == 'ar' ? 'الباقات غير المفعلة لن تكون متاحة للاختيار' : 'Inactive packages won\'t be available for selection' }}
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('packages.index') }}"
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        {{ app()->getLocale() == 'ar' ? 'إنشاء الباقة' : 'Create Package' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Auto-format price input and ensure English numbers only
document.getElementById('price').addEventListener('input', function(e) {
    let value = e.target.value;

    // Convert Arabic numerals to English if any
    value = value.replace(/[٠-٩]/g, function(d) {
        return String.fromCharCode(d.charCodeAt(0) - '٠'.charCodeAt(0) + '0'.charCodeAt(0));
    });

    // Remove any non-numeric characters except decimal point
    value = value.replace(/[^\d.]/g, '');

    // Ensure only one decimal point
    const parts = value.split('.');
    if (parts.length > 2) {
        value = parts[0] + '.' + parts.slice(1).join('');
    }

    // Update the input value
    e.target.value = value;

    // Format to 2 decimal places on blur
    if (value && !isNaN(value) && value !== '') {
        if (e.type === 'blur') {
            e.target.value = parseFloat(value).toFixed(2);
        }
    }
});

// Format price on blur
document.getElementById('price').addEventListener('blur', function(e) {
    let value = e.target.value;
    if (value && !isNaN(value) && value !== '') {
        e.target.value = parseFloat(value).toFixed(2);
    }
});

// Ensure English numbers for numeric fields
function enforceEnglishNumbers(inputId) {
    document.getElementById(inputId).addEventListener('input', function(e) {
        let value = e.target.value;

        // Convert Arabic numerals to English
        value = value.replace(/[٠-٩]/g, function(d) {
            return String.fromCharCode(d.charCodeAt(0) - '٠'.charCodeAt(0) + '0'.charCodeAt(0));
        });

        // Remove any non-numeric characters
        value = value.replace(/[^\d]/g, '');

        e.target.value = value;
    });
}

// Apply to numeric fields
enforceEnglishNumbers('product_limit');
enforceEnglishNumbers('duration_in_days');

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

// Prevent Arabic keyboard input for numeric fields
function preventArabicKeyboard(inputId) {
    document.getElementById(inputId).addEventListener('keydown', function(e) {
        // Allow backspace, delete, tab, escape, enter
        if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
            // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
            (e.keyCode === 65 && e.ctrlKey === true) ||
            (e.keyCode === 67 && e.ctrlKey === true) ||
            (e.keyCode === 86 && e.ctrlKey === true) ||
            (e.keyCode === 88 && e.ctrlKey === true) ||
            // Allow home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            return;
        }

        // For price field, allow decimal point
        if (inputId === 'price' && (e.keyCode === 190 || e.keyCode === 110)) {
            return;
        }

        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
}

// Apply keyboard restrictions
preventArabicKeyboard('price');
preventArabicKeyboard('product_limit');
preventArabicKeyboard('duration_in_days');
</script>
@endsection