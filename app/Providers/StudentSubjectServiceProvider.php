<?php

namespace App\Providers;

use App\Services\StudentSubjectService;
use Illuminate\Support\ServiceProvider;

class StudentSubjectServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(StudentSubjectService::class, function ($app) {
            return new StudentSubjectService();
        });
    }
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
