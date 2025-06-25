<?php

namespace App\Enums;

enum TournamentStatus: string
{
    case DRAFT    = 'Draft';
    case OPEN     = 'Open';
    case ONGOING  = 'Ongoing';
    case FINISHED = 'Finished';
}
