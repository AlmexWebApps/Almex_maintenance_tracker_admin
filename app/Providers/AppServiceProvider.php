<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Calibration;
use App\Observers\CalibrationObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Calibration::observe(CalibrationObserver::class);
    }
}
