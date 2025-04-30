<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestSalesWidget extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query( Sale::latest()->limit( 5 )->with( 'employee' ) )
            ->columns( [
                TextColumn::make( 'sale_no' )->label( 'N° Vente' ),
                TextColumn::make( 'employee.full_name' )->label( 'Caissier' ),
                TextColumn::make( 'grand_total' )->label( 'Montant' )->money( 'EUR', true ),
                TextColumn::make( 'created_at' )->label( 'Date' )->since(),
            ] )
            ->defaultPaginationPageOption( 5 )
            ->deferLoading();
    }
}
