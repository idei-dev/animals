<?php

namespace App\Http\Controllers;

use App\Contracts\SpeciesServiceInterface;
use Illuminate\Http\Request;
use App\Contracts\AnimalServiceInterface;
use App\Http\Requests\AnimalDataRequest;

class AnimalController extends Controller
{
    public function __construct(
        private SpeciesServiceInterface $speciesService,
        private AnimalServiceInterface $animalService
    ) {
    }

    public function index()
    {
        $animals = $this->animalService->all();
        return view('animals.index', ['animals' => $animals]);
    }

    public function create()
    {
        $species = $this->speciesService->all();
        return view('animals.create', [
            'species' => $species
        ]);
    }

    public function store(AnimalDataRequest $request)
    {
        $data = $request->validated();
        $this->animalService->create($data);
        return redirect()->route('animals.index')->with('success', 'Animal creado exitosamente.');
    }

    public function edit(string $id)
    {
        try {
            $animal = $this->animalService->find($id);
            $species = $this->speciesService->all();
            return view('animals.edit', [
                'id' => $id,
                'animal' => $animal,
                'species_id' => $animal['species_id'],
                'species' => $species
            ]);
        } catch (\Exception $e) {
            return redirect()->route('animals.index')->with('error', $e->getMessage());
        }
    }

    public function update(AnimalDataRequest $request, string $id)
    {
        $data = $request->validated();
        try {
            $this->animalService->update($id, $data);
            return redirect()->route('animals.index')->with('success', 'Animal actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('animals.index')->with('error', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $animal = $this->animalService->find($id);
            return view('animals.show', ['id' => $id, 'animal' => $animal]);
        } catch (\Exception $e) {
            return redirect()->route('animals.index')->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->animalService->delete($id);
            return redirect()->route('animals.index')->with('success', 'Animal eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('animals.index')->with('error', $e->getMessage());
        }
    }

    public function reset()
    {
        $this->animalService->reset();
        return redirect()->route('animals.index')->with('success', 'Todos los animales han sido eliminados.');
    }
}
