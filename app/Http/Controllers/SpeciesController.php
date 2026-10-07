<?php

namespace App\Http\Controllers;

use App\Contracts\SpeciesServiceInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SpeciesController extends Controller
{
    public function __construct(
        protected SpeciesServiceInterface $speciesService
    ) {}

    public function index(): View
    {
        $species = $this->speciesService->all();
        return view('species.index', compact('species'));
    }

    public function create(): View
    {
        return view('species.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(['name' => 'required|string|max:50']);
        $this->speciesService->create($validated);
        return redirect()->route('species.index')->with('success', 'Especie creada con éxito.');
    }

    public function show(string $id): View
    {
        $species = $this->speciesService->find($id);

        abort_if(! $species, 404, 'Especie no encontrada.');
        
        return view('species.show', compact('id', 'species'));
    }

    public function edit(string $id): View
    {
        $species = $this->speciesService->find($id);
        abort_if(! $species, 404, 'Especie no encontrada.');
        return view('species.edit', compact('id', 'species'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate(['name' => 'required|string|max:50']);
        $updated = $this->speciesService->update($id, $validated);
        abort_if(! $updated, 404, 'Especie no encontrada.');
        return redirect()->route('species.index')->with('success', 'Especie actualizada con éxito.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $deleted = $this->speciesService->delete($id);
        abort_if(! $deleted, 404, 'Especie no encontrada.');
        return redirect()->route('species.index')->with('success', 'Especie eliminada con éxito.');
    }

    public function reset(): RedirectResponse
    {
        $this->speciesService->reset();
        return redirect()->route('species.index')->with('success', 'Especies restablecidas a los valores predeterminados.');
    }
}
