<x-layout>
    <x-slot:title>Listado de Especies</x-slot:title>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Especies</h1>
            <p class="text-sm text-slate-500 mt-1">Gestión y clasificación de especies animales.</p>
        </div>
        <a href="{{ route('species.create') }}"
           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
            + Nueva Especie
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                    <th class="py-3 px-6">ID</th>
                    <th class="py-3 px-6">Nombre de la Especie</th>
                    <th class="py-3 px-6 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse ($species as $item)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="py-4 px-6 font-mono text-xs text-slate-400">#{{ $item['id'] }}</td>
                        <td class="py-4 px-6 font-medium text-slate-900">
                            <a href="{{ route('species.show', $item['id']) }}" class="hover:underline hover:text-indigo-600">
                                {{ $item['name'] }}
                            </a>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('species.show', $item['id']) }}" class="text-xs text-slate-500 hover:text-slate-800 font-medium">Ver</a>
                                <span class="text-slate-300">|</span>
                                <a href="{{ route('species.edit', $item['id']) }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Editar</a>
                                <span class="text-slate-300">|</span>
                                <form action="{{ route('species.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta especie?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 font-medium">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-12 text-center text-slate-400">
                            No hay especies registradas actualmente.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
