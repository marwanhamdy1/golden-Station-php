@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Add New Branch</h1>
            <a href="{{ route('branches.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Branches
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('branches.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Vendor -->
                    <div class="md:col-span-2">
                        <label for="vendor_id" class="block text-sm font-medium text-gray-700 mb-2">Vendor *</label>
                        <select name="vendor_id" id="vendor_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('vendor_id') border-red-500 @enderror">
                            <option value="">Select Vendor</option>
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
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Branch Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="Enter branch name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mobile -->
                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-700 mb-2">Mobile Number *</label>
                        <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('mobile') border-red-500 @enderror"
                               placeholder="+966501234567">
                        @error('mobile')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="branch@company.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Assigned Agent -->
                    <div>
                        <label for="agent_id" class="block text-sm font-medium text-gray-700 mb-2">Assigned Agent</label>
                        <select name="agent_id" id="agent_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('agent_id') border-red-500 @enderror">
                            <option value="">Select Agent (Optional)</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                    {{ $agent->name }} (Agent #{{ str_pad($agent->id, 3, '0', STR_PAD_LEFT) }})
                                </option>
                            @endforeach
                        </select>
                        @error('agent_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                        <select name="city" id="city" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('city') border-red-500 @enderror">
                            <option value="">Select City</option>
                            <option value="Riyadh" {{ old('city') == 'Riyadh' ? 'selected' : '' }}>Riyadh</option>
                            <option value="Jeddah" {{ old('city') == 'Jeddah' ? 'selected' : '' }}>Jeddah</option>
                            <option value="Dammam" {{ old('city') == 'Dammam' ? 'selected' : '' }}>Dammam</option>
                            <option value="Mecca" {{ old('city') == 'Mecca' ? 'selected' : '' }}>Mecca</option>
                            <option value="Medina" {{ old('city') == 'Medina' ? 'selected' : '' }}>Medina</option>
                            <option value="Abha" {{ old('city') == 'Abha' ? 'selected' : '' }}>Abha</option>
                            <option value="Tabuk" {{ old('city') == 'Tabuk' ? 'selected' : '' }}>Tabuk</option>
                        </select>
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- District -->
                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-2">District</label>
                        <input type="text" name="district" id="district" value="{{ old('district') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('district') border-red-500 @enderror"
                               placeholder="Enter district">
                        @error('district')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Location Information -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Location Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <textarea name="address" id="address" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('address') border-red-500 @enderror"
                                      placeholder="Enter full address...">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location_url" class="block text-sm font-medium text-gray-700 mb-2">Location URL (Google Maps)</label>
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
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Branch Photos</h3>
                    <input type="file" name="photos[]" id="branch_photos" class="w-full px-3 py-2 border border-gray-300 rounded-lg" multiple>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('branches.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">
                        Cancel
                    </a>
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                        <i class="fas fa-save mr-2"></i> Create Branch
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
