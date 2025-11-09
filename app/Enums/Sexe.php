<?php
// app/Enums/Sexe.php

namespace App\Enums;

enum Sexe: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::MALE => 'Masculinh',
            self::FEMALE => 'Fémininfffffff',
            self::OTHER => 'Autre',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return array_map(
            fn($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}