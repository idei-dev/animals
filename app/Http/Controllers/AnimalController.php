<?php

/**
 * Tema 2: Principio de Inversión de Dependencias (DIP) en Laravel
 *
 * Paso 4: El Controlador Evolucionado (Clean Code)
 * Finalmente, refactorizamos el controlador original. Ahora es un "Thin Controller":
 * solo recibe la petición, se la pasa al servicio, y devuelve la respuesta HTTP.
 */
namespace App\Http\Controllers;

use App\Http\Requests\AnimalDataRequest;
use App\Contracts\AnimalServiceInterface;

class AnimalController extends Controller
{
    // Inyección de dependencias a través del constructor
    public function __construct(
        private AnimalServiceInterface $animalService
    ) {
    }

    public function index()
    {
        return view('animals.index', [
            'animals' => $this->animalService->all()
        ]);
    }

    public function create()
    {
        return view('animals.create');
    }

    public function store(AnimalDataRequest $request)
    {
        $this->animalService->create($request->validated());

        return redirect()->route('animals.index')
            ->with('success', 'Animal agregado correctamente');
    }

    public function edit(string $id)
    {
        $animal = $this->animalService->find($id);

        if (!$animal) {
            return redirect()->route('animals.index')
                ->with('error', 'Animal no encontrado');
        }

        return view('animals.edit', compact('id', 'animal'));
    }

    public function update(AnimalDataRequest $request, string $id)
    {
        if (!$this->animalService->update($id, $request->validated())) {
            return redirect()->route('animals.index')
                ->with('error', 'Animal no encontrado');
        }

        return redirect()->route('animals.index')
            ->with('success', 'Animal actualizado correctamente');
    }

    public function destroy(string $id)
    {
        if (!$this->animalService->delete($id)) {
            return redirect()->route('animals.index')
                ->with('error', 'Animal no encontrado');
        }

        return redirect()->route('animals.index')
            ->with('success', 'Animal eliminado correctamente');
    }

    public function reset()
    {
        $this->animalService->reset();

        return redirect()->route('animals.index')
            ->with('success', 'Sesión reseteada correctamente');
    }
}
