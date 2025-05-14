<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminOverview;
use App\Filament\Widgets\AdminTableOverview;
use App\Filament\Widgets\LatestSalesWidget;
use App\Filament\Widgets\LowStockWidget;
use App\Filament\Widgets\PerishableAlertWidget;
use App\Filament\Widgets\SalesChart;
use App\Filament\Widgets\ShopInfoWidget;
use App\Filament\Widgets\TodaySalesWidget;
use App\Filament\Widgets\TopProductsWidget;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getWidgets(): array
    {
        $widgets = [
            ShopInfoWidget::class,
            TodaySalesWidget::class,
            PerishableAlertWidget::class,
            LowStockWidget::class,
            SalesChart::class,
            TopProductsWidget::class,
            LatestSalesWidget::class,
        ];
        if (auth()->user() && auth()->user()->isAdmin())
            $widgets = [
                AdminOverview::class,
                AdminTableOverview::class,
            ];

        return $widgets;
    }
}
