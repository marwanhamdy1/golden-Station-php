@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ __('branches.edit_branch') }}</h1>
        <a href="{{ route('branches.show', $branch) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> {{ __('branches.back') }}
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
        <form action="{{ route('branches.update', $branch) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('branches.basic_information') }}</h3>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.branch_name') }}</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $branch->name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="{{ __('branches.enter_branch_name') }}" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.phone') }}</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $branch->phone) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                               placeholder="{{ __('branches.enter_phone') }}" required>
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.email') }}</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $branch->email) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="{{ __('branches.enter_email') }}">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Location Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('branches.location_details') }}</h3>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.address') }}</label>
                        <textarea id="address" name="address" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror"
                                  placeholder="{{ __('branches.enter_address') }}" required>{{ old('address', $branch->address) }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.latitude') }}</label>
                            <input type="number" id="latitude" name="latitude" value="{{ old('latitude', $branch->latitude) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('latitude') border-red-500 @enderror"
                                   placeholder="{{ __('branches.enter_latitude') }}" step="any">
                            @error('latitude')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.longitude') }}</label>
                            <input type="number" id="longitude" name="longitude" value="{{ old('longitude', $branch->longitude) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('longitude') border-red-500 @enderror"
                                   placeholder="{{ __('branches.enter_longitude') }}" step="any">
                            @error('longitude')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="location_url" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.google_url') }}</label>
                        <input type="url" id="location_url" name="location_url" value="{{ old('location_url', $branch->location_url) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('location_url') border-red-500 @enderror"
                               placeholder="{{ __('branches.enter_google_url') }}">
                        @error('location_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Agent Assignment -->
            <div class="mt-8 border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('branches.agent_assignment') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="agent_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.assign_to_agent') }}</label>
                        <select id="agent_id" name="agent_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('agent_id') border-red-500 @enderror">
                            <option value="">{{ __('branches.select_agent') }}</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ old('agent_id', $branch->agent_id) == $agent->id ? 'selected' : '' }}>
                                    {{ $agent->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('agent_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
                <a href="{{ route('branches.show', $branch) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg">
                    {{ __('branches.cancel') }}
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg flex items-center">
                    <i class="fas fa-save mr-2"></i> {{ __('branches.update') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection