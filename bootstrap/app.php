<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'rol' => \App\Http\Middleware\VerificarRol::class,
            'sincache' => \App\Http\Middleware\SinCache::class,
            'aprobado' => \App\Http\Middleware\RepartidorAprobado::class,
    ]);
        // Si un usuario ya logueado entra a /login, lo manda a su portal
        $middleware->redirectUsersTo(fn() => route('panel'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
