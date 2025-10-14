<?php

namespace App\Providers;

use App\Models\Calibration;
use App\Observers\CalibrationObserver;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Orchid\Support\Facades\Dashboard;

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
        App::setLocale(env('APP_LOCALE', 'es_MX'));
    }
}
