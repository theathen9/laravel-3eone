<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\JwtService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebTokenAuth
{
    public function __construct(
        private JwtService $jwtService
    ) {}

    public function handle(
        Request $request,
        Closure $next
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | 1. Get access token
        |--------------------------------------------------------------------------
        */

        $accessToken = $request->cookie('access-token');

        if (! $accessToken) {
            return redirect()->route('auth.signin');
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Verify JWT
        |--------------------------------------------------------------------------
        */

        $payload = $this->jwtService->payload(
            $accessToken
        );

        if (! $payload) {
            return redirect()->route('auth.signin');
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Get user ID from JWT
        |--------------------------------------------------------------------------
        */

        $userId = $payload['sub']
            ?? $payload['user_id']
            ?? null;

        if (! $userId) {
            return redirect()->route('auth.signin');
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Load active user
        |--------------------------------------------------------------------------
        */

        $user = User::query()
            ->with('role')
            ->where('user_id', $userId)
            ->where('status', 1)
            ->first();

        if (! $user) {
            return redirect()->route('auth.signin');
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Make user available to request
        |--------------------------------------------------------------------------
        */

        $request->setUserResolver(
            fn () => $user
        );

        /*
        |--------------------------------------------------------------------------
        | 6. Continue
        |--------------------------------------------------------------------------
        */

        return $next($request);
    }
}
