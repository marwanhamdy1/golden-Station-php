<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BranchController;

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

// Telescope route (only in local environment)
if (app()->environment('local')) {
    Route::get('/telescope', function () {
        return redirect('/telescope/requests');
    })->name('telescope');
}
