<x-layout>
    <x-slot:title>Detalle de {{ $species['name'] }}</x-slot:title>

    <div class="max-w-md mx-auto">
        <div class="mb-6">
            <a href="{{ route('species.index') }}" class="text-sm font-medium text-indigo-600 hover:underline">← Volver al listado</a>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <span class="text-xs font-mono bg-slate-100 px-2.5 py-1 rounded text-slate-600">ID: #{{ $species['id'] }}</span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700">Especie</span>
            </div>

            <div class="py-6">
                <h1 class="text-2xl font-bold text-slate-900">{{ $species['name'] }}</h1>
                <p class="text-sm text-slate-400 mt-1">Este recurso posteriormente estará vinculado a múltiples animales.</p>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                <a href="{{ route('species.edit', $species['id']) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                    Editar especie
                </a>

                <form action="{{ route('species.destroy', $species['id']) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta especie?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm font-medium text-rose-600 hover:text-rose-800">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
