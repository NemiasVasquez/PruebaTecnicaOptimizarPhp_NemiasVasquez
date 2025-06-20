<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Http\Middleware\JwtMiddleware2;
use App\Http\Middleware\HandleErrors;
use App\Http\Middleware\TransactionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $url= env('APP_URL');
        $middleware->validateCsrfTokens(except: [
            'http://127.0.0.1:8000/*',
            $url.'/*',//Aquí actualizaz la url automáticamente.
        ]);


    })

    ->withExceptions(function (Exceptions $exceptions) {
    })->create();
