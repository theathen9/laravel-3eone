<?php

// ./routes/api.php
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\StudentRegistrationController;
use App\Http\Controllers\Api\V1\EmployeeController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\ClassController;
use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\BranchController;
use App\Http\Controllers\Api\V1\RoomController;
use App\Http\Controllers\Api\V1\PositionController;
use App\Http\Controllers\Api\V1\StudentController;

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

        Route::get('/branches', [BranchController::class, 'index'])
            ->name('api.v1.branches.index');
        Route::post('/branches', [BranchController::class, 'process'])
            ->name('api.v1.branches.store');
        Route::get('/branches/{id}', [BranchController::class, 'show'])
            ->name('api.v1.branches.show');
        Route::put('/branches/{id}', [BranchController::class, 'update']);
        Route::patch('/branches/{id}', [BranchController::class, 'update'])
            ->name('api.v1.branches.update');
        Route::delete('/branches/{id}', [BranchController::class, 'destroy']);

        Route::get('/rooms', [RoomController::class, 'index'])
            ->name('api.v1.rooms.index');
        Route::post('/rooms', [RoomController::class, 'process'])
            ->name('api.v1.rooms.store');
        Route::get('/rooms/{id}', [RoomController::class, 'show'])
            ->name('api.v1.rooms.show');
        Route::put('/rooms/{id}', [RoomController::class, 'update']);
        Route::patch('/rooms/{id}', [RoomController::class, 'update'])
            ->name('api.v1.rooms.update');
        Route::delete('/rooms/{id}', [RoomController::class, 'destroy'])
            ->name('api.v1.rooms.destroy');

        Route::get('/positions', [PositionController::class, 'index'])
            ->name('api.v1.positions.index');
        Route::post('/positions', [PositionController::class, 'process'])
            ->name('api.v1.positions.store');
        Route::get('/positions/{id}', [PositionController::class, 'show'])
            ->name('api.v1.positions.show');
        Route::put('/positions/{id}', [PositionController::class, 'update']);
        Route::patch('/positions/{id}', [PositionController::class, 'update'])
            ->name('api.v1.positions.update');
        Route::delete('/positions/{id}', [PositionController::class, 'destroy'])
            ->name('api.v1.positions.destroy');

        /* |-------------------------------------------------------------------------- 
        | Student Registration 
        |-------------------------------------------------------------------------- */
        Route::get('/employees', [EmployeeController::class, 'index'])
            ->name('api.v1.employees.index');
        Route::post('/employees', [EmployeeController::class, 'process'])
            ->name('api.v1.employees.store');
        Route::get('/employees/{id}', [EmployeeController::class, 'show'])
            ->name('api.v1.employees.show');
        Route::put('/employees/{id}', [EmployeeController::class, 'update']);
        Route::patch('/employees/{id}', [EmployeeController::class, 'update'])
            ->name('api.v1.employees.update');
        Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])
            ->name('api.v1.employees.destroy');

        Route::get('/students', [StudentController::class, 'index'])
            ->name('api.v1.students.index');
        Route::get('/students/{id}', [StudentController::class, 'show'])
            ->name('api.v1.students.show');
        Route::patch('/students/{id}', [StudentController::class, 'update'])
            ->name('api.v1.students.update');
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])
            ->name('api.v1.students.destroy');


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
