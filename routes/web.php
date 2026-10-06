<?php

use App\Http\Controllers\Account\DashboardController as AccountDashboardController;
// use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Registration\StudentRegistrationController;
use App\Http\Controllers\Admin\Registration\EmployeeRegistrationController;

use App\Http\Controllers\Auth\WebAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
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

        Route::get('/forgot-password', [
            WebAuthController::class,
            'showForgotPassword',
        ])->name('forgot');

        Route::post('/forgot-password', [
            WebAuthController::class,
            'sendResetLink',
        ])->name('forgot.submit');

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
*/

Route::post('/auth/signout', [
    WebAuthController::class,
    'logout',
])->name('auth.signout');

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function (Request $request) {

    $user = $request->user();

    $role = strtolower(
        trim($user->role?->role_name ?? '')
    );

    return match ($role) {

        'admin' => redirect()->route('admin.dashboard'),

        'accountant', 'account' => redirect()->route('account.dashboard'),

        default => abort(403),
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
            AdminController::class,
            'dashboard',
        ])->name('dashboard');

        Route::get('/registrations/students', [
            StudentRegistrationController::class,
            'index',
        ])->name('registrations.students.index');

        Route::get('/registrations/employees', [
            EmployeeRegistrationController::class,
            'index',
        ])->name('registrations.employees.index');

        Route::post('/registrations/employees', [
            EmployeeRegistrationController::class,
            'store',
        ])->name('registrations.employees.store');
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

/*
|--------------------------------------------------------------------------
| Debug
|--------------------------------------------------------------------------
*/

Route::get('/debug-auth', function (Request $request) {
    return response()->json([
        'auth_check' => $request->user() !== null,
        'user' => $request->user(),
        'session_id' => $request->session()->getId(),
        'session' => $request->session()->all(),
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
