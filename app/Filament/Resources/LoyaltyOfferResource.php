<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoyaltyOfferResource\Pages;
use App\Helpers\AdminFieldsHelper;
use App\Models\LoyaltyOffer;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoyaltyOfferResource extends Resource
{
    protected static ?string $model = LoyaltyOffer::class;

    protected static ?string $slug = 'loyalty-offers';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = "Boutique";

    protected static ?string $navigationIcon = 'heroicon-o-gift-top';

    public static function form(Form $form): Form
    {
        return $form
            ->schema( [
                TextInput::make( 'points' )
                    ->required()
                    ->integer(),

                DatePicker::make( 'start_date' )
                    ->native(false),

                DatePicker::make( 'end_date' )
                    ->native(false),

                Toggle::make( 'is_active' )
                    ->inline(false),

                AdminFieldsHelper::getAdminFields(
                    Select::make( 'shop_id' )
                        ->relationship( 'shop', 'name' )
                        ->searchable()
                        ->preload()
                        ->required(),
                    auth()->user()->shop_id
                )
            ] );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns( [
                TextColumn::make( 'points' ),

                TextColumn::make( 'start_date' )
                    ->date(),

                TextColumn::make( 'end_date' )
                    ->date(),

                TextColumn::make( 'is_active' ),

                TextColumn::make( 'shop.name' )
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
            'index'  => Pages\ListLoyaltyOffers::route( '/' ),
            'create' => Pages\CreateLoyaltyOffer::route( '/create' ),
            'edit'   => Pages\EditLoyaltyOffer::route( '/{record}/edit' ),
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
        return parent::getGlobalSearchEloquentQuery()->with( ['shop'] );
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['shop.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->shop) {
            $details['Shop'] = $record->shop->name;
        }

        return $details;
    }
}
