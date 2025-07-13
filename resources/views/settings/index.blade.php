@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">System Settings</h1>
            <p class="text-gray-600 mt-2">Configure your application settings and preferences</p>
        </div>

        <!-- Settings Sections -->
        <div class="space-y-8">
            <!-- General Settings -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-6">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <i class="fas fa-cog text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">General Settings</h2>
                        <p class="text-gray-600">Basic application configuration</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Application Name</h3>
                            <p class="text-sm text-gray-500">Display name for your application</p>
                        </div>
                        <div class="flex items-center">
                            <input type="text" value="GoldenStation" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button class="ml-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                                Save
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Default Currency</h3>
                            <p class="text-sm text-gray-500">Currency used throughout the application</p>
                        </div>
                        <div class="flex items-center">
                            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="SAR" selected>Saudi Riyal (SAR)</option>
                                <option value="USD">US Dollar (USD)</option>
                                <option value="EUR">Euro (EUR)</option>
                            </select>
                            <button class="ml-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                                Save
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Time Zone</h3>
                            <p class="text-sm text-gray-500">Default timezone for date and time display</p>
                        </div>
                        <div class="flex items-center">
                            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="Asia/Riyadh" selected>Asia/Riyadh (GMT+3)</option>
                                <option value="UTC">UTC (GMT+0)</option>
                                <option value="America/New_York">America/New_York (GMT-5)</option>
                            </select>
                            <button class="ml-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-6">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <i class="fas fa-bell text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Notification Settings</h2>
                        <p class="text-gray-600">Configure how you receive notifications</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Email Notifications</h3>
                            <p class="text-sm text-gray-500">Receive notifications via email</p>
                        </div>
                        <div class="flex items-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">SMS Notifications</h3>
                            <p class="text-sm text-gray-500">Receive notifications via SMS</p>
                        </div>
                        <div class="flex items-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Visit Reminders</h3>
                            <p class="text-sm text-gray-500">Get reminded about upcoming visits</p>
                        </div>
                        <div class="flex items-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-6">
                    <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                        <i class="fas fa-shield-alt text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Security Settings</h2>
                        <p class="text-gray-600">Manage your account security</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Two-Factor Authentication</h3>
                            <p class="text-sm text-gray-500">Add an extra layer of security to your account</p>
                        </div>
                        <div class="flex items-center">
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Not Enabled</span>
                            <button class="ml-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                                Enable
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Session Timeout</h3>
                            <p class="text-sm text-gray-500">Automatically log out after inactivity</p>
                        </div>
                        <div class="flex items-center">
                            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="30">30 minutes</option>
                                <option value="60" selected>1 hour</option>
                                <option value="120">2 hours</option>
                                <option value="480">8 hours</option>
                            </select>
                            <button class="ml-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                                Save
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Password Policy</h3>
                            <p class="text-sm text-gray-500">Configure password requirements</p>
                        </div>
                        <div class="flex items-center">
                            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                                Configure
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data & Privacy -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-6">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                        <i class="fas fa-database text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Data & Privacy</h2>
                        <p class="text-gray-600">Manage your data and privacy settings</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Data Export</h3>
                            <p class="text-sm text-gray-500">Download all your data</p>
                        </div>
                        <div class="flex items-center">
                            <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">
                                Export Data
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Account Deletion</h3>
                            <p class="text-sm text-gray-500">Permanently delete your account and all data</p>
                        </div>
                        <div class="flex items-center">
                            <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">
                                Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
