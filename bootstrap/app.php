<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
            'subsystem.auth' => \App\Http\Middleware\SubsystemAuth::class,
            'subsystem.scope' => \App\Http\Middleware\SubsystemScope::class,
        ]);

        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

          $middleware->api(prepend: [
             \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
]);    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'الموارد المطلوب غير موجود'], 404);
            }
        });
    })->create();
