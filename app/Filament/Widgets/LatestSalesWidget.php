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
        return Sale::latest()->limit( 5 )->with( 'employee' );
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make( 'sale_no' )->label( 'N° Vente' ),
            TextColumn::make( 'employee.full_name' )->label( 'Caissier' ),
            TextColumn::make( 'grand_total' )->label( 'Montant' )->money( 'EUR', true ),
            TextColumn::make( 'created_at' )->label( 'Date' )->since(),
        ];
    }
}
