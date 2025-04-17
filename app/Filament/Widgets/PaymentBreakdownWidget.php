<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PaymentBreakdownWidget extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Stat::make( 'Espèces', number_format( Sale::where( 'payment_method', 'cash' )->sum( 'grand_total' ) / 100, 2 ) . ' €' ),
            Stat::make( 'Carte bancaire', number_format( Sale::where( 'payment_method', 'card' )->sum( 'grand_total' ) / 100, 2 ) . ' €' ),
            Stat::make( 'Autres', number_format( Sale::whereNotIn( 'payment_method', ['cash', 'card'] )->sum( 'grand_total' ) / 100, 2 ) . ' €' ),
        ];
    }
}
