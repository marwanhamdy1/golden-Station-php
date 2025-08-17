@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" dir="rtl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">تعديل المندوب</h1>
        <a href="{{ route('agents.show', $agent) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
            <i class="fas fa-arrow-right ml-2"></i> العودة إلى المندوب
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
        <form action="{{ route('agents.update', $agent) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">المعلومات الأساسية</h3>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">الاسم الكامل</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $agent->name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="أدخل الاسم الكامل" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $agent->email) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="أدخل البريد الإلكتروني" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $agent->phone) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                               placeholder="أدخل رقم الهاتف" required>
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Location Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">معلومات الموقع</h3>

                    <div>
                        <label for="last_latitude" class="block text-sm font-medium text-gray-700 mb-2">آخر خط عرض</label>
                        <input type="number" id="last_latitude" name="last_latitude" value="{{ old('last_latitude', $agent->last_latitude) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_latitude') border-red-500 @enderror"
                               placeholder="أدخل خط العرض" step="any">
                        @error('last_latitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="last_longitude" class="block text-sm font-medium text-gray-700 mb-2">آخر خط طول</label>
                        <input type="number" id="last_longitude" name="last_longitude" value="{{ old('last_longitude', $agent->last_longitude) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_longitude') border-red-500 @enderror"
                               placeholder="أدخل خط الطول" step="any">
                        @error('last_longitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Password Section -->
            <div class="mt-8 border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">تغيير كلمة المرور (اختياري)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور الجديدة</label>
                        <input type="password" id="password" name="password"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                               placeholder="اتركه فارغاً للاحتفاظ بكلمة المرور الحالية" minlength="6">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">الحد الأدنى 6 أحرف</p>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
                <a href="{{ route('agents.show', $agent) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg ml-4">
                    إلغاء
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg flex items-center">
                    <i class="fas fa-save ml-2"></i> تحديث المندوب
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
