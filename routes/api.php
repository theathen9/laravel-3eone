<?php

// ./routes/api.php
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\StudentRegistrationController;
use App\Http\Controllers\Api\V1\EmployeeController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\ClassController;
use App\Http\Controllers\Api\V1\AddressController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API v1
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication - Public
    |--------------------------------------------------------------------------
    */

    Route::post('/auth/login', [
        AuthController::class,
        'login',
    ])->name('api.v1.auth.login');

    Route::post('/auth/logout', [
        AuthController::class,
        'logout',
    ])->name('api.v1.auth.logout');

    Route::post('/auth/refresh', [
        AuthController::class,
        'refresh',
    ])->name('api.v1.auth.refresh');

    /*
    |--------------------------------------------------------------------------
    | Authentication - JWT Protected
    |--------------------------------------------------------------------------
    */

    Route::middleware('api.auth')->group(function () {

        Route::get('/auth/token', [
            AuthController::class,
            'token',
        ])->name('api.v1.auth.token');

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        Route::get('/users', [
            UserController::class,
            'index',
        ]);

        Route::get('/users/{id}', [
            UserController::class,
            'show',
        ]);
        /* |-------------------------------------------------------------------------- 
        | Student Registration 
        |-------------------------------------------------------------------------- */
        Route::get('/employees', [EmployeeController::class, 'index']);
        Route::post('/employees', [EmployeeController::class, 'process']);
        Route::get('/employees/{id}', [EmployeeController::class, 'show']);
        Route::put('/employees/{id}', [EmployeeController::class, 'update']);
        Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);


        /* |-------------------------------------------------------------------------- 
        | Student Registration 
        |-------------------------------------------------------------------------- */
        Route::post('/students/register-process', [StudentRegistrationController::class, 'process']);
        /* |-------------------------------------------------------------------------- 
        | Available Classes 
        |-------------------------------------------------------------------------- */
        Route::get('/classes/available', [ClassController::class, 'available']); /* 
        |-------------------------------------------------------------------------- 
        | Invoice 
        |-------------------------------------------------------------------------- */
        Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'pdf']);
        Route::get(
            '/invoices/{invoice}/preview',
            [InvoiceController::class, 'previewInvoice']
        )->name('api.v1.invoices.preview');
    });

    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    */

    Route::get('/debug-ip', function (Request $request) {
        return response()->json([
            'ip' => $request->ip(),
            'ips' => $request->ips(),
            'user_agent' => $request->userAgent(),
            'headers' => [
                'x_forwarded_for' => $request->header('X-Forwarded-For'),
                'x_real_ip' => $request->header('X-Real-IP'),
            ],
        ]);
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

    /* |-------------------------------------------------------------------------- | Address |-------------------------------------------------------------------------- */
    Route::get('/address', [AddressController::class, 'index',]);
});
