<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnimalDataRequest;

/**
 * Controlador EQUIVOCADO para la gestión de animales.
 * Este código tiene problemas de diseño que violan principios de programación.
 *
 * 1.   Viola el SRP (Principio de Responsabilidad Única): El controlador maneja peticiones HTTP,
 *      pero también sabe cómo guardar datos en la sesión, genera IDs y verifica la existencia de registros.
 * 2.   Viola el DIP (Principio de Inversión de Dependencias): El controlador está fuertemente acoplado a la
 *      función session() de Laravel y a un arreglo en memoria. Si mañana quieres usar base de datos (Eloquent), tendrás que reescribir todo el controlador.
 * 3.   Código repetido (Don't Repeat Yourself - DRY): La lógica de buscar si un animal existe
 *      ($animal = $animals[$id] ?? null; if(!$animal)...) se repite en update, edit y destroy.
 */
class WrongAnimalController extends Controller
{
    public function __construct()
    {
        if (! session()->has('animals')) {
            $key1 = uniqid();
            $key2 = uniqid();
            $key3 = uniqid();
            session([
                'animals' => [
                    $key1 => ['name' => 'Leo',   'species' => 'León',        'age' => 5  ],
                    $key2 => ['name' => 'Dora',  'species' => 'Elefante',    'age' => 10 ],
                    $key3 => ['name' => 'Nemo',  'species' => 'Pez Payaso',  'age' => 2  ],
                ],
            ]);
        }
    }

    public function index()
    {
        $animals = session('animals');

        return view('animals.index', ['animals' => $animals]);
    }

    public function create()
    {
        return view('animals.create');
    }

    public function update(AnimalDataRequest $request, string $id)
    {
        $animals = session('animals');
        $animal = $animals[$id] ?? null;

        if (! $animal) {
            return redirect()->route('animals.index')->with('error', 'Animal no encontrado');
        }

        $animals[$id] = $request->validated();
        session(['animals' => $animals]);

        return redirect()->route('animals.index')->with('success', 'Animal actualizado correctamente');
    }

    public function store(AnimalDataRequest $request)
    {
        $validatedData = $request->validated();
        $animals = session('animals');
        $nuevoId = uniqid(); // Genera un ID único
        $animals[$nuevoId] = $validatedData;
        session(['animals' => $animals]);
        return redirect()->route('animals.index')->with('success', 'Animal agregado correctamente');
    }

    public function edit(string $id)
    {
        $animals = session('animals');
        $animal = $animals[$id] ?? null;

        if (! $animal) {
            return redirect()->route('animals.index')->with('error', 'Animal no encontrado');
        }

        return view('animals.edit', ['id' => $id, 'animal' => $animal]);
    }

    public function destroy(string $id)
    {
        $animals = session('animals');
        $animal = $animals[$id] ?? null;

        if (! $animal) {
            return redirect()->route('animals.index')->with('error', 'Animal no encontrado');
        }

        unset($animals[$id]);

        session(['animals' => $animals]);

        return redirect()->route('animals.index')->with('success', 'Animal eliminado correctamente');
    }

    /**
     * Tema 0: Repaso de rutas y controladores en Laravel
     * Paso 0.3:
     * Agregar el método reset al controlador para resetear la lista de animales en la sesión.
     * Utilizamos session()->forget('animals') para eliminar la clave 'animals' de la sesión.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset()
    {
        session()->forget('animals');

        return redirect()->route('animals.index')->with('success', 'Sesión reseteada correctamente');
    }
}
