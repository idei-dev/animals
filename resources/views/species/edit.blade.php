<x-app-layout>

   <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Especie
        </h2>
    </x-slot>

    <div class="max-w-lg mx-auto">
        <div class="mb-6">
            <a href="{{ route('species.index') }}" class="text-sm font-medium text-indigo-400 hover:text-indigo-300 hover:underline">← Volver al listado</a>
        </div>

        <form action="{{ route('species.update', $species['id']) }}" method="POST" class="bg-slate-800/60 p-6 rounded-xl shadow-sm border border-slate-700">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300 mb-1">Nombre</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $species['name']) }}"
                           @class([
                               'w-full px-3.5 py-2 rounded-lg border text-sm transition focus:outline-none focus:ring-2',
                               'border-rose-500 bg-slate-900 text-slate-100 placeholder-slate-500 focus:border-rose-400 focus:ring-rose-500/20' => $errors->has('name'),
                               'border-slate-600 bg-slate-900 text-slate-100 placeholder-slate-500 focus:border-indigo-400 focus:ring-indigo-500/20' => ! $errors->has('name'),
                           ])>

                    @error('name')
                        <p class="text-xs text-rose-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-700">
                    <a href="{{ route('species.index') }}" class="px-4 py-2 text-sm font-medium text-slate-300 hover:bg-slate-700 rounded-lg transition">Cancelar</a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition shadow-sm">Actualizar</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
