<?php
// ./routes/api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\ApiAuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Auth;


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
        ApiAuthController::class,
        'login',
    ])->name('api.v1.auth.login');

    Route::post('/auth/refresh', [
        ApiAuthController::class,
        'refresh',
    ])->name('api.v1.auth.refresh');


    /*
    |--------------------------------------------------------------------------
    | Authentication - JWT Protected
    |--------------------------------------------------------------------------
    */

    Route::middleware('api.auth')->group(function () {

        Route::get('/auth/token', [
            ApiAuthController::class,
            'token',
        ])->name('api.v1.auth.token');

        Route::post('/auth/logout', [
            ApiAuthController::class,
            'logout',
        ])->name('api.v1.auth.logout');


        /*
        |--------------------------------------------------------------------------
        | Users - JWT Protected
        |--------------------------------------------------------------------------
        */

 Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);

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

});
