<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Filament\Resources\SaleResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SalesRelationManager extends RelationManager
{
    protected static string $relationship = 'sales';

    public function form(Form $form): Form
    {
        return $form
            ->schema( [
                Forms\Components\TextInput::make( 'sale_no' )
                    ->required()
                    ->maxLength( 255 ),
            ] );
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute( 'sale_no' )
            ->columns( [
                Tables\Columns\TextColumn::make( 'sale_no' ),
            ] )
            ->filters( [
                //
            ] )
            ->headerActions( [
                Tables\Actions\CreateAction::make(),
            ] )
            ->actions( [
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ] )
            ->bulkActions( [
                Tables\Actions\BulkActionGroup::make( [
                    Tables\Actions\DeleteBulkAction::make(),
                ] ),
            ] )
            ->recordUrl(
                fn($record) => SaleResource::getUrl( 'view', ['record' => $record] )
            );
    }
}
