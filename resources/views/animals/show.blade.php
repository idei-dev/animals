<x-layout>
    <x-slot:title>Detalle de {{ $animal['name'] }}</x-slot:title>

    <div class="max-w-md mx-auto">
        <div class="mb-6">
            <a href="{{ route('animals.index') }}" class="text-sm font-medium text-indigo-400 hover:text-indigo-300 hover:underline">← Volver al listado</a>
        </div>

        <div class="bg-slate-800/60 p-6 rounded-xl shadow-sm border border-slate-700">
            <div class="flex items-center justify-between pb-4 border-b border-slate-700">
                <span class="text-xs font-mono bg-slate-900 px-2.5 py-1 rounded text-slate-300">ID: #{{ $animal['id'] }}</span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-indigo-500/10 text-indigo-300">Especie: {{ $animal['species'] }}</span>
            </div>

            <div class="py-6">
                <h1 class="text-2xl font-bold text-slate-100">{{ $animal['name'] }}</h1>
                <p class="text-sm text-slate-400 mt-1">Edad: {{ $animal['age'] }} años</p>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-700">
                <a href="{{ route('animals.edit', $id) }}" class="text-sm font-medium text-indigo-400 hover:text-indigo-300">
                    Editar animal
                </a>

                <form action="{{ route('animals.destroy', $id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este animal?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm font-medium text-rose-400 hover:text-rose-300">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
