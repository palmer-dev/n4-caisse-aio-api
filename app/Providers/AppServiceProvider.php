<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use Filament\Tables\Table;
use Illuminate\Support\ServiceProvider;

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

        Table::configureUsing( function (Table $table): void {
            $table->deferLoading();
        } );
    }
}
