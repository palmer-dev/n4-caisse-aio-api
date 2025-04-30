<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Widgets\LatestSalesWidget;
use App\Filament\Widgets\LowStockWidget;
use App\Filament\Widgets\PaymentBreakdownWidget;
use App\Filament\Widgets\PerishableAlertWidget;
use App\Filament\Widgets\SalesChart;
use App\Filament\Widgets\ShopInfoWidget;
use App\Filament\Widgets\TodaySalesWidget;
use App\Filament\Widgets\TopProductsWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id( 'admin' )
            ->path( 'admin' )
            ->login()
            ->colors( [
                'primary' => Color::Amber,
            ] )
            ->discoverResources( in: app_path( 'Filament/Resources' ), for: 'App\\Filament\\Resources' )
            ->discoverPages( in: app_path( 'Filament/Pages' ), for: 'App\\Filament\\Pages' )
            ->pages( [
                Pages\Dashboard::class,
            ] )
            ->widgets( [
                ShopInfoWidget::class,
                PerishableAlertWidget::class,
                TodaySalesWidget::class,
                SalesChart::class,
                LowStockWidget::class,
                TopProductsWidget::class,
                LatestSalesWidget::class,
            ] )
            ->middleware( [
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ] )
            ->authMiddleware( [
                Authenticate::class,
            ] )
            ->profile( EditProfile::class )
            ->databaseNotifications()
//            ->databaseNotificationsPolling( '5s' )
            ->navigationGroups( [
                'Administration' => NavigationGroup::make( fn() => __( 'nav.admin' ) ),
                'Boutique'       => NavigationGroup::make( fn() => __( 'nav.boutique' ) ),
                'Settings'       => NavigationGroup::make( fn() => __( 'nav.setting' ) ),
            ] )
            ->viteTheme( 'resources/css/filament/admin/theme.css' );
    }
}
