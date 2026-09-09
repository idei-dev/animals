<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function __construct()
    {
        if (! session()->has('animals')) {
            session([
                'animals' => [
                    '1' => ['name' => 'Leo', 'species' => 'León', 'age' => 5],
                    '2' => ['name' => 'Dora', 'species' => 'Elefante', 'age' => 10],
                    '3' => ['name' => 'Nemo', 'species' => 'Pez Payaso', 'age' => 2],
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

    public function update(Request $request, $id)
    {
        $animals = session('animals');
        $animal = $animals[$id] ?? null;

        if (! $animal) {
            return redirect('/animals')->with('error', 'Animal no encontrado');
        }

        $animal['name'] = $request->input('name');
        $animal['species'] = $request->input('species');
        $animal['age'] = $request->input('age');

        $animals[$id] = $animal;

        session(['animals' => $animals]);

        return redirect('/animals')->with('success', 'Animal actualizado correctamente');
    }

    public function store(Request $request)
    {
        $animals = session('animals');
        // Genera un unique ID usando unique_id() y verifica que no exista en el array de animales
        $nuevoId = uniqid();
        $animals[$nuevoId] = [
            'name' => $request->input('name'),
            'species' => $request->input('species'),
            'age' => $request->input('age'),
        ];

        session(['animals' => $animals]);

        return redirect('/animals')->with('success', 'Animal agregado correctamente');
    }

    public function edit($id)
    {
        $animals = session('animals');
        $animal = $animals[$id] ?? null;

        if (! $animal) {
            return redirect('/animals')->with('error', 'Animal no encontrado');
        }

        return view('animals.edit', ['id' => $id, 'animal' => $animal]);
    }

    public function destroy($id)
    {
        $animals = session('animals');
        $animal = $animals[$id] ?? null;

        if (! $animal) {
            return redirect('/animals')->with('error', 'Animal no encontrado');
        }

        unset($animals[$id]);

        session(['animals' => $animals]);

        return redirect('/animals')->with('success', 'Animal eliminado correctamente');
    }
}
