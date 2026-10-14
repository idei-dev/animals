<?php

namespace App\Http\Controllers;

use App\Contracts\SpeciesServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpeciesController extends Controller
{
    /**
     * Paso 4: Inyectamos la interfaz en el constructor.
     * Laravel se encargará de proveer SpeciesMockService automáticamente.
     */
    public function __construct(
        protected SpeciesServiceInterface $speciesService
    ) {}

    /**
     * Listado de especies.
     */
    public function index(): View
    {
        $species = $this->speciesService->all();

        return view('species.index', compact('species'));
    }

    /**
     * Formulario para crear una nueva especie.
     */
    public function create(): View
    {
        return view('species.create');
    }

    /**
     * Almacenar una nueva especie en el servicio.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $this->speciesService->create($validated);

        return redirect()
            ->route('species.index')
            ->with('success', 'Especie creada con éxito.');
    }

    /**
     * Mostrar el detalle de una especie.
     */
    public function show(string $id): View
    {
        $species = $this->speciesService->find($id);

        abort_if(! $species, 404, 'Especie no encontrada.');

        return view('species.show', compact('species'));
    }

    /**
     * Formulario para editar una especie existente.
     */
    public function edit(string $id): View
    {
        $species = $this->speciesService->find($id);

        abort_if(! $species, 404, 'Especie no encontrada.');

        return view('species.edit', compact('species'));
    }

    /**
     * Actualizar los datos de la especie.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $updated = $this->speciesService->update($id, $validated);

        abort_if(! $updated, 404, 'Especie no encontrada.');

        return redirect()
            ->route('species.index')
            ->with('success', 'Especie actualizada con éxito.');
    }

    /**
     * Eliminar una especie.
     */
    public function destroy(string $id): RedirectResponse
    {
        $deleted = $this->speciesService->delete($id);

        abort_if(! $deleted, 404, 'Especie no encontrada.');

        return redirect()
            ->route('species.index')
            ->with('success', 'Especie eliminada con éxito.');
    }

    /**
     * Resetear las especies a su estado inicial.
     */
    public function reset(): RedirectResponse
    {
        $this->speciesService->reset();

        return redirect()
            ->route('species.index')
            ->with('success', 'Especies reseteadas con éxito.');
    }
}
