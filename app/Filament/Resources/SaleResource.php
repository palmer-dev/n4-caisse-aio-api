<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers\DetailsRelationManager;
use App\Helpers\AdminFieldsHelper;
use App\Models\Sale;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
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

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $slug = 'sales';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema( [
                Select::make( 'employee_id' )
                    ->relationship( 'employee', 'email' )
                    ->searchable(),

                Select::make( 'client_id' )
                    ->relationship( 'client', 'email' )
                    ->searchable(),

                AdminFieldsHelper::getAdminFields(
                    adminField: Select::make( 'shop_id' )
                        ->relationship( 'shop', 'name' )
                        ->searchable()
                        ->required()
                        ->preload(),
                    default_value: auth()->user()->shop_id
                ),

                TextInput::make( 'discount' )
                    ->default( 0 )
                    ->suffix( "%" )
                    ->required()
                    ->numeric(),

                TextInput::make( 'sub_total' )
                    ->required()
                    ->integer(),

                TextInput::make( 'grand_total' )
                    ->required()
                    ->integer()
            ] );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns( [
                TextColumn::make( 'sale_no' )
                    ->label( 'N°' )
                    ->searchable()
                    ->sortable(),

                TextColumn::make( 'employee.lastname' )
                    ->formatStateUsing( fn(Sale $record) => $record->employee->fullName )
                    ->placeholder( __( "Unknown" ) )
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make( 'client.email' )
                    ->placeholder( __( "Not registered" ) )
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make( 'shop.name' )
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->visible( auth()->user()->isAdmin() ),

                TextColumn::make( 'discount' )
                    ->default( 0 )
                    ->suffix( "%" )
                    ->toggleable(),

                TextColumn::make( 'sub_total' )
                    ->money( "EUR" )
                    ->toggleable(),

                TextColumn::make( 'grand_total' )
                    ->money( "EUR" )
                    ->toggleable(),

                TextColumn::make( 'created_at' )
                    ->dateTime()
                    ->toggleable(),
            ] )
            ->filters( [
                TrashedFilter::make(),
            ] )
            ->actions( [
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
                Action::make( 'previewPdf' )
                    ->label( 'View Receipt' )
                    ->modalHeading( 'Receipt Preview' )
                    ->modalSubmitAction( false ) // Pas besoin de bouton "Valider"
                    ->modalCancelActionLabel( 'Close' )
                    ->modalContent( function ($record) {
                        $pdfUrl = route( 'receipts.preview', $record ); // Route qui retourne le PDF

                        return view( 'components.pdf-preview', ['pdfUrl' => $pdfUrl] );
                    } ),
            ] )
            ->bulkActions( [
                BulkActionGroup::make( [
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ] ),
            ] )
            ->defaultSort( 'created_at', 'desc' );
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSales::route( '/' ),
            'create' => Pages\CreateSale::route( '/create' ),
            'edit'   => Pages\EditSale::route( '/{record}/edit' ),
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
        return parent::getGlobalSearchEloquentQuery()->with( ['employee', 'client'] );
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['employee.email', 'client.email'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->employee) {
            $details['Employee'] = $record->employee->email;
        }

        if ($record->client) {
            $details['Client'] = $record->client->email;
        }

        return $details;
    }

    public static function getRelations(): array
    {
        return [
            ...parent::getRelations(),
            DetailsRelationManager::class,
        ];
    }
}
