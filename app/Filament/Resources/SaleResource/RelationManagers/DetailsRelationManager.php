<?php

namespace App\Filament\Resources\SaleResource\RelationManagers;

use App\Models\Sku;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    public function form(Form $form): Form
    {
        return $form
            ->schema( [
                Select::make( "sku_id" )
                    ->relationship( "sku", "id" )
                    ->getOptionLabelFromRecordUsing( fn($record) => $record->product->name . ($record->productAttributeSku ? (" " . $record->productAttributeSku->value) : "") )
                    ->afterStateUpdated( function (Set $set, $state) {
                        $sku = Sku::find( $state );
                        $set( "unit_price", $sku->unit_amount );
                        $set( "vat", $sku->product->vatRate->value );
                    } )
                    ->required()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->searchable()
                    ->native(false)
                    ->live(),

                Hidden::make( "unit_price" )
                    ->required(),
                Hidden::make( "vat" )
                    ->required(),

                TextInput::make( 'quantity' )
                    ->label( __( "Quantity" ) )
                    ->required()
                    ->live( true )
                    ->integer(),

                Placeholder::make( 'pl_unit_price' )
                    ->label( __( "Unit Price" ) )
                    ->content( function (Get $get): string {
                        $price = 0;
                        if ($get( "sku_id" ))
                            $price = Sku::find( $get( "sku_id" ) )->unit_amount;

                        return number_format( $price, 2 ) . '€';
                    } ),

                Placeholder::make( 'pl_vat' )
                    ->label( __( "VAT" ) )
                    ->content( function (Get $get): string {
                        $vat = 0;
                        if ($get( "sku_id" ))
                            $vat = Sku::find( $get( "sku_id" ) )->product->vatRate->value;

                        return number_format( $vat, 2 ) . '%';
                    } ),

                Placeholder::make( 'pl_sub_total' )
                    ->content( function (Get $get): string {
                        $subTotal = 0;
                        if ($get( "sku_id" )) {
                            $sku      = Sku::find( $get( "sku_id" ) );
                            $vat      = $sku->product->vatRate->value;
                            $price    = $sku->unit_amount;
                            $subTotal = $price * (1 + ($vat / 100)) * $get( "quantity" );
                        }

                        return number_format( $subTotal, 2 ) . '€';
                    } )
            ] );
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute( 'sku_id' )
            ->columns( [
                Tables\Columns\TextColumn::make( 'sku_id' )
                    ->label( "Product" )
                    ->getStateUsing( fn($record) => $record->sku->product->name . ($record->sku->productAttributeSku ? " - {$record->sku->productAttributeSku->value}" : '') ),
                TextColumn::make( 'quantity' )
                    ->label( __( "Quantity" ) ),
                TextColumn::make( 'unit_price' )
                    ->label( __( "Unit price" ) )
                    ->money("EUR"),
                TextColumn::make( 'vat' )
                    ->label( __( "Vat" ) )
                    ->suffix( "%" )
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
