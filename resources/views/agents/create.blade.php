@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('agents.create_agent') }}</h1>
            <a href="{{ route('agents.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> {{ __('agents.back_to_agents') }}
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('agents.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('agents.name') }} *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="{{ __('agents.enter_name') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('agents.email') }} *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="{{ __('agents.enter_email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">{{ __('agents.phone') }} *</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                               placeholder="{{ __('agents.enter_phone') }}">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">{{ __('agents.password') }} *</label>
                        <input type="password" name="password" id="password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                               placeholder="{{ __('agents.enter_password') }}">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Latitude -->
                    <div>
                        <label for="last_latitude" class="block text-sm font-medium text-gray-700 mb-2">{{ __('agents.last_latitude') }}</label>
                        <input type="number" step="any" name="last_latitude" id="last_latitude" value="{{ old('last_latitude') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_latitude') border-red-500 @enderror"
                               placeholder="24.7136">
                        @error('last_latitude')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Longitude -->
                    <div>
                        <label for="last_longitude" class="block text-sm font-medium text-gray-700 mb-2">{{ __('agents.last_longitude') }}</label>
                        <input type="number" step="any" name="last_longitude" id="last_longitude" value="{{ old('last_longitude') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_longitude') border-red-500 @enderror"
                               placeholder="46.6753">
                        @error('last_longitude')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('agents.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">
                        {{ __('agents.cancel') }}
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                        <i class="fas fa-save mr-2"></i> {{ __('agents.create_agent') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
