<x-layout>
    <x-slot:title>Editar Especie</x-slot:title>
    <div class="max-w-lg mx-auto">
        <a href="{{ route('species.index') }}" class="text-sm text-indigo-600 hover:underline">← Volver</a>
        <h1 class="text-2xl font-bold text-slate-900 mt-2 mb-6">Editar Especie #{ $id }</h1>
        <form action="{{ route('species.update', $id) }}" method="POST" class="bg-white p-6 rounded-xl border border-slate-200">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $species['name']) }}"
                        @class([ 'w-full px-3.5 py-2 rounded-lg border text-sm focus:outline-none focus:ring-2' , 'border-rose-300 focus:border-rose-500'=> $errors->has('name'),
                    'border-slate-300 focus:border-indigo-500' => ! $errors->has('name'),
                    ])>
                    @error('name')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div class="pt-4 flex justify-end gap-3 border-t">
                    <a href="{{ route('species.index') }}" class="px-4 py-2 text-sm text-slate-600">Cancelar</a>
                    <button type="submit" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-lg">Actualizar</button>
                </div>
            </div>
        </form>
    </div>
</x-layout>