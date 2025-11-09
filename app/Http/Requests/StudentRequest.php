<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $studentId = $this->route('student')?->id;

        return [
            "name"=>['required','string','max:255'],
            "email"=>['required','email','max:255',Rule::unique('students')->ignore($studentId)],
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
            'email.unique' => "Cet email est déjà utilisé.",
        ];
    }   
}
