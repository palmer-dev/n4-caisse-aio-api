<?php

namespace App\Filament\Resources;

use App\Enums\AddressTypeEnum;
use App\Filament\Resources\ShopResource\Pages;
use App\Filament\Resources\ShopResource\RelationManagers\EmployeesRelationManager;
use App\Models\Shop;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShopResource extends Resource
{
    protected static ?string $model = Shop::class;

    protected static ?string $slug = 'shops';

    protected static ?string $navigationGroup = "Administration";

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function getNavigationLabel(): string
    {
        return __( 'nav.shops' );
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema( [
                TextInput::make( 'name' )
                    ->required(),

                Fieldset::make( __( "Primary Address" ) )
                    ->relationship( "primaryAddress" )
                    ->schema( [
                        TextInput::make( 'street' )
                            ->autocomplete( "street" )
                            ->required(),
                        TextInput::make( 'city' )
                            ->autocomplete( "city" )
                            ->required(),
                        TextInput::make( 'state' )
                            ->autocomplete( "state" ),
                        TextInput::make( 'postal_code' )
                            ->autocomplete( "postal_code" )
                            ->required(),
                        TextInput::make( 'country' )
                            ->autocomplete( "country" )
                            ->required(),
                        Hidden::make( "type" )->default( AddressTypeEnum::PRIMARY ),
                    ] )
            ] );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns( [
                TextColumn::make( 'name' )
                    ->searchable()
                    ->sortable(),
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
            'index'  => Pages\ListShops::route( '/' ),
            'create' => Pages\CreateShop::route( '/create' ),
            'edit'   => Pages\EditShop::route( '/{record}/edit' ),
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

    public static function getRelations(): array
    {
        return [
            EmployeesRelationManager::class,
        ];
    }
}
