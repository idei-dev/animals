<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AnimalDataRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255|in:león,elefante,pez payaso,gato,perro,conejo,caballo,oso,pájaro,tortuga',
            'age' => 'required|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del animal es obligatorio.',
            'species.required' => 'Debes ingresar la especie.',
            'species.in' => 'La especie seleccionada no es válida.',
            'age.required' => 'La edad es obligatoria.',
            'age.integer' => 'La edad debe ser un número entero.',
            'age.min' => 'La edad debe ser de al menos :min año.',
            'age.max' => 'La edad no puede superar los :max años.',
        ];
    }
}
