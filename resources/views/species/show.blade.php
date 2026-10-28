<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalle de {{ $species['name'] }}
        </h2>
    </x-slot>

    <div class="max-w-md mx-auto">
        <div class="mb-6">
            <a href="{{ route('species.index') }}"
                class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 hover:underline">← Volver al listado</a>
        </div>

        <div class="bg-white dark:bg-slate-800/60 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-slate-700">
                <span class="text-xs font-mono bg-gray-100 dark:bg-slate-900 px-2.5 py-1 rounded text-gray-600 dark:text-slate-300">ID:
                    #{{ $species['id'] }}</span>
                <span
                    class="text-xs font-semibold px-2 py-0.5 rounded-full bg-indigo-500/10 text-indigo-600 dark:text-indigo-300">Especie</span>
            </div>

            <div class="py-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-slate-100">{{ $species['name'] }}</h1>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Este recurso posteriormente estará vinculado a múltiples
                    animales.</p>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-slate-700">
                <a href="{{ route('species.edit', $species['id']) }}"
                    class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                    Editar especie
                </a>

                <form action="{{ route('species.destroy', $species['id']) }}" method="POST"
                    onsubmit="return confirm('¿Seguro que deseas eliminar esta especie?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm font-medium text-rose-600 dark:text-rose-400 hover:text-rose-500 dark:hover:text-rose-300">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
