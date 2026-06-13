<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Your session has expired. Please log in again.'], 419);
            }

            if (auth()->check()) {
                return auth()->user()?->name === 'TestAdmin'
                    ? redirect()->route('admin')->with('success', 'Your session was refreshed automatically.')
                    : redirect()->route('home1')->with('success', 'Your session was refreshed automatically.');
            }

            return redirect()
                ->route('login')
                ->with('error', 'Your session has expired. Please log in again.');
        });
    })->create();
