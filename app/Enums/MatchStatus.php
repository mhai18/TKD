<?php

namespace App\Enums;

enum MatchStatus: string
{
    case SCHEDULED = 'Scheduled';
    case ONGOING   = 'Ongoing';
    case COMPLETED = 'Completed';
    case CANCELLED = 'Cancelled';
    case FORFEIT   = 'Forfeit';
}
