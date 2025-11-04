<?php

use App\Http\Middleware\CheckForcePasswordChange;
use App\Http\Middleware\EnsureEmailIsVerified;
use App\Providers\MenuServiceProvider;
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
        // Register your custom middleware
        $middleware->alias([
            'email_verified' => EnsureEmailIsVerified::class,
            'force_password_change' => CheckForcePasswordChange::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\ShareMenuData::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
