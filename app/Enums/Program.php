<?php

declare(strict_types=1);

namespace App\Enums;

enum Program: string
{
    case PHP = 'php';
    case JS = 'js';
    case HTML = 'html';
    case TYPESCRIPT = 'typescript';
    case VUEJS = 'vuejs';
    case NUXTJS = 'nuxtjs';
    case LARAVEL = 'laravel';
    case INERTIAJS = 'Inertiajs';

    public function label(): string
    {
        return match ($this) {
            self::PHP => 'PHP',
            self::JS => 'JavaScript',
            self::HTML => 'HTML',
            self::TYPESCRIPT => 'TypeScript',
            self::VUEJS => 'Vue.js',
            self::NUXTJS => 'Nuxt.js',
            self::LARAVEL => 'Laravel',
            self::INERTIAJS => 'Inertiajs',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return array_map(
            fn ($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}
