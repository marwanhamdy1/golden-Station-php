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

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

// Telescope route (only in local environment)
if (app()->environment('local')) {
    Route::get('/telescope', function () {
        return redirect('/telescope/requests');
    })->name('telescope');
}
