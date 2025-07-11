<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgentAuthController;

// API routes can be defined here if routes/api.php does not exist
Route::get('/', function () {
    return view('welcome');
});

// API routes
Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/login', [AuthController::class, 'login']);
Route::middleware(['auth:api'])->get('/api/profile', [AuthController::class, 'profile']);

Route::post('/api/agent/register', [AgentAuthController::class, 'register']);
Route::post('/api/agent/login', [AgentAuthController::class, 'login']);
Route::middleware(['auth:agent'])->get('/api/agent/profile', [AgentAuthController::class, 'profile']);