<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function (Request $request) {
            return route('login');
        });
        $middleware->redirectUsersTo(function (Request $request) {
            $user = \Illuminate\Support\Facades\Auth::user();
            if (!$user) {
                return route('login');
            }
            return match($user->role) {
                'admin' => route('admin.dashboard'),
                'guru' => route('guru.dashboard'),
                'siswa' => route('siswa.dashboard'),
                'satpam' => route('satpam.dashboard'),
                'user' => route('siswa.dashboard'), // legacy alias
                default => route('landing'),
            };
        });
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();