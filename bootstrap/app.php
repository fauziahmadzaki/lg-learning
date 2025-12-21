<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckBranchAccess;
use App\Http\Middleware\CheckCentralAdmin;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->group(base_path('routes/branch.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        // $middleware->trustProxies(at: '*');

       $middleware->alias([
        'central.admin' => CheckCentralAdmin::class,
        'branch.check' => CheckBranchAccess::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class, // <--- Add this
       ]) ;

       $middleware->validateCsrfTokens(except: [
        'api/xendit/callback', // <--- PENTING! Izinkan route ini
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
