<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Language;
use App\Enums\Sexe;
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
        'sexe' => Sexe::class,
        'language' => Language::class,
        'programs' => 'array',
    ];

    // -Accessor pour l'URL du profil
    public function getProfileUrlAttribute(): ?string
    {
        return $this->profile
            ? asset('storage/'.$this->profile)
            : null;
    }
}
