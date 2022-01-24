<?php

namespace App\Providers;

use App\Services\CustomerQueue;
use Illuminate\Support\ServiceProvider;

class CustomerQueueServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(CustomerQueue::class, function ($app) {
            return new CustomerQueue();
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
