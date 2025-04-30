<?php

namespace App\Providers;

use App\Services\ReceiptService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class ReceiptServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton( ReceiptService::class, function (Application $app) {
            return new ReceiptService();
        } );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
