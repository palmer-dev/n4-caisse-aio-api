<?php

namespace App\Filament\Pages\Auth;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\Permission;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Filament\Support\Colors\Color;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        $permissions = Permission::whereNotIn( "name", PermissionsEnum::features() )->pluck( 'name', 'name' )->toArray();

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
                            ->disabled(),
                        CheckboxList::make( 'abilities' )
                            ->options( $permissions )
                            ->bulkToggleable()
                            ->hidden( !auth()->user()->hasRole( RolesEnum::ADMIN ) )
                            ->columns( 2 )
                    ] )
                    ->collapsed(),
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
        $permissions = Permission::whereNotIn( "name", PermissionsEnum::features() )->pluck( 'name', 'name' )->toArray();

        return [
            ...parent::getFormActions(),
            Action::make( 'generate_token' )
                ->label( 'Générer une clé' )
                ->modalContent()
                ->form( [
                    TextInput::make( 'name' )
                        ->required()
                        ->maxLength( 255 ),
                    CheckboxList::make( 'abilities' )
                        ->options( $permissions )
                        ->columns( 4 )
                        ->default( array_values( $permissions ) )
                        ->bulkToggleable()
                        ->hidden( !auth()->user()->hasRole( RolesEnum::ADMIN ) ),
                    Section::make( "Jeton" )->description( __( "Copy this token because it will not be shown again after this step." ) )->schema( [
                        TextInput::make( 'token' )
                            ->hiddenLabel()
                            ->default( fn() => auth()->user()->generateTokenString() )
                            ->readOnly()
                            ->suffixAction(
                                FormAction::make( 'copy' )
                                    ->icon( 'heroicon-s-clipboard' )
                                    ->action( function ($livewire, $state) {
                                        $livewire->dispatch( 'copy-to-clipboard', text: $state );
                                    } )
                            )
                            ->extraAttributes( [
                                'x-data'                        => '{
                                                                    copyToClipboard(text) {
                                                                        if (navigator.clipboard && navigator.clipboard.writeText) {
                                                                            navigator.clipboard.writeText(text).then(() => {
                                                                                $tooltip("Copied to clipboard", { timeout: 1500 });
                                                                            }).catch(() => {
                                                                                $tooltip("Failed to copy", { timeout: 1500 });
                                                                            });
                                                                        } else {
                                                                            const textArea = document.createElement("textarea");
                                                                            textArea.value = text;
                                                                            textArea.style.position = "fixed";
                                                                            textArea.style.opacity = "0";
                                                                            document.body.appendChild(textArea);
                                                                            textArea.select();
                                                                            try {
                                                                                document.execCommand("copy");
                                                                                $tooltip("Copied to clipboard", { timeout: 1500 });
                                                                            } catch (err) {
                                                                                $tooltip("Failed to copy", { timeout: 1500 });
                                                                            }
                                                                            document.body.removeChild(textArea);
                                                                        }
                                                                    }
                                                                }',
                                'x-on:copy-to-clipboard.window' => 'copyToClipboard($event.detail.text)',
                            ] ),
                    ] )
                ] )
                ->action( function ($data, EditProfile $livewire) {
                    $user = User::find( data_get( $livewire, "data.id" ) );

                    $defaultAbilities = [
                        PermissionsEnum::VIEW_CLIENTS->value,
                        PermissionsEnum::VIEW_PRODUCTS,
                        PermissionsEnum::VIEW_CATEGORIES,
                        PermissionsEnum::VIEW_EMPLOYEES,
                        PermissionsEnum::VIEW_SALES,
                        PermissionsEnum::VIEW_STOCKS,
                        PermissionsEnum::VIEW_STOCK_MOVEMENTS,
                        PermissionsEnum::VIEW_SKUS,
                        PermissionsEnum::VIEW_ATTRIBUTE_SKUS,
                        PermissionsEnum::CREATE_SALES,
                    ];

                    $user->saveToken( $data["name"], $data["token"], $data["abilities"] ?? $defaultAbilities );

                    Notification::make()
                        ->success()
                        ->title( 'Saved successfully' )
                        ->body( "Your token has been saved !" )
                        ->send();

                } )
                ->color( Color::Gray )
                ->icon( 'heroicon-o-plus' )
        ];
    }
}
