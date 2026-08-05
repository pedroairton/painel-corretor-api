<?php

namespace App\Enums;

enum ContactResult:string
{
    case ANSWERED = 'answered';
    case NOT_ANSWER = 'not_answered';
    case CALL_LATER = 'call_later';
    case VISIT_SCHEDULED = 'visit_scheduled';
    case CLOSED_DEAL = 'closed_deal';

    public function label():string {
        return match ($this){
            self::ANSWERED => 'Atendeu',
            self::NOT_ANSWER => 'Não atendeu',
            self::CALL_LATER => 'Retornar depois',
            self::VISIT_SCHEDULED => 'Visita agendada',
            self::CLOSED_DEAL => 'Negócio fecahdo',
        };
    }
    public static function values():array{
        return array_column(self::cases(), 'value');
    }
}
