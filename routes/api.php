<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgentAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BranchController;

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
Route::get('/vendors', [VendorController::class, 'apiIndex']);
Route::post('/vendors', [VendorController::class, 'apiStore']);
Route::get('/vendors/{vendor}', [VendorController::class, 'apiShow']);
Route::put('/vendors/{vendor}', [VendorController::class, 'apiUpdate']);
Route::delete('/vendors/{vendor}', [VendorController::class, 'apiDestroy']);

// Branch API routes
Route::get('/branches', [BranchController::class, 'apiIndex']);
Route::post('/branches', [BranchController::class, 'apiStore']);
Route::get('/branches/{branch}', [BranchController::class, 'apiShow']);
Route::put('/branches/{branch}', [BranchController::class, 'apiUpdate']);
Route::delete('/branches/{branch}', [BranchController::class, 'apiDestroy']);

// Default Laravel API route
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');