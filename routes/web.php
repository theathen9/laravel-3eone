<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;


use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Account\DashboardController as AccountDashboardController;


/*
|--------------------------------------------------------------------------
| Web Authentication
|--------------------------------------------------------------------------
|
| Do NOT use Laravel's guest middleware here if JWT cookies are
| your authentication system.
|
*/

Route::prefix('auth')
    ->name('auth.')
    ->middleware('guest')
    ->group(function () {

        Route::get('/signin', [
            WebAuthController::class,
            'show',
        ])->name('signin');

        Route::post('/signin', [
            WebAuthController::class,
            'login',
        ])->name('login');


        /*
        |--------------------------------------------------------------------------
        | Forgot password
        |--------------------------------------------------------------------------
        */

        Route::get('/forgot-password', [
            WebAuthController::class,
            'showForgotPassword',
        ])->name('forgot');

        Route::post('/forgot-password', [
            WebAuthController::class,
            'sendResetLink',
        ])->name('forgot.submit');


        /*
        |--------------------------------------------------------------------------
        | Reset password
        |--------------------------------------------------------------------------
        */

        Route::get('/reset-password/{token}', [
            WebAuthController::class,
            'showResetPassword',
        ])->name('reset');

        Route::post('/reset-password', [
            WebAuthController::class,
            'resetPassword',
        ])->name('reset.submit');
    });


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
|
| Use JWT authentication, NOT Laravel auth middleware.
|
*/

Route::post('/auth/logout', [
    WebAuthController::class,
    'logout',
])
    ->middleware('auth')
    ->name('auth.logout');


/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    $user = request()->user();

    if (!$user) {
        return redirect()->route('auth.signin');
    }

    $role = strtolower(
        trim($user->role?->role_name ?? '')
    );

    return match ($role) {

        'admin' =>
            redirect()->route('admin.dashboard'),

        'accountant', 'account' =>
            redirect()->route('account.dashboard'),

        default =>
            abort(403),
    };

})->middleware('auth')->name('home');


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:admin',
])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [
            AdminDashboardController::class,
            'index',
        ])->name('dashboard');
    });


/*
|--------------------------------------------------------------------------
| Account
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:accountant,account',
])
    ->prefix('account')
    ->name('account.')
    ->group(function () {

        Route::get('/dashboard', [
            AccountDashboardController::class,
            'index',
        ])->name('dashboard');
    });

    Route::get('/debug-auth', function () {
    return response()->json([
        'auth_check' => Auth::check(),
        'user' => Auth::user(),
        'session_id' => session()->getId(),
        'session' => session()->all(),
    ]);
});

Route::get('/test-session', function (Request $request) {
    $count = $request->session()->get('count', 0) + 1;

    $request->session()->put('count', $count);

    return response()->json([
        'count' => $count,
        'session_id' => $request->session()->getId(),
        'session' => $request->session()->all(),
    ]);
});