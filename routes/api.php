<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgentAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\VendorVisitController;
use App\Http\Controllers\Api\PackageController as ApiPackageController;
use App\Http\Controllers\Api\HomeController;


// User authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:api'])->get('/profile', [AuthController::class, 'profile']);

// Agent authentication routes
Route::post('/agent/register', [AgentAuthController::class, 'register']);
Route::post('/agent/login', [AgentAuthController::class, 'login']);
Route::middleware(['auth:agent'])->get('/agent/profile', [AgentAuthController::class, 'profile']);

// Dashboard API routes
Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);
Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData']);

// Agent API routes
Route::get('/agents', [AgentController::class, 'index']);
Route::post('/agents', [AgentController::class, 'apiStore']);
Route::get('/agents/{agent}', [AgentController::class, 'apiShow']);
Route::put('/agents/{agent}', [AgentController::class, 'apiUpdate']);
Route::delete('/agents/{agent}', [AgentController::class, 'apiDestroy']);

// Vendor API routes
Route::get('/vendors', [VendorController::class, 'index'])->middleware('auth.agent');
Route::post('/vendors', [VendorController::class, 'store'])->middleware('auth.agent');
Route::get('/vendors/{vendor}', [VendorController::class, 'show'])->middleware('auth.agent');
Route::put('/vendors/{vendor}', [VendorController::class, 'update']);
Route::delete('/vendors/{vendor}', [VendorController::class, 'destroy']);
// Branch API routes
Route::apiResource('branches', BranchController::class)->middleware('auth.agent')->names([
    'index' => 'api.branches.index',
    'store' => 'api.branches.store',
    'show' => 'api.branches.show',
    'update' => 'api.branches.update',
    'destroy' => 'api.branches.destroy'
]);

// VendorVisit API routes
Route::apiResource('vendor-visits', VendorVisitController::class)->middleware('auth.agent')->names([
    'index' => 'api.vendor-visits.index',
    'store' => 'api.vendor-visits.store',
    'show' => 'api.vendor-visits.show',
    'update' => 'api.vendor-visits.update',
    'destroy' => 'api.vendor-visits.destroy'
]);

// Package API routes
Route::post('/packages/select', [ApiPackageController::class, 'selectPackages']);
Route::get('/packages', [ApiPackageController::class, 'index']);

// Home summary API routes
Route::middleware(['auth:agent'])->get('/home/summary', [HomeController::class, 'summary']);
Route::middleware(['auth:agent'])->get('/agent/details', [HomeController::class, 'agentDetails']);

// Default Laravel API route
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
