<?php

namespace App\Helpers;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Hidden;

class AdminFieldsHelper
{
    /**
     * Helps to add a field that is visible to the administrator but not by the user
     *
     * @param Field $adminField
     * @param $default_value
     * @return Field|Hidden
     */
    static function getAdminFields(Field $adminField, $default_value = null)
    {
        return auth()->user()->isAdmin()
            ? $adminField->default( $default_value )
            : Hidden::make( $adminField->getName() )->default( $default_value );
    }
}
