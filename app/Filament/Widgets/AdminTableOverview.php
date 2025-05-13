<?php

namespace App\Filament\Widgets;

use App\Models\Shop;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class AdminTableOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'CA par boutique';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Shop::query()
                    ->select( 'shops.id', 'shops.name' )
                    ->selectSub( function ($query) {
                        $query->from( 'sales' )
                            ->selectRaw( 'COUNT(*)' )
                            ->whereColumn( 'sales.shop_id', 'shops.id' );
                    }, 'orders_count' )
                    ->selectSub( function ($query) {
                        $query->from( 'sales' )
                            ->selectRaw( 'SUM(grand_total) / 100' )
                            ->whereColumn( 'sales.shop_id', 'shops.id' );
                    }, 'total_revenue' )
                    ->selectSub( function ($query) {
                        $query->from( 'sales' )
                            ->selectRaw( 'MAX(created_at)' )
                            ->whereColumn( 'sales.shop_id', 'shops.id' );
                    }, 'last_order_date' )
            )
            ->defaultSort( 'total_revenue', 'desc' )
            ->columns( [
                TextColumn::make( 'name' )
                    ->label( 'Boutique' )
                    ->sortable()
                    ->searchable(),

                TextColumn::make( 'orders_count' )
                    ->label( 'Commandes' )
                    ->sortable()
                    ->numeric()
                    ->alignRight(),

                TextColumn::make( 'total_revenue' )
                    ->label( 'Chiffre d\'Affaires' )
                    ->sortable()
                    ->money( 'EUR' )
                    ->alignRight(),

                TextColumn::make( 'last_order_date' )
                    ->label( 'Dernière commande' )
                    ->sortable()
                    ->alignRight()
                    ->dateTime( 'd/m/Y H:i' ),
            ] );
    }
}
