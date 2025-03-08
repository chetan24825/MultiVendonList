<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\RemoveWwwMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->prefix('advertiser')
                ->name('advertiser.')
                ->group(base_path('routes/advertiser.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(RemoveWwwMiddleware::class);
        $middleware->alias([
            'user.active' => \App\Http\Middleware\CheckUserStatus::class,
            'profile.registration' => \App\Http\Middleware\VerificationCustomer::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
