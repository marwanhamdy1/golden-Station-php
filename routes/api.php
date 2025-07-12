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
Route::get('/agents', [AgentController::class, 'apiIndex']);
Route::post('/agents', [AgentController::class, 'apiStore']);
Route::get('/agents/{agent}', [AgentController::class, 'apiShow']);
Route::put('/agents/{agent}', [AgentController::class, 'apiUpdate']);
Route::delete('/agents/{agent}', [AgentController::class, 'apiDestroy']);

// Vendor API routes
Route::get('/vendors', [VendorController::class, 'index']);
Route::post('/vendors', [VendorController::class, 'store'])->middleware('auth.agent');
Route::get('/vendors/{vendor}', [VendorController::class, 'show']);
Route::put('/vendors/{vendor}', [VendorController::class, 'update']);
Route::delete('/vendors/{vendor}', [VendorController::class, 'destroy']);
// Branch API routes
Route::apiResource('branches', BranchController::class);

// VendorVisit API routes
Route::apiResource('vendor-visits', VendorVisitController::class);

// Default Laravel API route
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
