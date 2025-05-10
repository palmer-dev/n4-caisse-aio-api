<?php

namespace App\Providers;

use App\Services\SimulationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class SimulationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton( SimulationService::class, function (Application $app) {
            return new SimulationService();
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
