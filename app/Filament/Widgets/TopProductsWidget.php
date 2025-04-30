<?php

namespace App\Filament\Widgets;

use App\Models\SaleDetail;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class TopProductsWidget extends BaseWidget
{
    public function getTableRecordKey(Model $record): string
    {
        return $record->sku_id;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SaleDetail::selectRaw( 'sku_id, SUM(quantity) as total_sold' )
                    ->groupBy( 'sku_id' )
                    ->orderByDesc( 'total_sold' )
                    ->with( 'sku.product' )
                    ->limit( 5 )
            )
            ->columns( [
                TextColumn::make( 'sku.product.name' )->label( 'Produit' ),
                TextColumn::make( 'total_sold' )->label( 'Quantité vendue' ),
            ] )
            ->deferLoading();
    }
}
