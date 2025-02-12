<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $slug = 'categories';

    protected static ?string $navigationGroup = "Boutique";

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function getNavigationLabel(): string
    {
        return __( 'nav.categories' );
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema( [
                TextInput::make( 'name' )
                    ->required()
                    ->live( true )
                    ->afterStateUpdated( fn($state, callable $set) => $set( 'slug', Str::slug( $state ) ) ),

                FileUpload::make( 'image' )
                    ->disk( 'public' )
                    ->image()
                    ->imageEditor(),

                TextInput::make( 'slug' )
                    ->required()
                    ->readonly()
                    ->unique( Category::class, 'slug', fn($record) => $record ),

                SelectTree::make( 'parent_id' )
                    ->relationship( 'parent', 'name', 'parent_id' )
                    ->enableBranchNode()
                    ->expandSelected(),

                auth()->user()->isAdmin() ?
                    Select::make( 'shop_id' )
                        ->relationship( 'shop', 'name' )
                        ->searchable()
                        ->preload()
                        ->required()
                        ->default( auth()->user()->shop_id ) :
                    Hidden::make( 'shop_id' )->default( auth()->user()->shop_id ),

                RichEditor::make( 'description' )
                    ->columnSpanFull(),
            ] );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns( [
                ImageColumn::make( 'image' )->width( 50 )->height( 50 ),

                TextColumn::make( 'name' )
                    ->searchable()
                    ->sortable(),

                TextColumn::make( 'slug' )
                    ->searchable()
                    ->sortable(),

                TextColumn::make( 'description' )
                    ->html()
                    ->words( 5 ),

                TextColumn::make( 'parent.name' )
                    ->placeholder( __( "No parent" ) ),

                TextColumn::make( 'shop.name' )
                    ->visible( auth()->user()->isAdmin() ),
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
            'index'  => Pages\ListCategories::route( '/' ),
            'create' => Pages\CreateCategory::route( '/create' ),
            'edit'   => Pages\EditCategory::route( '/{record}/edit' ),
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
        return ['name', 'slug'];
    }
}
