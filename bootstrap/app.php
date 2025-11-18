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
    ->withMiddleware(function (Middleware $middleware) {
        // mendaftarkan alias route middleware
    $middleware->alias([
        'isAdmin' => \App\Http\Middleware\IsAdmin::class,
        'isUser' => \App\Http\Middleware\IsUser::class,
        //tambahkan alias lain di sini
        'providers' => [
        Maatwebsite\Excel\ExcelServiceProvider::class,],
        'aliases' => ['Excel' => Maatwebsite\Excel\Facades\Excel::class,],

    ]);

    // atau tambahkan ke grup "api"
    $middleware->api(append: [
        // e.g. SomeApiMiddleware::class,
        ]);
    })  

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
    