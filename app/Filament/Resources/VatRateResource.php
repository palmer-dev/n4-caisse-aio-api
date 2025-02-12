<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VatRateResource\Pages;
use App\Models\VatRate;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VatRateResource extends Resource
{
    protected static ?string $model = VatRate::class;

    protected static ?string $slug = 'vat-rates';
    protected static ?string $navigationGroup = "Administration";

     protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';

    public static function getNavigationLabel(): string
    {
        return __( 'nav.vat-rates' );
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema( [
                TextInput::make( 'name' )
                    ->required(),

                TextInput::make( 'value' )
                    ->required()
                    ->numeric()
                    ->step( .01 )
                    ->suffix( '%' )
                    ->minValue( 0 ),

                RichEditor::make( 'description' )
                    ->required()
                    ->columnSpanFull()
            ] );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns( [
                TextColumn::make( 'name' )
                    ->searchable()
                    ->sortable(),

                TextColumn::make( 'description' )
                    ->html()
                    ->words( 5 ),

                TextColumn::make( 'value' )
                    ->numeric( decimalPlaces: 2 )
                    ->suffix( '%' ),
            ] )
            ->filters( [
                TrashedFilter::make(),
            ] )
            ->actions( [
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ] )
            ->bulkActions( [
                BulkActionGroup::make( [
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ] ),
            ] );
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListVatRates::route( '/' ),
            'create' => Pages\CreateVatRate::route( '/create' ),
            'edit'   => Pages\EditVatRate::route( '/{record}/edit' ),
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
        return ['name'];
    }
}
