<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UserToken;
use App\Services\JwtService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtAuthenticate
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
        | Get Bearer token
        |--------------------------------------------------------------------------
        */

        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Access token is required.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | Decode + cryptographically validate JWT
        |--------------------------------------------------------------------------
        */

        $payload = $this->jwtService->decode(
            $token
        );

        if (!$payload) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired access token.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | Find active token session
        |--------------------------------------------------------------------------
        |
        | This is what makes logout/revocation work.
        |
        */

        $userToken = UserToken::query()
            ->where('jti', $payload['jti'])
            ->whereNull('revoked_at')
            ->where(
                'access_expiry',
                '>',
                now()
            )
            ->first();

        if (!$userToken) {
            return response()->json([
                'success' => false,
                'message' => 'Access token has been revoked.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | Find active user
        |--------------------------------------------------------------------------
        */

        $user = User::query()
            ->with('role')
            ->where(
                'user_id',
                $payload['sub']
            )
            ->where('status', true)
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found or disabled.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | Optional consistency check
        |--------------------------------------------------------------------------
        |
        | Make sure the token session belongs to the
        | same user contained in the JWT subject.
        |
        */

        if (
            (string) $userToken->user_id
            !== (string) $user->user_id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid authentication session.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | Make authenticated user available
        |--------------------------------------------------------------------------
        |
        | Allows:
        |
        | $request->user()
        |
        */

        $request->setUserResolver(
            fn () => $user
        );


        /*
        |--------------------------------------------------------------------------
        | Optional: expose JWT/session data
        |--------------------------------------------------------------------------
        */

        $request->attributes->set(
            'jwt_payload',
            $payload
        );

        $request->attributes->set(
            'user_token',
            $userToken
        );


        return $next($request);
    }
}
