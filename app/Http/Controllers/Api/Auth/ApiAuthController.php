<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class ApiAuthController extends Controller
{
    public function __construct(
        private AuthService $authService
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
    public function refresh(Request $request)
    {
        $refreshToken = $request->cookie('refresh-token');

        if (! $refreshToken) {
            return response()->json([
                'success' => false,
                'message' => 'Refresh token is missing.',
            ], 401);
        }

        $tokens = $this->authService->refreshTokens(
            $request,
            $refreshToken
        );

        if (! $tokens) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired refresh token.',
            ], 401);
        }

        $secure = app()->environment('production');

        $response = response()->json([
            'success' => true,
            'message' => 'Token refreshed successfully.',
        ]);

        $response->withCookie(
            cookie(
                'access-token',
                $tokens['access_token'],
                ceil($tokens['expires_in'] / 60),
                '/',
                null,
                $secure,
                true,
                false,
                'Lax'
            )
        );

        // $response->withCookie(
        //     cookie(
        //         'refresh-token',
        //         $tokens['refresh_token'],
        //         ceil($tokens['refresh_expires_in'] / 60),
        //         '/',
        //         null,
        //         $secure,
        //         true,
        //         false,
        //         'Lax'
        //     )
        // );

        return $response;
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $accessToken = $request->bearerToken();

        if (! $accessToken) {
            return response()->json([
                'success' => false,
                'message' => 'Access token is required.',
            ], 401);
        }

        $this->authService->logout($accessToken);

        return response()->json([
            'success' => true,
            'message' => 'Logout successful.',
        ]);
    }
    /**
     * Check access token
     */
    // public function token(Request $request)
    // {
    //     /*
    //     |--------------------------------------------------------------------------
    //     | Access token
    //     |--------------------------------------------------------------------------
    //     */

    //     $accessToken = $request->cookie('access-token');
    //     $refreshToken = $request->cookie('refresh-token');

    //     if (!$accessToken) {
    //         $accessToken = $request->bearerToken();
    //     }

    //     if (!$accessToken) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Access token is required.',
    //         ], 401);
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | JWT payload
    //     |--------------------------------------------------------------------------
    //     */

    //     $payload = $this->authService->getTokenPayload(
    //         $accessToken
    //     );

    //     if (!$payload) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Invalid or expired access token.',
    //         ], 401);
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Authenticated user
    //     |--------------------------------------------------------------------------
    //     */

    //     $user = $request->user();

    //     if (!$user) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Unauthenticated.',
    //         ], 401);
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Token database record
    //     |--------------------------------------------------------------------------
    //     */

    //     $userToken = $request->attributes->get('userToken');

    //     if (!$userToken) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Token record not found.',
    //         ], 401);
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Expiration
    //     |--------------------------------------------------------------------------
    //     */

    //     $now = now()->timestamp;

    //     $issuedAt = isset($payload['iat'])
    //         ? (int) $payload['iat']
    //         : null;

    //     $expiresAt = isset($payload['exp'])
    //         ? (int) $payload['exp']
    //         : null;

    //     $remainingSeconds = $expiresAt !== null
    //         ? max(0, $expiresAt - $now)
    //         : null;

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Response
    //     |--------------------------------------------------------------------------
    //     */

    //     return response()->json([
    //         'success' => true,

    //         'message' => 'Token is valid.',

    //         'user' => [
    //             'id' => $user->user_id,
    //             'username' => $user->username,
    //             'email' => $user->email,
    //             'role' => $user->role?->role_name,
    //         ],

    //         'token' => [
    //             'type' => 'Bearer',

    //             'valid' => true,

    //             'algorithm' => $payload['alg'] ?? 'HS256',

    //             'issuer' => $payload['iss'] ?? null,

    //             'type_claim' => $payload['type'] ?? null,

    //             'jti' => $payload['jti'] ?? null,

    //             'subject' => $payload['sub'] ?? null,
    //             'access_token' => $accessToken ?? null,
    //             'refresh_token' => $refreshToken ?? null,

    //             'issued_at' => $issuedAt
    //                 ? date(
    //                     'Y-m-d H:i:s',
    //                     $issuedAt
    //                 )
    //                 : null,

    //             'expires_at' => $expiresAt
    //                 ? date(
    //                     'Y-m-d H:i:s',
    //                     $expiresAt
    //                 )
    //                 : null,

    //             'remaining_seconds' =>
    //                 $remainingSeconds,

    //             'remaining_minutes' =>
    //                 $remainingSeconds !== null
    //                     ? (int) ceil(
    //                         $remainingSeconds / 60
    //                     )
    //                     : null,
    //         ],
    //     ]);
    // }

    public function token(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Get validated authentication data from ApiAuth middleware
        |--------------------------------------------------------------------------
        */

        $payload = $request->attributes->get('jwt');

        $accessToken = $request->attributes->get(
            'accessToken'
        );

        $userToken = $request->attributes->get(
            'userToken'
        );

        $user = $request->user();

        if (
            ! $payload ||
            ! $accessToken ||
            ! $userToken ||
            ! $user
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | Get refresh token
        |--------------------------------------------------------------------------
        |
        | The raw refresh token is available from the cookie.
        | tblUserTokens stores only its SHA-256 hash.
        |
        */

        $refreshToken = $request->cookie(
            'refresh-token'
        );

        /*
        |--------------------------------------------------------------------------
        | Calculate expiration
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
                'refresh_token' => $refreshToken ?? null,
                'issued_at' => $issuedAt
                    ? date(
                        'Y-m-d H:i:s',
                        $issuedAt
                    )
                    : null,

                'expires_at' => $expiresAt
                    ? date(
                        'Y-m-d H:i:s',
                        $expiresAt
                    )
                    : null,

                'remaining_seconds' => $remainingSeconds,

                'remaining_minutes' => $remainingSeconds !== null
                        ? (int) ceil(
                            $remainingSeconds / 60
                        )
                        : null,
            ],
        ]);
    }
}
