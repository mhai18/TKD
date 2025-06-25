<?php

namespace App\Enums;

enum Religion: string
{
    case RC         = 'Roman Catholic';
    case SDA        = 'Seventh-Day Adventist';
    case INC        = 'Iglesia ni Cristo';
    case JW         = 'Jehovah Witnesses';
    case PENTECOSTAL = 'Pentecostal';
    case BAPTIST    = 'Baptist';
    case DD         = 'Dating Daan';
    case MORMONS    = 'Mormons';
    case BA         = 'Born Again';
    case MUSLIM     = 'Muslim';
}
