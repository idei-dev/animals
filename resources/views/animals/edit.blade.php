<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Animal
        </h2>
    </x-slot>

    <div class="max-w-lg mx-auto">
        <div class="mb-6">
            <a href="{{ route('animals.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 hover:underline">← Volver al listado</a>
        </div>

        <form action="{{ route('animals.update', $id) }}" method="POST" class="bg-white dark:bg-slate-800/60 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Nombre</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $animal['name']) }}"
                           @class([
                               'w-full px-3.5 py-2 rounded-lg border text-sm transition focus:outline-none focus:ring-2',
                               'border-rose-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:border-rose-400 focus:ring-rose-500/20' => $errors->has('name'),
                               'border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500/20' => ! $errors->has('name'),
                           ])>

                    @error('name')
                        <p class="text-xs text-rose-600 dark:text-rose-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Edad</label>
                    <input type="number"
                           name="age"
                           id="age"
                           value="{{ old('age', $animal['age']) }}"
                           @class([
                               'w-full px-3.5 py-2 rounded-lg border text-sm transition focus:outline-none focus:ring-2',
                               'border-rose-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:border-rose-400 focus:ring-rose-500/20' => $errors->has('age'),
                               'border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500/20' => ! $errors->has('age'),
                           ])>

                    @error('age')
                        <p class="text-xs text-rose-600 dark:text-rose-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="species_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Especie</label>
                    <select name="species_id"
                            id="species_id"
                            @class([
                                'w-full px-3.5 py-2 rounded-lg border text-sm transition focus:outline-none focus:ring-2',
                                'border-rose-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:border-rose-400 focus:ring-rose-500/20' => $errors->has('species_id'),
                                'border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500/20' => ! $errors->has('species_id'),
                            ])>
                        <option value="">Seleccione una especie</option>
                        @foreach ($species as $specie)
                            <option value="{{ $specie['id'] }}" {{ old('species_id', $animal['species_id']) == $specie['id'] ? 'selected' : '' }}>
                                {{ ucfirst($specie['name']) }}
                            </option>
                        @endforeach
                    </select>

                    @error('species_id')
                        <p class="text-xs text-rose-600 dark:text-rose-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-200 dark:border-slate-700">
                    <a href="{{ route('animals.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition">Cancelar</a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition shadow-sm">Actualizar</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
