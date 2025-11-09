<?php

namespace App\Models;


use App\Enums\Sexe;
use App\Enums\Program;
use App\Enums\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
            ? asset('storage/' . $this->profile) 
            : null;
    }
}