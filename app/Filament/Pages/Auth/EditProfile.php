<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Filament\Support\Colors\Color;

class EditProfile extends BaseEditProfile
{
    protected ?string $generatedToken = null;

    public function form(Form $form): Form
    {
        return $form
            ->schema( [
                Repeater::make( 'tokens' )
                    ->relationship( 'tokens' )
                    ->addable( false )
                    ->itemLabel( fn(array $state): ?string => $state['name'] ?? null )
                    ->schema( [
                        TextInput::make( 'name' )
                            ->label( 'Name' )
                            ->required()
                            ->disabled()
                    ] ),
                TextInput::make( 'firstname' )
                    ->required()
                    ->maxLength( 255 ),
                TextInput::make( 'lastname' )
                    ->required()
                    ->maxLength( 255 ),
                $this->getEmailFormComponent(),
            ] );
    }

    protected function getFormActions(): array
    {
        return [
            ...parent::getFormActions(),
            Action::make( 'generate_token' )
                ->label( 'Générer un Token' )
                ->modalContent()
                ->form( [
                    TextInput::make( 'name' )
                        ->required()
                        ->maxLength( 255 )
                ] )
                ->action( function ($data, EditProfile $livewire) {
                    $user = User::find( data_get( $livewire, "data.id" ) );

                    $newToken = $user->createToken( $data["name"] );

                    // Stocker le token brut dans une propriété temporaire
                    $this->generatedToken = $newToken->plainTextToken;

                    $notification = Notification::make()
                        ->success()
                        ->title( 'Saved successfully' )
                        ->body( "Your token has been saved ! Make sure to save it, it will not be shown again :<br/>$newToken->plainTextToken" )
                        ->send()
                        ->toDatabase();

                    $user->notify( $notification );

                } )
                ->color( Color::Gray )
                ->icon( 'heroicon-o-plus' )
        ];
    }
}
