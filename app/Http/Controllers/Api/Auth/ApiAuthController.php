<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\JwtService;
use Illuminate\Http\Request;

class ApiAuthController extends Controller
{
    public function __construct(
        private AuthService $authService,
        private JwtService $jwtService,
    ) {}

    /**
     * Login
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:100',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);

        $user = $this->authService->authenticate(
            $validated['username'],
            $validated['password']
        );

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid username or password.',
            ], 401);
        }

        $tokens = $this->authService->createTokens(
            $request,
            $user
        );

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',

            'user' => [
                'id' => $user->user_id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role->role_name,
            ],

            'tokens' => $tokens,
        ]);
    }

    /**
     * Refresh access token
     */
    public function refresh(Request $request, ?string $refreshToken = null)
    {
        $refreshToken = $request->cookie('refresh-token'); // Get refresh token from cookie
        // $refreshToken = $request->bearerToken(); // Get access token from Authorization header
        // $refreshToken = $request->header('refresh-token'); // Get refresh token from custom header

        if (! $refreshToken) {
            $refreshToken = $request->bearerToken(); // Get refresh token from Authorization header
        }

        if (! $refreshToken) {
            return response()->json([
                'success' => false,
                'message' => 'Refresh token is missing.',
            ], 401);
        }

        $tokens = $this->authService->refreshTokens(
            $request,
            $refreshToken,
        );

        if (! $tokens) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired refresh token.',
            ], 401);
        }

        $response = response()->json([
            'success' => true,
            'message' => 'Token refreshed successfully.',
            'tokens' => $tokens,
        ]);

        $accessTokenTtl = max(
            1,
            (int) ceil(
                $tokens['expires_in'] / 60
            )
        );

        // $refreshTokenTtl = max(
        //     1,
        //     (int) ceil(
        //         $tokens['refresh_expires_in'] / 60
        //     )
        // );

        /*
         * Frontend display data.
         *
         * No password.
         * No JWT.
         * No refresh token.
         */

        $secure = app()->environment('production');

        return $response

            /*
             * Access token
             *
             * HttpOnly = true
             */
            ->withCookie(
                cookie(
                    'access-token',
                    $tokens['access_token'],
                    $accessTokenTtl,
                    '/',
                    null,
                    $secure,
                    true,
                    false,
                    'Lax'
                )
            )

            /*
             * Refresh token
             *
             * HttpOnly = true
             */
            // ->withCookie(
            //     cookie(
            //         'refresh-token',
            //         $tokens['refresh_token'],
            //         $refreshTokenTtl,
            //         '/',
            //         null,
            //         $secure,
            //         true,
            //         false,
            //         'Lax'
            //     )
            // )

            /*
             * Device ID
             *
             * HttpOnly = true
             */
            ->withCookie(
                cookie(
                    'device_id',
                    $tokens['device_id'],
                    60 * 24 * 30,
                    '/',
                    null,
                    $secure,
                    true,
                    false,
                    'Lax'
                )
            );
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        // $accessToken = $request->bearerToken();
        $refreshToken = $request->cookie('refresh-token');

        if (! $refreshToken) {
            return response()->json([
                'success' => false,
                'message' => 'Refresh token is required.',
            ], 401);
        }

        $this->authService->logout($refreshToken);

        return response()->json([
            'success' => true,
            'message' => 'Logout successful.',
        ]);
    }

    /**
     * Check access token
     */
    public function token(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Access token
        |--------------------------------------------------------------------------
        */

        $accessToken = $request->cookie('access-token');
        $refreshToken = $request->cookie('refresh-token');

        // $refreshPayload = null;

        // if ($refreshToken) {
        //     $refreshPayload = $this->jwtService
        //         ->decodeRefreshToken($refreshToken);
        // }

        if (! $accessToken) {
            $accessToken = $request->bearerToken();
        }

        if (! $accessToken) {
            return response()->json([
                'success' => false,
                'message' => 'Access token is required.',
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | JWT payload
        |--------------------------------------------------------------------------
        */

        $payload = $this->authService->getTokenPayload(
            $accessToken
        );

        if (! $payload) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired access token.',
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | Authenticated user
        |--------------------------------------------------------------------------
        */

        $user = $request->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | Token database record
        |--------------------------------------------------------------------------
        */

        $userToken = $request->attributes->get('userToken');

        // $refreshTokenHash = hash(
        //     'sha256',
        //     $refreshToken
        // );

        // $rawRefreshToken = $jwtService->decodeToken(
        //     $refreshToken,
        //     'refresh_token'
        // );

        if (! $userToken) {
            return response()->json([
                'success' => false,
                'message' => 'Token record not found.',
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | Expiration
        |--------------------------------------------------------------------------
        */

        $now = now()->timestamp;

        $issuedAt = isset($payload['iat'])
            ? (int) $payload['iat']
            : null;

        $expiresAt = isset($payload['exp'])
            ? (int) $payload['exp']
            : null;

        $remainingSeconds = $expiresAt !== null
            ? max(0, $expiresAt - $now)
            : null;

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'message' => 'Token is valid.',

            'user' => [
                'id' => $user->user_id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role?->role_name,
            ],

            'token' => [
                'type' => 'Bearer',
                'valid' => true,

                'algorithm' => $payload['alg'] ?? 'HS256',
                'issuer' => $payload['iss'] ?? null,
                'type_claim' => $payload['type'] ?? null,

                'jti' => $payload['jti'] ?? null,
                'subject' => $payload['sub'] ?? null,

                'access_token' => $accessToken ?? null,

                'refresh_token_hash' => $userToken->refresh_token ?? null,

                'issued_at' => $issuedAt
                    ? date('Y-m-d H:i:s', $issuedAt)
                    : null,
                'access_jti' => $payload['jti'] ?? null,
                'refresh_jti' => $refreshPayload['jti'] ?? null,

                'access_expires_at' => isset($payload['exp'])
                    ? date('Y-m-d H:i:s', (int) $payload['exp'])
                    : null,

                'refresh_expires_at' => isset($refreshPayload['exp'])
                    ? date('Y-m-d H:i:s', (int) $refreshPayload['exp'])
                    : null,

                'expires_at' => $expiresAt
                    ? date('Y-m-d H:i:s', $expiresAt)
                    : null,

                'remaining_seconds' => $remainingSeconds,

                'remaining_minutes' => $remainingSeconds !== null
                    ? (int) ceil($remainingSeconds / 60)
                    : null,
            ],

        ]);
    }
}
