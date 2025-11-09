<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Language;
use App\Enums\Program;
use App\Enums\Sexe;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studentId = $this->route('student')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('students')->ignore($studentId)],
            'sexe' => ['required', Rule::in(Sexe::values())],
            'programs' => ['required', 'array'],
            'programs.*' => ['string', Rule::in(Program::values())],
            'profile' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png,webp'],
            'country' => ['nullable', 'string', 'max:100'],
            'language' => ['required', Rule::in(Language::values())],
            'bio' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',

            'email.required' => "L'email est obligatoire.",
            'email.email' => "L'email doit être une adresse email valide.",
            'email.max' => "L'email ne doit pas dépasser 255 caractères.",
            'email.unique' => 'Cet email est déjà utilisé.',

            'sexe.required' => 'Le sexe est obligatoire.',
            'sexe.in' => 'Le sexe doit être masculin, féminin ou autre.',

            'programs.required' => 'Sélectionnez au moins un programme.',
            'programs.array' => 'Les programmes doivent être un tableau.',
            'programs.*.in' => 'Programme invalide sélectionné.',

            'profile.image' => 'Le fichier doit être une image.',
            'profile.max' => "L'image ne doit pas dépasser 2 Mo.",
            'profile.mimes' => "L'image doit être au format jpg, jpeg, png ou webp.",

            'language.required' => 'La langue est obligatoire.',
            'language.in' => 'La langue doit être français ou anglais.',

            'bio.max' => 'La biographie ne doit pas dépasser 500 caractères.',
        ];
    }
}
