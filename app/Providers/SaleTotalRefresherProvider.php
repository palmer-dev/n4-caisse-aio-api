<?php

namespace App\Providers;

use App\Services\SaleTotalRefresher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class SaleTotalRefresherProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton( SaleTotalRefresher::class, function (Application $app) {
            return new SaleTotalRefresher();
        } );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
