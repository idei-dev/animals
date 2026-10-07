<x-layout>
    <x-slot:title>Crear Especie</x-slot:title>

    <div class="max-w-lg mx-auto">
        <div class="mb-6">
            <a href="{{ route('species.index') }}" class="text-sm font-medium text-indigo-600 hover:underline">← Volver al listado</a>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 mt-2">Crear Nueva Especie</h1>
        </div>

        <form action="{{ route('species.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nombre</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name') }}"
                           placeholder="Ej. Reptil, Anfibio..."
                           @class([
                               'w-full px-3.5 py-2 rounded-lg border text-sm transition focus:outline-none focus:ring-2',
                               'border-rose-300 focus:border-rose-500 focus:ring-rose-200' => $errors->has('name'),
                               'border-slate-300 focus:border-indigo-500 focus:ring-indigo-100' => ! $errors->has('name'),
                           ])>

                    @error('name')
                        <p class="text-xs text-rose-600 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('species.index') }}" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-lg transition">Cancelar</a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition shadow-sm">Guardar Especie</button>
                </div>
            </div>
        </form>
    </div>
</x-layout>
