<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication
use App\Http\Controllers\Auth\WebAuthController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AccessControlController as AdminAccessControlController;
use App\Http\Controllers\Admin\PeopleController as AdminPeopleController;
use App\Http\Controllers\Admin\AcademicController as AdminAcademicController;
use App\Http\Controllers\Admin\InstituteController as AdminInstituteController;
use App\Http\Controllers\Admin\Registration\StudentRegistrationController as AdminStudentRegistrationController;
use App\Http\Controllers\Admin\Registration\EmployeeRegistrationController as AdminEmployeeRegistrationController;

// Account Controllers
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\PeopleController as AccountPeopleController;
use App\Http\Controllers\Account\AcademicController as AccountAcademicController;
use App\Http\Controllers\Account\InstituteController as AccountInstituteController;
use App\Http\Controllers\Account\Registration\StudentRegistrationController as AccountStudentRegistrationController;
use App\Http\Controllers\Account\Registration\EmployeeRegistrationController as AccountEmployeeRegistrationController;


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::prefix('auth')
    ->name('auth.')
    ->middleware('guest')
    ->group(function () {

        Route::get('/signin', [WebAuthController::class, 'show'])
            ->name('signin');

        Route::post('/signin', [WebAuthController::class, 'login'])
            ->name('login');

        Route::get('/forgot-password', [WebAuthController::class, 'showForgotPassword'])
            ->name('forgot');

        Route::post('/forgot-password', [WebAuthController::class, 'sendResetLink'])
            ->name('forgot.submit');

        Route::get('/reset-password/{token}', [WebAuthController::class, 'showResetPassword'])
            ->name('reset');

        Route::post('/reset-password', [WebAuthController::class, 'resetPassword'])
            ->name('reset.submit');
    });


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/auth/signout', [WebAuthController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.signout');


/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function (Request $request) {

    $user = $request->user();

    $role = strtolower(trim($user->role?->role_name ?? ''));

    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),

        'accountant', 'account' => redirect()->route('account.dashboard'),

        default => abort(403),
    };
})->middleware('auth')->name('home');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Institute
        |--------------------------------------------------------------------------
        */

        Route::get('/institute/institute', function () {
            return redirect()->route('admin.institute.institute');
        })->name('institute.index');

        Route::get('/institute/branches', [
            AdminInstituteController::class,
            'branches',
        ])->name('institute.branches');

        Route::get('/institute/rooms', [
            AdminInstituteController::class,
            'rooms',
        ])->name('institute.rooms');

        Route::get('/institute/positions', [
            AdminInstituteController::class,
            'positions',
        ])->name('institute.positions');


        /*
        |--------------------------------------------------------------------------
        | Academic
        |--------------------------------------------------------------------------
        */

        Route::get('/academic/academic-years', [
            AdminAcademicController::class,
            'academicYears',
        ])->name('academic.academic-years');

        Route::get('/academic/academic-classes', [
            AdminAcademicController::class,
            'academicClasses',
        ])->name('academic.academic-classes');

        Route::get('/academic/academic-subjects', [
            AdminAcademicController::class,
            'academicSubjects',
        ])->name('academic.academic-subjects');

        Route::get('/academic/academic-courses', [
            AdminAcademicController::class,
            'academicCourses',
        ])->name('academic.academic-courses');


        /*
        |--------------------------------------------------------------------------
        | People
        |--------------------------------------------------------------------------
        */

        Route::get('/people/employees', [
            AdminPeopleController::class,
            'employees',
        ])->name('people.employees');

        Route::get('/people/teachers', [
            AdminPeopleController::class,
            'teachers',
        ])->name('people.teachers');

        Route::get('/people/students', [
            AdminPeopleController::class,
            'students',
        ])->name('people.students');

        Route::get('/people/students/{student}', [
            AdminPeopleController::class,
            'showStudent',
        ])->whereNumber('student')->name('people.students.show');

        Route::get('/users', [
            AdminAccessControlController::class,
            'users',
        ])->name('users.index');

        Route::get('/users/roles', [
            AdminAccessControlController::class,
            'roles',
        ])->name('roles.index');

        Route::get('/users/permissions', [
            AdminAccessControlController::class,
            'permissions',
        ])->name('permissions.index');


        /*
        |--------------------------------------------------------------------------
        | Registrations
        |--------------------------------------------------------------------------
        */

        Route::get('/registrations/students', [
            AdminStudentRegistrationController::class,
            'index',
        ])->name('registrations.students.index');

        Route::get('/registrations/employees', [
            AdminEmployeeRegistrationController::class,
            'index',
        ])->name('registrations.employees.index');
    });


/*
|--------------------------------------------------------------------------
| Account Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:account,accountant'])
    ->prefix('account')
    ->name('account.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [
            AccountController::class,
            'dashboard',
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Institute
        |--------------------------------------------------------------------------
        */

        Route::get('/institute/institute', function () {
            return redirect()->route('account.institute.institute');
        })->name('institute.index');

        Route::get('/institute/branches', [
            AccountInstituteController::class,
            'branches',
        ])->name('institute.branches');

        Route::get('/institute/rooms', [
            AccountInstituteController::class,
            'rooms',
        ])->name('institute.rooms');

        Route::get('/institute/positions', [
            AccountInstituteController::class,
            'positions',
        ])->name('institute.positions');


        /*
        |--------------------------------------------------------------------------
        | Academic
        |--------------------------------------------------------------------------
        */

        Route::get('/academic/academic-years', [
            AccountAcademicController::class,
            'academicYears',
        ])->name('academic.academic-years');

        Route::get('/academic/academic-classes', [
            AccountAcademicController::class,
            'academicClasses',
        ])->name('academic.academic-classes');

        Route::get('/academic/academic-subjects', [
            AccountAcademicController::class,
            'academicSubjects',
        ])->name('academic.academic-subjects');

        Route::get('/academic/academic-courses', [
            AccountAcademicController::class,
            'academicCourses',
        ])->name('academic.academic-courses');


        /*
        |--------------------------------------------------------------------------
        | People
        |--------------------------------------------------------------------------
        */

        Route::get('/people/employees', [
            AccountPeopleController::class,
            'employees',
        ])->name('people.employees');

        Route::get('/people/teachers', [
            AccountPeopleController::class,
            'teachers',
        ])->name('people.teachers');

        Route::get('/people/students', [
            AccountPeopleController::class,
            'students',
        ])->name('people.students');


        /*
        |--------------------------------------------------------------------------
        | Registrations
        |--------------------------------------------------------------------------
        */

        Route::get('/registrations/students', [
            AccountStudentRegistrationController::class,
            'index',
        ])->name('registrations.students.index');

        Route::get('/registrations/employees', [
            AccountEmployeeRegistrationController::class,
            'index',
        ])->name('registrations.employees.index');
    });


/*
|--------------------------------------------------------------------------
| Debug Routes
|--------------------------------------------------------------------------
*/

// Remove these routes in production.

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
