<?php

namespace App\Enums;

enum ClientSort:string
{
    case RECENT = 'recent';
    case NAME = 'name';
    case PRIORITY = 'priority';
    case INTEREST = 'interest';
}
