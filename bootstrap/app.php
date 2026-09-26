<?php

use App\Http\Middleware\AdminMiddleware;
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
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // На Vercel дублируем ошибки напрямую в stderr, даже если сам логгер Laravel не сработал.
        $exceptions->report(function (Throwable $e) {
            if (getenv('VERCEL')) {
                for ($ex = $e; $ex; $ex = $ex->getPrevious()) {
                    error_log(get_class($ex).': '.$ex->getMessage().' at '.$ex->getFile().':'.$ex->getLine());
                }
            }
        });
    })->create();
