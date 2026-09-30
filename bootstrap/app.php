<?php

use App\Http\Middleware\ApiAuth;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\WebTokenAuth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(
    basePath: dirname(__DIR__)
)
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (
        Middleware $middleware
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Guest redirect
        |--------------------------------------------------------------------------
        */

        $middleware->redirectGuestsTo(
            fn () => route('auth.signin')
        );

        /*
        |--------------------------------------------------------------------------
        | Cookie Encryption
        |--------------------------------------------------------------------------
        */

        $middleware->encryptCookies(except: [
            'access-token',
            'refresh-token',
            // 'c_user',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Middleware Aliases
        |--------------------------------------------------------------------------
        */

        $middleware->alias([
            'role' => RoleMiddleware::class,

            'api.auth' => ApiAuth::class,

            'web.token' => WebTokenAuth::class,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Trust Proxies
        |--------------------------------------------------------------------------
        */

        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO
        );
    })

    ->withExceptions(function (
        Exceptions $exceptions
    ): void {

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*')
        );
    })

    ->create();
