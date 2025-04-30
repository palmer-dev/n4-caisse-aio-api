<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AddressTypeEnum: string implements HasLabel
{
    case PRIMARY  = 'primary';
    case BILLING  = 'billing';
    case SHIPPING = 'shipping';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::PRIMARY => __( 'enums/address_type.primary' ),
            self::BILLING => __( 'enums/address_type.billing' ),
            self::SHIPPING => __( 'enums/address_type.shipping' ),
        };
    }
}
