<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Helpers\UniqueEmployeeCodeHelper;
use App\Models\Employee;
use Filament\Forms\Components\Hidden;
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
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $slug = 'employees';

    protected static ?string $navigationGroup = "Boutique";

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getNavigationLabel(): string
    {
        return __( 'nav.employees' );
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema( [
                TextInput::make( 'firstname' )
                    ->required(),

                TextInput::make( 'lastname' )
                    ->required(),

                TextInput::make( 'email' ),

                TextInput::make( 'phone' ),

                TextInput::make( 'code' )
                    ->required()
                    ->default( fn(callable $get) => UniqueEmployeeCodeHelper::generate( $get( "shop" ) ?? auth()->user()->shop_id ) )
                    ->disabledOn( "edit" ),

                auth()->user()->isAdmin() ?
                    Select::make( 'shop_id' )
                        ->relationship( 'shop', 'name' )
                        ->searchable()
                        ->preload()
                        ->required()
                        ->default( auth()->user()->shop_id ) :
                    Hidden::make( 'shop_id' )->default( auth()->user()->shop_id )
            ] );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading( __( 'Employees' ) )
            ->description( __( 'Manage your employees here.' ) )
            ->columns( [
                TextColumn::make( 'firstname' ),

                TextColumn::make( 'lastname' ),

                TextColumn::make( 'email' )
                    ->searchable()
                    ->sortable(),

                TextColumn::make( 'phone' ),

                TextColumn::make( 'code' ),

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
            ->groups( auth()->user()->isAdmin() ? ["shop.name"] : [] )
            ->defaultGroup( auth()->user()->isAdmin() ? "shop.name" : null )
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
            'index'  => Pages\ListEmployees::route( '/' ),
            'create' => Pages\CreateEmployee::route( '/create' ),
            'edit'   => Pages\EditEmployee::route( '/{record}/edit' ),
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
        return ['email', 'shop.name'];
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
