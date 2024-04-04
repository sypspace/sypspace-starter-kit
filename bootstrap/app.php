<?php

use BezhanSalleh\FilamentExceptions\FilamentExceptions;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->reportable(function (Throwable $e) {
            FilamentExceptions::report($e);
        });
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('backup:clean')->daily()->at('00:00');
        $schedule->command('backup:run')->weekly()->at('01:00');
    })
    ->create();
