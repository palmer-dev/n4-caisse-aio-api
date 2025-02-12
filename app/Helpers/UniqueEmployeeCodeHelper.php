<?php

namespace App\Helpers;

use App\Models\Employee;
use App\Models\Shop;

class UniqueEmployeeCodeHelper
{
    static function generate(string $shop_id): int
    {
        $codes = Employee::where( "shop_id", $shop_id )->pluck( "code" )->toArray();

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
