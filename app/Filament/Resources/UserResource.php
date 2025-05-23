<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = "users";

    protected static ?string $navigationGroup = "Administration";

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationLabel(): string
    {
        return __( 'nav.users' );
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema( [
                Forms\Components\TextInput::make( 'firstname' )
                    ->required()
                    ->maxLength( 255 ),
                Forms\Components\TextInput::make( 'lastname' )
                    ->required()
                    ->maxLength( 255 ),
                Forms\Components\TextInput::make( 'email' )
                    ->email()
                    ->required()
                    ->maxLength( 255 ),
                Forms\Components\Select::make( 'shop' )
                    ->relationship( 'shop', 'name' )
                    ->native(false)
                    ->required()
            ] );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns( [
                Tables\Columns\TextColumn::make( 'firstname' )
                    ->searchable(),
                Tables\Columns\TextColumn::make( 'lastname' )
                    ->searchable(),
                Tables\Columns\TextColumn::make( 'email' )
                    ->searchable(),
                Tables\Columns\TextColumn::make( 'shop.name' )
                    ->searchable(),
                Tables\Columns\TextColumn::make( 'email_verified_at' )
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make( 'created_at' )
                    ->dateTime()
                    ->sortable()
                    ->toggleable( isToggledHiddenByDefault: true ),
                Tables\Columns\TextColumn::make( 'updated_at' )
                    ->dateTime()
                    ->sortable()
                    ->toggleable( isToggledHiddenByDefault: true ),
            ] )
            ->filters( [
                //
            ] )
            ->actions( [
                Tables\Actions\EditAction::make(),
            ] )
            ->bulkActions( [
                Tables\Actions\BulkActionGroup::make( [
                    Tables\Actions\DeleteBulkAction::make(),
                ] ),
            ] );
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route( '/' ),
            'create' => Pages\CreateUser::route( '/create' ),
            'edit'   => Pages\EditUser::route( '/{record}/edit' ),
        ];
    }
}
