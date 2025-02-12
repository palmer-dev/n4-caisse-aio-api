<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CurrencyEnum: string implements HasLabel
{
    case EUR = 'EUR'; // Euro
    case USD = 'USD'; // Dollar américain
    case GBP = 'GBP'; // Livre sterling
    case JPY = 'JPY'; // Yen japonais
    case AUD = 'AUD'; // Dollar australien
    case CAD = 'CAD'; // Dollar canadien
    case CHF = 'CHF'; // Franc suisse
    case CNY = 'CNY'; // Yuan chinois
    case INR = 'INR'; // Roupie indienne
    case MXN = 'MXN'; // Peso mexicain
    case NZD = 'NZD'; // Dollar néo-zélandais
    case SEK = 'SEK'; // Couronne suédoise
    case NOK = 'NOK'; // Couronne norvégienne
    case RUB = 'RUB'; // Rouble russe
    case ZAR = 'ZAR'; // Rand sud-africain

    public function getLabel(): ?string
    {
        return match ($this) {
            self::EUR => 'Euro',
            self::USD => 'Dollar américain',
            self::GBP => 'Livre sterling',
            self::JPY => 'Yen japonais',
            self::AUD => 'Dollar australien',
            self::CAD => 'Dollar canadien',
            self::CHF => 'Franc suisse',
            self::CNY => 'Yuan chinois',
            self::INR => 'Roupie indienne',
            self::MXN => 'Peso mexicain',
            self::NZD => 'Dollar néo-zélandais',
            self::SEK => 'Couronne suédoise',
            self::NOK => 'Couronne norvégienne',
            self::RUB => 'Rouble russe',
            self::ZAR => 'Rand sud-africain',
        };
    }
}
