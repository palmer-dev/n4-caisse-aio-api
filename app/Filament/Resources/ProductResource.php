<?php

namespace App\Filament\Resources;

use App\Enums\ProductTypeEnum;
use App\Filament\Resources\ProductResource\Pages;
use App\Helpers\AdminFieldsHelper;
use App\Models\Product;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $slug = 'products';

    protected static ?string $navigationGroup = "Boutique";

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function getNavigationLabel(): string
    {
        return __( 'nav.products' );
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema( [
                TextInput::make( 'name' )
                    ->required()
                    ->live( true )
                    ->afterStateUpdated( fn($state, callable $set) => $set( 'slug', Str::slug( $state ) ) ),

                TextInput::make( 'slug' )
                    ->required()
                    ->disabled()
                    ->unique( Product::class, 'slug', fn($record) => $record ),

                Select::make( 'type' )
                    ->options( ProductTypeEnum::class )
                    ->native( false )
                    ->live( true )
                    ->default( ProductTypeEnum::SIMPLE->value )
                    ->required(),

                Select::make( 'category_id' )
                    ->relationship( 'category', 'name' )
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make( 'vat_rate_id' )
                    ->relationship( 'vatRate', 'name' )
                    ->getOptionLabelFromRecordUsing( fn(Model $record) => Number::percentage( $record->value, 2, locale: "fr_FR" ) . " - $record->name" )
                    ->searchable()
                    ->required()
                    ->preload(),

                AdminFieldsHelper::getAdminFields(
                    adminField: Select::make( 'shop_id' )
                        ->relationship( 'shop', 'name' )
                        ->searchable()
                        ->required()
                        ->preload(),
                    default_value: auth()->user()->shop_id
                ),

                RichEditor::make( 'description' )
                    ->columnSpanFull(),

                Repeater::make( 'productAttributes' )
                    ->relationship( 'productAttributes' )
                    ->label( __( "Product attributes" ) )
                    ->itemLabel( fn(array $state): ?string => $state['name'] ?? null )
                    ->addActionLabel( __( "Add a new attribute" ) )
                    ->schema( [
                            // Standard fields
                            TextInput::make( 'name' )
                                ->label( "Attribute name" )
                                ->required()
                                ->maxLength( 255 ),

                            Repeater::make( 'productAttributeSkus' )
                                ->relationship( 'productAttributeSkus' )
                                ->label( __( "Product variations" ) )
                                ->addActionLabel( fn($get) => __( "Add a variation to " ) . $get( 'name' ) )
                                ->itemLabel( fn(array $state, $get): ?string => $get( "name" ) . " - " . ($state['value'] ?? null) )
                                ->schema( [
                                    TextInput::make( 'value' )
                                        ->label( 'Attribute Value' )
                                        ->required()
                                        ->distinct()
                                        ->maxLength( 255 ),

                                    Group::make()
                                        ->columns( 2 )
                                        ->label( "SKU Détails" )// Permet de créer un SKU directement
                                        ->relationship( 'sku' )
                                        ->schema( [
                                                TextInput::make( 'sku' )
                                                    ->label( 'SKU Code' )
                                                    ->distinct()
                                                    ->required(),

                                                TextInput::make( 'unit_amount' )
                                                    ->label( 'Price' )
                                                    ->numeric()
                                                    ->required(),
                                            ]
                                        )
                                ] )
                                ->columnSpanFull(),
                        ]
                    )
                    ->columnSpanFull()
                    ->visible( fn($get) => ProductTypeEnum::from( $get( "type" ) ) === ProductTypeEnum::VARIABLE ),

                Group::make()
                    ->columnSpanFull()
                    ->columns( 2 )
                    ->label( "SKU Détails" )// Permet de créer un SKU directement
                    ->relationship( 'sku' )
                    ->schema( [
                            TextInput::make( 'sku' )
                                ->label( 'SKU Code' )
                                ->required(),

                            TextInput::make( 'unit_amount' )
                                ->label( 'Price' )
                                ->numeric()
                                ->required(),
                        ]
                    )
                    ->visible( fn($get) => ProductTypeEnum::from( $get( "type" ) ) !== ProductTypeEnum::VARIABLE ),
            ] );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns( [
                TextColumn::make( 'name' )
                    ->searchable()
                    ->sortable(),

                TextColumn::make( 'slug' )
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                TextColumn::make( 'minPrice' )
                    ->label( 'Price' )
                    ->formatStateUsing( function ($state, Product $product) {
                        if ($product->type === ProductTypeEnum::VARIABLE)
                            if ($product->minPrice !== $product->maxPrice)
                                return Number::currency( $product->minPrice, "EUR", "fr" ) . ' - ' . Number::currency( $product->maxPrice, "EUR", "fr" );
                            else
                                return Number::currency( $product->minPrice, "EUR", "fr" );

                        return Number::currency( $product->sku->unit_amount ?? 0, "EUR", "fr" );
                    } ),

                TextColumn::make( 'type' )
                    ->badge(),

                TextColumn::make( 'category.name' )
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make( 'vatRate.value' )
                    ->sortable()
                    ->toggleable()
                    ->suffix( "%" ),

                TextColumn::make( 'shop.name' )
                    ->searchable()
                    ->sortable()
                    ->visible( auth()->user()->isAdmin() ),
            ] )
            ->groups( ["category.name"] )
            ->filters( [
                TrashedFilter::make(),
                SelectFilter::make( "type" )->options( ProductTypeEnum::class ),
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
            'index'  => Pages\ListProducts::route( '/' ),
            'create' => Pages\CreateProduct::route( '/create' ),
            'edit'   => Pages\EditProduct::route( '/{record}/edit' ),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes( [
                SoftDeletingScope::class,
            ] );
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with( ['category', 'vatRate'] );
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug', 'category.name', 'vatRate.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->category) {
            $details['Category'] = $record->category->name;
        }

        if ($record->vatRate) {
            $details['VatRate'] = $record->vatRate->name;
        }

        return $details;
    }

    public static function getRelations(): array
    {
        return [];
    }
}
