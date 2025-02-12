<?php

namespace App\Filament\Resources\StockResource\RelationManagers;

use App\Enums\MovementTypeEnum;
use App\Models\StockMovements;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'movements';

    public function form(Form $form): Form
    {
        return $form
            ->schema( [
                Forms\Components\Hidden::make( 'sku_id' )
                    ->default( $this->getOwnerRecord()->sku_id ),

                Forms\Components\Select::make( 'movement_type' )
                    ->options( MovementTypeEnum::class )
                    ->required(),

                Forms\Components\TextInput::make( 'quantity' )
                    ->minValue( 1 )
                    ->required(),
            ] );
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute( 'movement_type' )
            ->columns( [
                Tables\Columns\TextColumn::make( 'quantity' ),
                Tables\Columns\TextColumn::make( 'movement_type' )
                    ->badge(),
                Tables\Columns\TextColumn::make( 'created_at' )
                    ->date()
            ] )
            ->recordClasses( fn(StockMovements $record) => match ($record->movement_type) {
                MovementTypeEnum::INPUT => 'bg-opacity-10 hover:bg-opacity-20 bg-green-600 hover:bg-green-600 dark:bg-green-300 hover:dark:bg-green-300',
                MovementTypeEnum::OUTPUT => 'bg-opacity-10 hover:bg-opacity-20 bg-red-600 hover:bg-red-600 dark:bg-red-300 hover:dark:bg-red-300',
                default => null,
            } )
            ->filters( [
                SelectFilter::make( 'movement_type' )
                    ->options( MovementTypeEnum::class )
            ] )
            ->headerActions( [
                Tables\Actions\CreateAction::make(),
            ] );
    }
}
