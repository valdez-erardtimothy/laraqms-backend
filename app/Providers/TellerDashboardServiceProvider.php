<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TellerDashboard;

class TellerDashboardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('teller_dashboard', function ($app) {
            return new TellerDashboard();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
