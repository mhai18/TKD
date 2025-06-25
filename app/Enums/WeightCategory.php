<?php

namespace App\Enums;

enum WeightCategory: string
{
    case FIN     = 'Fin';
    case FLY     = 'Fly';
    case BANTAM  = 'Bantam';
    case FEATHER = 'Feather';
    case LIGHT   = 'Light';
    case WELTER  = 'Welter';
    case MIDDLE  = 'Middle';
    case HEAVY   = 'Heavy';

    public function getRange(string $division, string $gender): array
    {
        $ranges = self::getAllWeightRanges();

        return $ranges[$division][$gender][$this->value] ?? [0, 0];
    }

    public static function getAllWeightRanges(): array
    {
        return [
            'Senior Division' => [
                'Men' => [
                    'Fin'     => [0, 54],
                    'Fly'     => [54, 58],
                    'Bantam'  => [58, 63],
                    'Feather' => [63, 68],
                    'Light'   => [68, 74],
                    'Welter'  => [74, 80],
                    'Middle'  => [80, 87],
                    'Heavy'   => [87, PHP_INT_MAX],
                ],
                'Women' => [
                    'Fin'     => [0, 46],
                    'Fly'     => [46, 49],
                    'Bantam'  => [49, 53],
                    'Feather' => [53, 57],
                    'Light'   => [57, 62],
                    'Welter'  => [62, 67],
                    'Middle'  => [67, 73],
                    'Heavy'   => [73, PHP_INT_MAX],
                ],
            ],
            'Junior Division' => [
                'Men' => [
                    'Fin'     => [0, 54],
                    'Fly'     => [54, 58],
                    'Bantam'  => [58, 63],
                    'Feather' => [63, 68],
                    'Light'   => [68, 74],
                    'Welter'  => [74, 80],
                    'Middle'  => [80, 87],
                    'Heavy'   => [87, PHP_INT_MAX],
                ],
                'Women' => [
                    'Fin'     => [0, 46],
                    'Fly'     => [46, 49],
                    'Bantam'  => [49, 53],
                    'Feather' => [53, 57],
                    'Light'   => [57, 62],
                    'Welter'  => [62, 67],
                    'Middle'  => [67, 73],
                    'Heavy'   => [73, PHP_INT_MAX],
                ],
            ],
            'Cadet Division' => [
                'Men' => [
                    'Fin'     => [0, 54],
                    'Fly'     => [54, 58],
                    'Bantam'  => [58, 63],
                    'Feather' => [63, 68],
                    'Light'   => [68, 74],
                    'Welter'  => [74, 80],
                    'Middle'  => [80, 87],
                    'Heavy'   => [87, PHP_INT_MAX],
                ],
                'Women' => [
                    'Fin'     => [0, 46],
                    'Fly'     => [46, 49],
                    'Bantam'  => [49, 53],
                    'Feather' => [53, 57],
                    'Light'   => [57, 62],
                    'Welter'  => [62, 67],
                    'Middle'  => [67, 73],
                    'Heavy'   => [73, PHP_INT_MAX],
                ],
            ],
        ];
    }
}
