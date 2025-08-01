<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SetLocale;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register route middleware aliases
        $middleware->alias([
            'auth.agent' => \App\Http\Middleware\AuthenticateAgent::class,
            // Spatie permission middleware
            'role' =>  Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' =>  Spatie\Permission\Middleware\PermissionMiddleware::class,
        ]);
        // Register SetLocale as global middleware
        $middleware->append([SetLocale::class]);
        // Register global CORS middleware
        $middleware->append([\Illuminate\Http\Middleware\HandleCors::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
