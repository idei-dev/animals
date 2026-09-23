<?php

/**
 * Tema 1: Validación de formularios en Laravel
 *
 * Request para validar los datos del formulario de creación y edición de animales.
 * Esta clase extiende de FormRequest y define las reglas de validación para los campos del formulario.
 * Un FormRequest es una clase de Laravel que encapsula la lógica de validación y autorización de una solicitud HTTP.
 * Al usar un FormRequest, podemos mantener nuestro controlador limpio y enfocado en la lógica de negocio, mientras que
 * la validación se maneja en una clase separada.
 * Los principios SOLID aplicados aquí incluyen:
 * S. Separación de responsabilidades (Single Responsibility Principle)
 * D. Inversión de dependencias (Dependency Inversion Principle), ya que el controlador depende de una abstracción
 * (el FormRequest) en lugar de depender directamente de la lógica de validación.
 */
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

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
     * prepareForValidation(): Se ejecuta justo ANTES de aplicar las reglas de validación.
     * Es el lugar ideal para sanitizar, limpiar o formatear la entrada del usuario.
     */
    protected function prepareForValidation(): void
    {
        /*
         * 1. $this->has('species') -> "LA PREGUNTA DE SEGURIDAD"
         *
         * En este contexto, $this representa la petición HTTP actual (la "caja" con los datos).
         * Aquí preguntamos: "¿El usuario realmente envió el campo 'species' en esta caja?"
         *
         * ¿Por qué? Porque si intentamos aplicar Str::lower() a un campo que no vino en el
         * formulario (ej. una actualización parcial PATCH), PHP lanzaría un error.
         */
        if ($this->has('species')) {

            /*
             * 2. $this->merge([...]) -> "LA REESCRITURA EN EL PAPEL"
             *
             * Imagina que el usuario te entregó el formulario en papel y escribió "LEÓN".
             * Usar merge() es como tomar un corrector, borrar "LEÓN" y escribir "león"
             * por encima antes de pasárselo al sistema que revisa las reglas.
             *
             * IMPORTANTE: merge() sobrescribe los datos temporalmente en la memoria del
             * servidor. Engaña al Validador para que revise el dato ya limpio, pero
             * destruye el formato original (el "LEÓN" con mayúsculas se pierde para siempre
             * en el ciclo de vida de esta petición).
             */
            $this->merge([
                'species' => Str::lower($this->species),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /**
         * Reglas de validación para los campos del formulario de animales:
         * - name: obligatorio, debe ser una cadena de texto, con un máximo de 255 caracteres.
         * - species: obligatorio, debe ser una cadena de texto, con un máximo de 255 caracteres,
         *   y debe estar dentro de un conjunto específico de especies válidas.
         * - age: obligatorio, debe ser un número entero, con un valor mínimo de 1 y un valor
         *   máximo de 100.
         *
         * Estas reglas aseguran que los datos ingresados por el usuario cumplan con los requisitos
         * esperados antes de ser procesados o almacenados
         * por un servicio en (bases de datos, sesiones, archivos, etc.)
        */
        return [
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255|in:león,elefante,pez payaso,gato,perro,conejo,caballo,oso,pájaro,tortuga',
            'age' => 'required|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        /**
         * Mensajes de error personalizados para las reglas de validación definidas en el método rules().
         * Estos mensajes se mostrarán al usuario cuando los datos ingresados no cumplan con las reglas
         * de validación.
         * Esto mejora la experiencia del usuario al proporcionar retroalimentación clara y específica
         * sobre los errores en el formulario.
         * El formato de los mensajes permite incluir valores dinámicos, como :min y :max, que se reemplazarán
         * con los valores correspondientes de las reglas de validación.
         */
        return [
            'name.required' => 'El nombre del animal es obligatorio.',
            'species.required' => 'Debes ingresar la especie.',
            'species.in' => 'La especie ":input" no es válida.',
            'age.required' => 'La edad es obligatoria.',
            'age.integer' => 'La edad debe ser un número entero.',
            'age.min' => 'La edad debe ser de al menos :min año.',
            'age.max' => 'La edad no puede superar los :max años.',
        ];
    }
}
