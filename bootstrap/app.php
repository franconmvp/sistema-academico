<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\DocenteMiddleware;
use App\Http\Middleware\EstudianteMiddleware;
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
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'docente' => DocenteMiddleware::class,
            'estudiante' => EstudianteMiddleware::class,
            'role' => CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
