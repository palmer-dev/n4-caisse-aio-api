<?php

namespace App\Filament\Resources\ShopResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employees';

    public function form(Form $form): Form
    {
        return $form
            ->schema( [
                Forms\Components\TextInput::make( 'firstname' )
                    ->required()
                    ->maxLength( 255 ),
                Forms\Components\TextInput::make( 'lastname' )
                    ->required()
                    ->maxLength( 255 ),
            ] );
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute( 'firstname' )
            ->columns( [
                Tables\Columns\TextColumn::make( 'firstname' ),
                Tables\Columns\TextColumn::make( 'lastname' ),
                Tables\Columns\TextColumn::make( 'code' ),
            ] )
            ->filters( [
                //
            ] )
            ->headerActions( [
                Tables\Actions\CreateAction::make(),
            ] )
            ->actions( [
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ] )
            ->bulkActions( [
                Tables\Actions\BulkActionGroup::make( [
                    Tables\Actions\DeleteBulkAction::make(),
                ] ),
            ] );
    }
}
