<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Animal
        </h2>
    </x-slot>

    <div class="max-w-lg mx-auto">
        <div class="mb-6">
            <a href="{{ route('animals.index') }}" class="text-sm font-medium text-indigo-400 hover:text-indigo-300 hover:underline">← Volver al listado</a>
        </div>

        <form action="{{ route('animals.store') }}" method="POST" class="bg-slate-800/60 p-6 rounded-xl shadow-sm border border-slate-700">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300 mb-1">Nombre</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name') }}"
                           placeholder="El nombre del animal"
                           @class([
                               'w-full px-3.5 py-2 rounded-lg border text-sm transition focus:outline-none focus:ring-2',
                               'border-rose-500 bg-slate-900 text-slate-100 placeholder-slate-500 focus:border-rose-400 focus:ring-rose-500/20' => $errors->has('name'),
                               'border-slate-600 bg-slate-900 text-slate-100 placeholder-slate-500 focus:border-indigo-400 focus:ring-indigo-500/20' => ! $errors->has('name'),
                           ])>

                    @error('name')
                        <p class="text-xs text-rose-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="age" class="block text-sm font-medium text-slate-300 mb-1">Edad</label>
                    <input type="number"
                           name="age"
                           id="age"
                           value="{{ old('age') }}"
                           placeholder="La edad del animal"
                           @class([
                               'w-full px-3.5 py-2 rounded-lg border text-sm transition focus:outline-none focus:ring-2',
                               'border-rose-500 bg-slate-900 text-slate-100 placeholder-slate-500 focus:border-rose-400 focus:ring-rose-500/20' => $errors->has('age'),
                               'border-slate-600 bg-slate-900 text-slate-100 placeholder-slate-500 focus:border-indigo-400 focus:ring-indigo-500/20' => ! $errors->has('age'),
                           ])>

                    @error('age')
                        <p class="text-xs text-rose-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="species_id" class="block text-sm font-medium text-slate-300 mb-1">Especie</label>
                    <select name="species_id"
                            id="species_id"
                            @class([
                                'w-full px-3.5 py-2 rounded-lg border text-sm transition focus:outline-none focus:ring-2',
                                'border-rose-500 bg-slate-900 text-slate-100 placeholder-slate-500 focus:border-rose-400 focus:ring-rose-500/20' => $errors->has('species_id'),
                                'border-slate-600 bg-slate-900 text-slate-100 placeholder-slate-500 focus:border-indigo-400 focus:ring-indigo-500/20' => ! $errors->has('species_id'),
                            ])>
                        <option value="">Seleccione una especie</option>
                        @foreach ($species as $specie)
                            <option value="{{ $specie['id'] }}" {{ old('species_id') == $specie['id'] ? 'selected' : '' }}>
                                {{ $specie['name'] }}
                            </option>
                        @endforeach
                    </select>

                    @error('species_id')
                        <p class="text-xs text-rose-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-700">
                    <a href="{{ route('animals.index') }}" class="px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-700 rounded-lg transition">Cancelar</a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition shadow-sm">Guardar Animal</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
