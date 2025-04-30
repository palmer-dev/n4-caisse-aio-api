<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PerishableAlertWidget extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::perishable()
            )
            ->columns( [
                TextColumn::make( 'name' )->label( 'Produit' ),
            ] );
    }
}
