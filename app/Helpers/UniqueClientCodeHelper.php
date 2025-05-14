<?php

namespace App\Helpers;

use App\Models\Client;

class UniqueClientCodeHelper
{
    static function generate(string $shop_id): int
    {
        $codes = Client::where( "shop_id", $shop_id )
            ->pluck( "code" )
            ->toArray();

        do {
            $newCode = self::generateCode();
        } while (in_array( $newCode, $codes ));

        return $newCode;
    }

    static function generateCode(): string
    {
        return str_pad( rand( 1, 99999 ), 5, '0', STR_PAD_LEFT );
    }
}
