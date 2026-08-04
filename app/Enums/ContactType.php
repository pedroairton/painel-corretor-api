<?php

namespace App\Enums;

enum ContactType:string
{
    case CALL = 'call';
    case MEETING = 'meeting';
    case EMAIL = 'email';
    case WHATSAPP = 'whatsapp';
    case OTHER = 'other';

    public function label():string {
        return match ($this){
            self::CALL => 'Ligação',
            self::MEETING => 'Reunião',
            self::EMAIL => 'E-mail',
            self::WHATSAPP => 'WhatsApp',
            self::OTHER => 'Outro',
        };
    }
}
