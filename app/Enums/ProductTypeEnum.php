<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ProductTypeEnum: string implements HasLabel, HasColor
{
    case SIMPLE = 'simple';

    case VARIABLE = 'variable';

    case PERISHABLE = 'perishable';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SIMPLE => "Simple",
            self::VARIABLE => "Variable",
            self::PERISHABLE => "Perishable",
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SIMPLE => Color::Blue,
            self::VARIABLE => Color::Violet,
            self::PERISHABLE => Color::Red,
        };
    }
}
