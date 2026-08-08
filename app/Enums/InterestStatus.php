<?php

namespace App\Enums;

enum InterestStatus:string
{
    case VERY_INTERESTED = 'very_interested';
    case MODERATED_INTEREST = 'moderated_interest';
    case LOW_INTEREST = 'low_interest';
    case NO_INTEREST = 'no_interest';
    case CLOSED_DEAL = 'closed_deal';

    public function label(): string
    {
        return match ($this) {
            self::VERY_INTERESTED => 'Muito interessado',
            self::MODERATED_INTEREST => 'Interesse moderado',
            self::LOW_INTEREST => 'Pouco interesse',
            self::NO_INTEREST => 'Sem interesse',
            self::CLOSED_DEAL => 'Negócio fechado',
        };
    }
    public static function values():array{
        return array_column(self::cases(), 'value');
    }
}
