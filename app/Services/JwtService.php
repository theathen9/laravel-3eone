<?php

namespace App\Services;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Str;
use RuntimeException;
use InvalidArgumentException;
use Throwable;

class JwtService
{
    private string $secret;

    private string $algorithm;

    private string $issuer;

    private int $accessLifetime;

    private int $refreshLifetime;

    public function __construct()
    {
        $this->secret = (string) config('jwt.secret');
        $this->algorithm = (string) config('jwt.algorithm');
        $this->issuer = (string) config('jwt.issuer');
        $this->accessLifetime = (int) config(
            'jwt.access_ttl'
        );
        $this->refreshLifetime = (int) config(
            'jwt.refresh_ttl'
        );

        if ($this->secret === '') {
            throw new RuntimeException(
                'JWT_SECRET is not configured.'
            );
        }

        if ($this->algorithm === '') {
            throw new RuntimeException(
                'JWT_ALGORITHM is not configured.'
            );
        }

        if ($this->issuer === '') {
            throw new RuntimeException(
                'JWT_ISSUER is not configured.'
            );
        }

        if ($this->accessLifetime <= 0) {
            throw new RuntimeException(
                'JWT_ACCESS_TTL must be greater than zero.'
            );
        }
        if ($this->refreshLifetime <= 0) {
            throw new RuntimeException(
                'JWT_REFRESH_TTL must be greater than zero.'
            );
        }

        /*
         * If this application is intentionally HS256-only,
         * enforce that rather than allowing configuration
         * to accidentally switch algorithms.
         */
        if ($this->algorithm !== 'HS256') {
            throw new RuntimeException(
                'Only HS256 is allowed.'
            );
        }
    }

    /**
     * Create token.
     */
    public function createToken(User $user, string $type = 'access'): string
    {
        $now = now()->timestamp;

        $lifetime = match ($type) {
            'access' => $this->accessLifetime,
            'refresh' => $this->refreshLifetime,
            default => throw new InvalidArgumentException("Invalid token type: {$type}"),
        };

        $payload = [
            'iss' => $this->issuer,
            'sub' => (string) $user->user_id,
            'jti' => (string) Str::uuid(),
            'iat' => $now,
            'nbf' => $now,
            'exp' => $now + $lifetime,
            'type' => $type,
        ];

        return JWT::encode(
            $payload,
            $this->secret,
            $this->algorithm
        );
    }

    public function createAccessToken(User $user): string
    {
        return $this->createToken($user, 'access');
    }

    public function createRefreshToken(User $user): string
    {
        return $this->createToken($user, 'refresh');
    }

    /**
     * Decode and validate access JWT.
     */
    private function decodeToken(
        string $token,
        string $expectedType
    ): ?array {
        $token = trim($token);

        if ($token === '') {
            return null;
        }

        try {
            $payload = JWT::decode(
                $token,
                new Key(
                    $this->secret,
                    $this->algorithm
                )
            );

            $data = (array) $payload;

            /*
            |--------------------------------------------------------------------------
            | Issuer
            |--------------------------------------------------------------------------
            */

            if (
                ! isset($data['iss']) ||
                ! is_string($data['iss']) ||
                ! hash_equals(
                    $this->issuer,
                    $data['iss']
                )
            ) {
                return null;
            }

            /*
            |--------------------------------------------------------------------------
            | Token type
            |--------------------------------------------------------------------------
            */

            if (
                ($data['type'] ?? null)
                !== $expectedType
            ) {
                return null;
            }

            /*
            |--------------------------------------------------------------------------
            | Subject
            |--------------------------------------------------------------------------
            */

            if (
                ! isset($data['sub']) ||
                ! is_string($data['sub']) ||
                $data['sub'] === ''
            ) {
                return null;
            }

            /*
            |--------------------------------------------------------------------------
            | JTI
            |--------------------------------------------------------------------------
            */

            if (
                ! isset($data['jti']) ||
                ! is_string($data['jti']) ||
                ! Str::isUuid($data['jti'])
            ) {
                return null;
            }

            /*
            |--------------------------------------------------------------------------
            | Standard claims
            |--------------------------------------------------------------------------
            */

            foreach (
                [
                    'iat',
                    'nbf',
                    'exp',
                ] as $claim
            ) {
                if (
                    ! isset($data[$claim]) ||
                    ! is_numeric($data[$claim])
                ) {
                    return null;
                }
            }

            return $data;
        } catch (Throwable) {
            return null;
        }
    }

    public function decode(string $token): ?array
    {
        return $this->decodeToken(
            $token,
            'access'
        );
    }

    public function decodeRefreshToken(
        string $token
    ): ?array {
        return $this->decodeToken(
            $token,
            'refresh'
        );
    }

    public function validate(string $token): bool
    {
        return $this->decode($token) !== null;
    }

    public function payload(string $token): ?array
    {
        return $this->decode($token);
    }

    public function remainingSeconds(
        string $token
    ): ?int {
        $payload = $this->decode($token);

        if (
            ! $payload ||
            ! isset($payload['exp'])
        ) {
            return null;
        }

        return max(
            0,
            (int) $payload['exp']
                - now()->timestamp
        );
    }
}
