<?php

namespace App\Filament\Widgets;

use App\Models\Stock;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Stock::query()->where( "quantity", "<", 10 )
                    ->orderBy( "quantity" )
                ->with( ["sku.product" ] ),
            )
            ->columns( [
                TextColumn::make( 'sku.product.name' )->label( 'Produit' ),
                TextColumn::make( 'quantity' )->label( 'Stock restant' ),
            ] );
    }
}
