<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum DiscountType: string implements HasLabel, HasColor
{
    case PERCENT = 'percent';
    case AMOUNT  = 'amount';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PERCENT => 'red',
            self::AMOUNT => 'green',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PERCENT => 'Percent',
            self::AMOUNT => 'Amount',
        };
    }
}
