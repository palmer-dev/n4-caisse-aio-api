<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestSalesWidget extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return Sale::latest()->limit( 5 )->with( 'user' );
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make( 'id' )->label( 'N° Vente' ),
            TextColumn::make( 'user.name' )->label( 'Caissier' ),
            TextColumn::make( 'grand_total' )->label( 'Montant' )->money( 'EUR', true ),
            TextColumn::make( 'created_at' )->label( 'Date' )->since(),
        ];
    }
}
