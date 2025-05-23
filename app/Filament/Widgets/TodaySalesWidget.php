<?php

namespace App\Filament\Widgets;

use App\Enums\PaymentMethodEnum;
use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TodaySalesWidget extends BaseWidget
{
    protected function getCards(): array
    {
        $todaySales = Sale::whereDate( 'created_at', today() )->sum( 'grand_total' ) / 100;
        $weekSales  = Sale::whereBetween( 'created_at', [now()->startOfWeek(), now()] )->sum( 'grand_total' ) / 100;
        $cash       = Sale::where( 'payment_method', PaymentMethodEnum::CASH )->sum( 'grand_total' ) / 100;
        $card       = Sale::where( 'payment_method', PaymentMethodEnum::CARD )->sum( 'grand_total' ) / 100;

        return [
            Stat::make( 'Chiffre du jour', number_format( $todaySales, 2 ) . ' €' ),
            Stat::make( 'Chiffre de la semaine', number_format( $weekSales, 2 ) . ' €' ),
            Stat::make( 'Espèces', number_format( $cash, 2 ) . ' €' ),
            Stat::make( 'Carte bancaire', number_format( $card, 2 ) . ' €' ),
        ];
    }
}

