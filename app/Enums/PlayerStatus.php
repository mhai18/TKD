<?php

namespace App\Enums;

enum PlayerStatus: string
{
    case PENDING      = 'Pending';
    case APPROVED     = 'Approved';
    case REJECTED     = 'Rejected';
    case DISQUALIFIED = 'Disqualified';
}
