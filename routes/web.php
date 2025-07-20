<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LoginController;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Agent routes
Route::resource('agents', AgentController::class);

// Vendor routes
Route::resource('vendors', VendorController::class);

// Branch routes
Route::resource('branches', BranchController::class);

// Package routes
Route::resource('packages', PackageController::class);
Route::get('packages/export', [PackageController::class, 'export'])->name('packages.export');

// Visit routes
Route::resource('visits', VisitController::class);
Route::get('visits/export', [VisitController::class, 'export'])->name('visits.export');

// Report routes
Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

// Settings routes
Route::get('settings', [SettingController::class, 'index'])->name('settings.index');

// Add this route for timezone update
Route::post('settings/timezone', [\App\Http\Controllers\SettingController::class, 'updateTimezone'])->name('settings.timezone');

// User management routes and dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('settings/users', [SettingController::class, 'users'])->name('settings.users');
    Route::get('settings/users/create', [SettingController::class, 'createUser'])->name('settings.users.create');
    Route::post('settings/users', [SettingController::class, 'storeUser'])->name('settings.users.store');
    Route::get('settings/users/{id}/edit', [SettingController::class, 'editUser'])->name('settings.users.edit');
    Route::post('settings/users/{id}', [SettingController::class, 'updateUser'])->name('settings.users.update');
    Route::delete('settings/users/{id}', [SettingController::class, 'deleteUser'])->name('settings.users.delete');
});

// Role management routes
Route::middleware(['auth'])->group(function () {
    Route::get('settings/roles', [SettingController::class, 'listRoles'])->name('settings.roles');
    Route::get('settings/roles/create', [SettingController::class, 'createRole'])->name('settings.roles.create');
    Route::post('settings/roles', [SettingController::class, 'storeRole'])->name('settings.roles.store');
    Route::get('settings/roles/{id}/edit', [SettingController::class, 'editRole'])->name('settings.roles.edit');
    Route::post('settings/roles/{id}', [SettingController::class, 'updateRole'])->name('settings.roles.update');
    Route::delete('settings/roles/{id}', [SettingController::class, 'deleteRole'])->name('settings.roles.delete');
});

// Telescope route (only in local environment)
if (app()->environment('local')) {
    Route::get('/telescope', function () {
        return redirect('/telescope/requests');
    })->name('telescope');
}

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
    }
    $redirect = request('redirect');
    if ($redirect) {
        return redirect($redirect);
    }
    return redirect()->route('dashboard');
})->name('lang.switch');
