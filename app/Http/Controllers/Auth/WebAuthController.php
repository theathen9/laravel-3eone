<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserToken;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class WebAuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * Show login page.
     */
    public function show()
    {
        return view('auth.signin');
    }

    /**
     * Process web login.
     *
     * Creates:
     * - Laravel web session
     * - API access token
     * - API refresh token
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

        // Validate credentials using the shared AuthService.
        $user = $this->authService->authenticate(
            $validated['username'],
            $validated['password']
        );

        if (! $user) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors([
                    'username' => 'Invalid username or password.',
                ]);
        }

        // Validate role before creating the session or tokens.
        $role = strtolower(trim(
            $user->role?->role_name ?? ''
        ));

        $dashboard = match ($role) {
            'admin' => 'admin.dashboard',
            'account' => 'account.dashboard',
            'teacher' => 'teacher.dashboard',
            'student' => 'student.dashboard',
            default => null,
        };

        if (! $dashboard) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors([
                    'username' => 'Your account does not have a valid role.',
                ]);
        }

        // Create API JWT tokens.
        $tokens = $this->authService->createTokens(
            $request,
            $user
        );

        // Establish Laravel web session.
        $this->authService->loginWeb(
            $request,
            $user
        );

        // Token cookie expiration.
        $accessTokenTtl = max(
            1,
            (int) ceil($tokens['expires_in'])
        );

        $refreshTokenTtl = max(
            1,
            (int) ceil($tokens['refresh_expires_in'])
        );

        $secure = app()->environment('production');

        // Frontend display information only.
        // Never use this cookie for authorization.
        $cUser = [
            'id' => $user->user_id,
            'username' => $user->username,
            'role' => $role,
        ];

        return redirect()
            ->route($dashboard)

            // Access token.
            ->withCookie(cookie(
                'access-token',
                $tokens['access_token'],
                $accessTokenTtl,
                '/',
                null,
                $secure,
                true,
                false,
                'Lax'
            ))

            // Refresh token.
            ->withCookie(cookie(
                'refresh-token',
                $tokens['refresh_token'],
                $refreshTokenTtl,
                '/',
                null,
                $secure,
                true,
                false,
                'Lax'
            ))

            // Device identifier.
            ->withCookie(cookie(
                'device_id',
                $tokens['device_id'],
                60 * 24 * 30,
                '/',
                null,
                $secure,
                true,
                false,
                'Lax'
            ))

            // Optional frontend display cookie.
            ->withCookie(cookie(
                'c_user',
                json_encode($cUser),
                $refreshTokenTtl,
                '/',
                null,
                $secure,
                false,
                false,
                'Lax'
            ));
    }

    /**
     * Show forgot-password page.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Generate password reset link.
     *
     * Production email delivery must be configured separately.
     */
    public function sendResetLink(Request $request)
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'max:150',
            ],
        ]);

        $user = User::where(
            'email',
            $validated['email']
        )->first();

        // Do not reveal whether an email exists.
        if (! $user) {
            return back()->with(
                'status',
                'If that email exists, a password reset link will be sent.'
            );
        }

        $token = Str::random(64);

        $user->update([
            'reset_token' => hash('sha256', $token),
            'reset_expiry' => now()->addMinutes(30),
        ]);

        $response = back()->with(
            'status',
            'If that email exists, a password reset link will be sent.'
        );

        // Development convenience only.
        // Configure email delivery before enabling password reset
        // for production users.
        if (app()->environment('local')) {
            $resetUrl = route('auth.reset', [
                'token' => $token,
            ]);

            $response->with('reset_url', $resetUrl);
        }

        return $response;
    }

    /**
     * Show reset-password page.
     */
    public function showResetPassword(string $token)
    {
        $user = User::where(
            'reset_token',
            hash('sha256', $token)
        )
            ->where('reset_expiry', '>', now())
            ->first();

        if (! $user) {
            return redirect()
                ->route('auth.forgot')
                ->withErrors([
                    'email' => 'This password reset link is invalid or expired.',
                ]);
        }

        return view('auth.reset-password', [
            'token' => $token,
        ]);
    }

    /**
     * Reset user password.
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => [
                'required',
                'string',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $user = User::where(
            'reset_token',
            hash('sha256', $validated['token'])
        )
            ->where('reset_expiry', '>', now())
            ->first();

        if (! $user) {
            return redirect()
                ->route('auth.forgot')
                ->withErrors([
                    'email' => 'This password reset link is invalid or expired.',
                ]);
        }

        DB::transaction(function () use ($user, $validated) {

            // Update password and invalidate reset token.
            $user->update([
                'password' => Hash::make($validated['password']),
                'reset_token' => null,
                'reset_expiry' => null,
            ]);

            // Revoke all API tokens belonging to this user.
            UserToken::query()
                ->where('user_id', $user->user_id)
                ->whereNull('revoked_at')
                ->update([
                    'revoked_at' => now(),
                ]);
        });

        return redirect()
            ->route('auth.signin')
            ->with(
                'status',
                'Your password has been reset successfully. Please sign in again.'
            );
    }

    /**
     * Logout from Laravel session and revoke API refresh token.
     */
    public function logout(Request $request)
    {
        $refreshToken = $request->cookie('refresh-token');

        if ($refreshToken) {
            // AuthService::logout must decode this using
            // JwtService::decodeRefreshToken().
            $this->authService->logout($refreshToken);
        }

        // End Laravel session.
        $this->authService->logoutWeb($request);

        $secure = app()->environment('production');

        return redirect()
            ->route('auth.signin')
            ->withCookie(cookie()->forget(
                'access-token',
                '/',
                null
            ))
            ->withCookie(cookie()->forget(
                'refresh-token',
                '/',
                null
            ))
            ->withCookie(cookie()->forget(
                'device_id',
                '/',
                null
            ))
            ->withCookie(cookie()->forget(
                'c_user',
                '/',
                null
            ));
    }
}
