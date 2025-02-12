<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Filament\Resources\StockResource\RelationManagers\MovementsRelationManager;
use App\Models\Stock;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static ?string $slug = 'stocks';
    protected static ?string $navigationGroup = 'Boutique';

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema( [
                TextInput::make( 'quantity' )
                    ->required()
                    ->integer()
            ] )
            ->columns( 1 );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns( [
                TextColumn::make( 'product.name' ),
                TextColumn::make( 'productVariation.value' )
                    ->placeholder( __( "No variations" ) ),
                TextColumn::make( 'quantity' )
            ] )
            ->groups( [
                Group::make( 'product.id' )
                    ->getTitleFromRecordUsing( fn(Stock $record): string => $record->product->name ),
            ] )
            ->filters( [
                TrashedFilter::make(),
            ] )
            ->actions( [
                EditAction::make(),
            ] );
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListStocks::route( '/' ),
            'edit'   => Pages\EditStock::route( '/{record}/edit' ),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes( [
                SoftDeletingScope::class,
            ] );
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }

    public static function getRelations(): array
    {
        return [
            MovementsRelationManager::class
        ];
    }
}
