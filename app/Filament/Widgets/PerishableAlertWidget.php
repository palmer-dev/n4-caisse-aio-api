<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PerishableAlertWidget extends BaseWidget
{
    protected static ?string $heading = 'Alerte de péremption';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::perishable()
                    ->limitDateOver( now() )
            )
            ->columns( [
                TextColumn::make( 'name' )->label( 'Produit' ),
            ] )
            ->deferLoading();
    }
}
