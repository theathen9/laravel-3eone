<?php

namespace App\Providers;

use App\Models\Employee;
use App\Models\Student;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Pao\Laravel\ServiceProvider::class)) {
            $this->app->register(\Laravel\Pao\Laravel\ServiceProvider::class);
        }

        Relation::enforceMorphMap([
            'Employee' => Employee::class,
            'Student' => Student::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
