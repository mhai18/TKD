<?php

namespace App\Enums;

enum UserType: string
{
    case COACH              = 'Coach';
    case TOURNAMENT_MANAGER = 'Tournament Manager';
    case CHAIRMAN           = 'Chairman';
    case PLAYER             = 'Player';
    case ADMIN              = 'Admin';
}
