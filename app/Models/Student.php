<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'sexe',
        'programs',
        'profile',
        'country',
        'language',
        'bio',
    ];

    protected $casts = [
        'programs' => 'array',
    ];

    // Accessor pour l'URL complète du profil
    protected function profileUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->profile ? asset('storage/'.$this->profile) : null,
        );
    }
}
