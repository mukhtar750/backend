<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);
        $middleware->alias([
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
            'admin' => \App\Http\Middleware\IsAdmin::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class, // Added for role-based access
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
