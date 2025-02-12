<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum MovementTypeEnum: string implements HasLabel, HasColor
{
    //
    case INPUT  = 'input';
    case OUTPUT = 'output';


    public function getColor(): string|array|null
    {
        return match ($this) {
            self::INPUT => Color::Green,
            self::OUTPUT => Color::Red,
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::INPUT => __( 'enums/movement_type.input' ),
            self::OUTPUT => __( 'enums/movement_type.output' ),
        };
    }
}
