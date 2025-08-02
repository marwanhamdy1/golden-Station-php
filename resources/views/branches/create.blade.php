@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('branches.add_branch') }}</h1>
            <a href="{{ route('branches.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> {{ __('branches.back') }}
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('branches.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Vendor -->
                    <div class="md:col-span-2">
                        <label for="vendor_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.vendor_name') }} *</label>
                        <select name="vendor_id" id="vendor_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('vendor_id') border-red-500 @enderror">
                            <option value="">{{ __('branches.select_vendor') }}</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->commercial_name }} ({{ $vendor->owner_name }})
                                </option>
                            @endforeach
                        </select>
                        @error('vendor_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Branch Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.branch_name') }} *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="{{ __('branches.enter_branch_name') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mobile -->
                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.phone') }} *</label>
                        <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('mobile') border-red-500 @enderror"
                               placeholder="+966501234567">
                        @error('mobile')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.email') }}</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="branch@company.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Assigned Agent -->
                    <div>
                        <label for="agent_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.agent') }}</label>
                        <select name="agent_id" id="agent_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('agent_id') border-red-500 @enderror">
                            <option value="">{{ __('branches.select_agent') }}</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                    {{ $agent->name }} ({{ __('branches.agent') }} #{{ str_pad($agent->id, 3, '0', STR_PAD_LEFT) }})
                                </option>
                            @endforeach
                        </select>
                        @error('agent_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.city') }}</label>
                        <select name="city" id="city" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('city') border-red-500 @enderror">
                            <option value="">{{ __('branches.select_city') }}</option>
                            <option value="Riyadh" {{ old('city') == 'Riyadh' ? 'selected' : '' }}>{{ __('branches.riyadh') }}</option>
                            <option value="Jeddah" {{ old('city') == 'Jeddah' ? 'selected' : '' }}>{{ __('branches.jeddah') }}</option>
                            <option value="Dammam" {{ old('city') == 'Dammam' ? 'selected' : '' }}>{{ __('branches.dammam') }}</option>
                            <option value="Mecca" {{ old('city') == 'Mecca' ? 'selected' : '' }}>{{ __('branches.mecca') }}</option>
                            <option value="Medina" {{ old('city') == 'Medina' ? 'selected' : '' }}>{{ __('branches.medina') }}</option>
                            <option value="Abha" {{ old('city') == 'Abha' ? 'selected' : '' }}>{{ __('branches.abha') }}</option>
                            <option value="Tabuk" {{ old('city') == 'Tabuk' ? 'selected' : '' }}>{{ __('branches.tabuk') }}</option>
                        </select>
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- District -->
                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.district') }}</label>
                        <input type="text" name="district" id="district" value="{{ old('district') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('district') border-red-500 @enderror"
                               placeholder="{{ __('branches.enter_district') }}">
                        @error('district')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Location Information -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('branches.location_details') }}</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.address') }}</label>
                            <textarea name="address" id="address" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('address') border-red-500 @enderror"
                                      placeholder="{{ __('branches.enter_address') }}">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location_url" class="block text-sm font-medium text-gray-700 mb-2">{{ __('branches.location_url') }}</label>
                            <input type="url" name="location_url" id="location_url" value="{{ old('location_url') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('location_url') border-red-500 @enderror"
                                   placeholder="https://maps.google.com/...">
                            @error('location_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('branches.branch_photos') }}</h3>
                    <input type="file" name="photos[]" id="branch_photos" class="w-full px-3 py-2 border border-gray-300 rounded-lg" multiple>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('branches.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">
                        {{ __('branches.cancel') }}
                    </a>
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                        <i class="fas fa-save mr-2"></i> {{ __('branches.create_branch') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
