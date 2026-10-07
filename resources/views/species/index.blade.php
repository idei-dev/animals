<x-layout>
    <x-slot:title>Listado de Especies</x-slot:title>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Especies</h1>
        <a href="{{ route('species.create') }}" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">+ Nueva</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b text-xs text-slate-500 uppercase">
                <tr>
                    <th class="py-3 px-6">ID</th>
                    <th class="py-3 px-6">Nombre</th>
                    <th class="py-3 px-6 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($species as $id => $item)
                <tr class="hover:bg-slate-50">
                    <td class="py-3 px-6 font-mono text-xs text-slate-400">#{{ $id }}</td>
                    <td class="py-3 px-6 font-medium">{{ $item['name'] }}</td>
                    <td class="py-3 px-6 text-right space-x-2">
                        <a href="{{ route('species.show', $id) }}" class="text-slate-500 hover:underline">Ver</a>
                        <a href="{{ route('species.edit', $id) }}" class="text-indigo-600 hover:underline">Editar</a>
                        <form action="{{ route('species.destroy', $id) }}" method="POST" class="inline" onsubmit="return confirm('¿Borrar?');">
                            @csrf @method('DELETE')
                            <button class="text-rose-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-8 text-center text-slate-400">No hay especies registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>