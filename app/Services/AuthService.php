<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Services\JwtService;
use RuntimeException;

class AuthService
{
    public function __construct(
        private JwtService $jwtService
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Find + Verify User
    |--------------------------------------------------------------------------
    */

    public function authenticate(
        string $login,
        string $password
    ): ?User {
        $login = trim($login);

        $user = User::query()
            ->with('role')
            ->where(function ($query) use ($login) {

                $query->where('username', $login)
                    ->orWhere('email', $login);

                if (filter_var($login, FILTER_VALIDATE_INT) !== false) {
                    $query->orWhere(
                        'user_id',
                        (int) $login
                    );
                }
            })
            ->first();

        if (!$user) {
            return null;
        }

        // Disabled user
        if (!$user->status) {
            return null;
        }

        // Password verification
        if (!Hash::check($password, $user->password)) {
            return null;
        }

        // Update last login
        $user->update([
            'last_login' => now(),
        ]);

        return $user;
    }


    /*
    |--------------------------------------------------------------------------
    | Web Login
    |--------------------------------------------------------------------------
    */

    public function loginWeb(
        Request $request,
        User $user
    ): void {
        Auth::login($user);

        // $token = refreshTokens();

        $request->session()->regenerate();

        $request->session()->put([
            'loggedin' => true,
            'user_id' => $user->user_id,
            'role' => strtolower(
                trim($user->role?->role_name ?? '')
            ),
            'reference_id' => $user->reference_id,
            'reference_type' => $user->reference_type,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Device ID
    |--------------------------------------------------------------------------
    */

    private function getDeviceId(
        Request $request
    ): string {

        $deviceId = $request->cookie('device_id');

        if (!$deviceId) {
            $deviceId = (string) Str::uuid();
        }
        
        return $deviceId;
    }


    /*
    |--------------------------------------------------------------------------
    | Device Information
    |--------------------------------------------------------------------------
    */

    private function getDeviceInfo(
        Request $request
    ): string {

        $userAgent = strtolower(
            $request->userAgent() ?? ''
        );

        if (str_contains($userAgent, 'android')) {
            return 'Android';
        }

        if (
            str_contains($userAgent, 'iphone') ||
            str_contains($userAgent, 'ipad')
        ) {
            return 'iOS';
        }

        if (str_contains($userAgent, 'windows')) {

            if (str_contains($userAgent, 'edg')) {
                return 'Windows / Edge';
            }

            if (str_contains($userAgent, 'chrome')) {
                return 'Windows / Chrome';
            }

            if (str_contains($userAgent, 'firefox')) {
                return 'Windows / Firefox';
            }

            return 'Windows';
        }

        if (str_contains($userAgent, 'macintosh')) {
            return 'macOS';
        }

        if (str_contains($userAgent, 'linux')) {
            return 'Linux';
        }

        return 'Unknown';
    }


    /*
    |--------------------------------------------------------------------------
    | Create / Replace JWT + Refresh Token
    |--------------------------------------------------------------------------
    */


    public function createTokens(
    Request $request,
    User $user,
    ?string $deviceId = null
    ): array {
    $deviceId ??= $this->getDeviceId($request);

    /*
    |--------------------------------------------------------------------------
    | Create JWTs
    |--------------------------------------------------------------------------
    */

    $accessToken = $this->jwtService->createAccessToken($user);
    $refreshToken = $this->jwtService->createRefreshToken($user);

    /*
    |--------------------------------------------------------------------------
    | Access JWT payload
    |--------------------------------------------------------------------------
    */

    $accessPayload = $this->jwtService->payload($accessToken);

    if (
        !$accessPayload ||
        empty($accessPayload['jti']) ||
        empty($accessPayload['exp'])
    ) {
        throw new RuntimeException(
            'Unable to create valid access JWT.'
        );
    }

    $jti = (string) $accessPayload['jti'];

    /*
    |--------------------------------------------------------------------------
    | Hash refresh JWT before storing
    |--------------------------------------------------------------------------
    */

    $refreshTokenHash = hash(
        'sha256',
        $refreshToken
    );
    $accessTokenHash = hash(
        'sha256',
        $accessToken
    );

    /*
    |--------------------------------------------------------------------------
    | Expiration
    |--------------------------------------------------------------------------
    |
    | Use the actual JWT exp claim for the access token.
    | Decode the refresh token to obtain its expiration.
    |
    */

    $refreshPayload = $this->jwtService->decodeRefreshToken(
        $refreshToken
    );


    if (
        !$refreshPayload ||
        empty($refreshPayload['exp'])
    ) {
        throw new RuntimeException(
            'Unable to create valid refresh JWT.'
        );
    }


    $accessExpiry = 
        (int) $accessPayload['exp']
    ;

    $refreshExpiry = 
        (int) $refreshPayload['exp']
    ;

    /*
    |--------------------------------------------------------------------------
    | Token data
    |--------------------------------------------------------------------------
    */

    $tokenData = [
        'jti' => $jti,

        'access_token' => $accessTokenHash,
        'access_expiry' => $accessExpiry,

        'refresh_token' => $refreshTokenHash,
        'refresh_expiry' => $refreshExpiry,

        'device_info' => $this->getDeviceInfo($request),

        'user_agent' => $request->userAgent(),

        'ip_address' => $request->ip(),

        'revoked_at' => null,
    ];

    /*
    |--------------------------------------------------------------------------
    | Replace existing active session for device
    |--------------------------------------------------------------------------
    */

    $deviceInfo = $this->getDeviceInfo($request);
    $userAgent = $request->userAgent();

    $existingToken = UserToken::query()
        ->where('user_id', $user->user_id)
        ->where('user_agent', $userAgent)
        ->where('device_id', $deviceId)
        // ->whereNull('revoked_at')
        ->first();

    if ($existingToken) {
        $existingToken->update($tokenData);
    } else {
        UserToken::create([
            'user_id' => $user->user_id,
            'device_id' => $deviceId,
            ...$tokenData,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Return tokens
    |--------------------------------------------------------------------------
    */

    return [
        'access_token' => $accessToken,
        'refresh_token' => $refreshToken,
        'device_id' => $deviceId,
        'token_type' => 'Bearer',

        'expires_in' => max(
            0,
            (int) $accessPayload['exp']
            - now()->timestamp
        ),

        'refresh_expires_in' => max(
            0,
            (int) $refreshPayload['exp']
            - now()->timestamp
        ),
    ];
}




    /*
    |--------------------------------------------------------------------------
    | Get JWT Payload
    |--------------------------------------------------------------------------
    */

    public function getTokenPayload(
        string $accessToken
    ): ?array {

        return $this->jwtService->payload(
            $accessToken
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Refresh JWT + Refresh Token
    |--------------------------------------------------------------------------
    */

    public function refreshTokens(
        Request $request,
        string $refreshToken
    ): ?array {

        $refreshToken = trim(
            $refreshToken
        );

        $refreshTokenHash = hash(
            'sha256',
            $refreshToken
        );

        if ($refreshToken === '') {
            return null;
        }
        if ($refreshTokenHash === '') {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Find active refresh token
        |--------------------------------------------------------------------------
        */

        $token = UserToken::query()
            ->with('user.role')
            ->where(
                'refresh_token',
                $refreshTokenHash
            )
            ->where(
                'refresh_expiry',
                '>',
                now()
            )
            ->first();


        if (!$token) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Load user
        |--------------------------------------------------------------------------
        */

        $user = $token->user;

        if (
            !$user ||
            !$user->status
        ) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Preserve device
        |--------------------------------------------------------------------------
        */

        $deviceId = $token->device_id;


        /*
        |--------------------------------------------------------------------------
        | Rotate refresh token atomically
        |--------------------------------------------------------------------------
        */

        return DB::transaction(
            function () use (
                $request,
                $token,
                $user,
                $deviceId
            ) {

                /*
                |--------------------------------------------------------------------------
                | Lock token row
                |--------------------------------------------------------------------------
                |
                | Prevent two simultaneous refresh requests from
                | using the same refresh token.
                |
                */

               $lockedToken = UserToken::query()
    ->where('token_id', $token->token_id)
    ->lockForUpdate()
    ->first();

if (!$lockedToken) {
    return null;
}

if ($lockedToken->revoked_at !== null) {
    return null;
}

if (
    !hash_equals(
        (string) $lockedToken->refresh_token,
        $refreshTokenHash
    )
) {
    return null;
}

if (
    !$lockedToken->refresh_expiry ||
    now()->greaterThanOrEqualTo($lockedToken->refresh_expiry)
) {
    return null;
}



                /*
                |--------------------------------------------------------------------------
                | Revoke old token pair
                |--------------------------------------------------------------------------
                */

                $lockedToken->update([
                    'revoked_at' => now(),
                ]);


                /*
                |--------------------------------------------------------------------------
                | Create new token pair
                |--------------------------------------------------------------------------
                */

                return $this->createTokens(
                    $request,
                    $user,
                    $deviceId
                );
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | API Logout / Revoke JWT
    |--------------------------------------------------------------------------
    */

    // public function logout(
    //     string $accessToken
    // ): void {

    //     $accessToken = trim(
    //         $accessToken
    //     );

    //     if ($accessToken === '') {
    //         return;
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | Decode JWT
    //     |--------------------------------------------------------------------------
    //     */

    //     $payload = $this->jwtService->payload(
    //         $accessToken
    //     );


    //     if (!$payload) {
    //         return;
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | Get JTI
    //     |--------------------------------------------------------------------------
    //     */

    //     $jti = $payload['jti'] ?? null;

    //     if (!$jti) {
    //         return;
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | Revoke token session
    //     |--------------------------------------------------------------------------
    //     */

    //     UserToken::query()
    //         ->where('jti', $jti)
    //         ->whereNull('revoked_at')
    //         ->update([
    //             'revoked_at' => now(),
    //         ]);
    // }

    public function logout(
    string $accessToken
): void {

    $accessToken = trim($accessToken);

    if ($accessToken === '') {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Decode JWT
    |--------------------------------------------------------------------------
    */

    $payload = $this->jwtService->payload(
        $accessToken
    );

    /*
    |--------------------------------------------------------------------------
    | DEBUG TIMEZONE / JWT
    |--------------------------------------------------------------------------
    */

    dd([
        'php_time' => time(),

        'php_utc' => gmdate(
            'Y-m-d H:i:s.u',
            time()
        ),

        'php_local' => now()->format(
            'Y-m-d H:i:s.uP'
        ),

        'app_timezone' => config('app.timezone'),

        'iat' => $payload['iat'] ?? null,

        'iat_utc' => isset($payload['iat'])
            ? gmdate(
                'Y-m-d H:i:s.u',
                (int) $payload['iat']
            )
            : null,

        'exp' => $payload['exp'] ?? null,

        'exp_utc' => isset($payload['exp'])
            ? gmdate(
                'Y-m-d H:i:s.u',
                (int) $payload['exp']
            )
            : null,

        'ttl' => isset(
            $payload['iat'],
            $payload['exp']
        )
            ? (
                (int) $payload['exp']
                - (int) $payload['iat']
            )
            : null,
    ]);

    /*
    |--------------------------------------------------------------------------
    | Normal logout continues after debugging
    |--------------------------------------------------------------------------
    */

    if (!$payload) {
        return;
    }

    $jti = $payload['jti'] ?? null;

    if (!$jti) {
        return;
    }

    UserToken::query()
        ->where('jti', $jti)
        ->whereNull('revoked_at')
        ->update([
            'revoked_at' => now(),
        ]);
}



    /*
    |--------------------------------------------------------------------------
    | Web Logout
    |--------------------------------------------------------------------------
    */

    public function logoutWeb(
        Request $request
    ): void {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}