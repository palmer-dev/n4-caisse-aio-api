<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers\SalesRelationManager;
use App\Helpers\AdminFieldsHelper;
use App\Helpers\UniqueClientCodeHelper;
use App\Models\Client;
use Carbon\Carbon;
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
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $slug = 'clients';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = "Boutique";

    public static function form(Form $form): Form
    {
        return $form
            ->schema( [
                TextInput::make( 'firstname' )
                    ->maxLength( 50 )
                    ->required(),

                TextInput::make( 'lastname' )
                    ->maxLength( 50 )
                    ->required(),

                TextInput::make( 'zipcode' )
                    ->maxLength( 12 )
                    ->required(),

                TextInput::make( 'email' )
                    ->maxLength( 320 )
                    ->email()
                    ->required(),

                AdminFieldsHelper::getAdminFields(
                    Select::make( 'shop_id' )
                        ->relationship( 'shop', 'name' )
                        ->searchable()
                        ->preload()
                        ->required(),
                    auth()->user()->shop_id
                ),

                TextInput::make( 'phone' )
                    ->tel()
                    ->maxLength( 22 ),

                DatePicker::make( 'birthdate' )
                    ->before( Carbon::now() ),

                Toggle::make( 'newsletter' )
                    ->default( false ),

                TextInput::make( 'code' )
                    ->required()
                    ->default( fn(callable $get) => UniqueClientCodeHelper::generate( $get( "shop" ) ?? auth()->user()->shop_id ) )
                    ->disabledOn( "edit" ),
            ] );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns( [
                TextColumn::make( 'code' ),

                TextColumn::make( 'firstname' ),

                TextColumn::make( 'lastname' ),

                TextColumn::make( 'sales_count' )
                    ->counts( 'sales' )
                    ->default( 0 ),

                TextColumn::make( 'zipcode' ),

                TextColumn::make( 'email' )
                    ->searchable()
                    ->sortable(),

                TextColumn::make( 'phone' ),

                TextColumn::make( 'birthdate' )
                    ->date(),
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
            'index'  => Pages\ListClients::route( '/' ),
            'create' => Pages\CreateClient::route( '/create' ),
            'edit'   => Pages\EditClient::route( '/{record}/edit' ),
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
        return ['email'];
    }

    public static function getRelations(): array
    {
        return
            [
                ...parent::getRelations(),
                SalesRelationManager::class
            ];
    }
}
