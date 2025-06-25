<?php

namespace App\Enums;

enum CivilStatus: string
{
    case MARRIED     = 'Married';
    case SINGLE      = 'Single';
    case SEPARATED   = 'Separated';
    case WIDOWED     = 'Widowed';
    case COMPLICATED = 'Complicated';
}
