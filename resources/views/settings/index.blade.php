@extends('layouts.app')

@section('content')
@php
    $isSuperadmin = auth()->check() && auth()->user()->hasRole('superadmin');
    $userRole = auth()->check() ? auth()->user()->roles->pluck('name')->implode(', ') : __('settings.guest');
    $currentTimezone = \App\Models\Setting::where('key', 'timezone')->value('value') ?? config('app.timezone');
@endphp
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('settings.system_settings') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('settings.settings_description') }}</p>
            <span class="inline-block mt-2 px-3 py-1 bg-gray-200 text-gray-800 text-xs rounded-full">{{ __('settings.your_role') }}: {{ $userRole }}</span>
        </div>

        <!-- Admin Functions Overview -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-primary mb-4">{{ __('settings.admin_functions') }}</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                @if($isSuperadmin)
                    <li>
                        <a href="{{ route('settings.users') }}" class="text-blue-600 hover:underline font-medium">
                            {{ __('settings.user_management') }}
                        </a> - {{ __('settings.user_management_desc') }}
                    </li>
                @else
                    <li>
                        <span class="text-gray-400 font-medium cursor-not-allowed" title="{{ __('settings.superadmin_only') }}">{{ __('settings.user_management') }}</span> - <span class="text-xs">({{ __('settings.superadmin_only') }})</span>
                    </li>
                @endif
                <li>
                    <span class="text-gray-400 font-medium">{{ __('settings.role_management') }}</span> - <span class="text-xs">({{ __('settings.coming_soon') }})</span>
                </li>
                <li>
                    <span class="text-gray-400 font-medium">{{ __('settings.permission_management') }}</span> - <span class="text-xs">({{ __('settings.coming_soon') }})</span>
                </li>
                <li>
                    <span class="text-gray-400 font-medium">{{ __('settings.laravel_config_control') }}</span> - <span class="text-xs">({{ __('settings.superadmin_only_coming_soon') }})</span>
                </li>
            </ul>
        </div>

        <!-- Timezone Control -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center mb-6">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ __('settings.server_timezone') }}</h2>
                    <p class="text-gray-600">{{ __('settings.timezone_description') }}</p>
                </div>
            </div>
            @if(session('success'))
                <div class="mb-4 text-green-600 font-semibold">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('settings.timezone') }}" class="flex items-center space-x-4">
                @csrf
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" name="timezone" @if(!$isSuperadmin) disabled @endif>
                    <option value="Asia/Riyadh" {{ $currentTimezone == 'Asia/Riyadh' ? 'selected' : '' }}>{{ __('settings.ksa_timezone') }}</option>
                    <option value="Africa/Cairo" {{ $currentTimezone == 'Africa/Cairo' ? 'selected' : '' }}>{{ __('settings.egypt_timezone') }}</option>
                    <option value="UTC" {{ $currentTimezone == 'UTC' ? 'selected' : '' }}>{{ __('settings.utc_timezone') }}</option>
                </select>
                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm @if(!$isSuperadmin) opacity-50 cursor-not-allowed @endif" @if(!$isSuperadmin) disabled @endif>{{ __('settings.save') }}</button>
                <span class="text-xs text-gray-500">{{ __('settings.current') }}: <span class="font-semibold">{{ $currentTimezone }}</span></span>
            </form>
            <div class="text-xs text-gray-400 mt-2">({{ __('settings.timezone_control_coming_soon') }})</div>
        </div>
    </div>
</div>
@endsection