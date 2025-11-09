<?php

namespace App\Enums;

enum Language: string
{
    case FR = 'fr';
    case EN = 'en';

    public function label(): string
    {
        return match($this) {
            self::FR => 'Français',
            self::EN => 'Anglais',
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