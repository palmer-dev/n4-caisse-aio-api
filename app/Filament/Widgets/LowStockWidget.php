<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LowStockWidget extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return Product::query()->where( 'stock', '<', 10 )->orderBy( 'stock' );
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make( 'name' )->label( 'Produit' ),
            TextColumn::make( 'stock' )->label( 'Stock restant' ),
        ];
    }
}
