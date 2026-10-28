<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Listado de Usuarios
        </h2>
    </x-slot>

    <!-- <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <a href="{{ route('users.create') }}"
           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
            + Nuevo Usuario
        </a>
    </div> -->

    <div class="bg-white dark:bg-slate-800/60 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 text-xs uppercase font-semibold text-gray-500 dark:text-slate-400 tracking-wider">
                    <th class="py-3 px-6">ID</th>
                    <th class="py-3 px-6">Nombre</th>
                    <th class="py-3 px-6">Rol</th>
                    <th class="py-3 px-6 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-slate-700 text-sm">
                @forelse ($users as $item)
                    @if ($item['id'] === auth()->user()->id)
                        @continue
                    @endif
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/40 transition-colors">
                        <td class="py-4 px-6 font-mono text-xs text-gray-500 dark:text-slate-400">#{{ $item['id'] }}</td>
                        <td class="py-4 px-6 font-medium text-gray-900 dark:text-slate-100">
                            <a href="{{ route('users.show', $item['id']) }}" class="hover:underline text-indigo-600 dark:text-indigo-400">
                                {{ $item['name'] }}
                            </a>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                @if(($item['role'] ?? '') === 'admin') bg-purple-500/10 text-purple-600 dark:text-purple-300 border border-purple-500/20
                                @elseif(($item['role'] ?? '') === 'employee') bg-blue-500/10 text-blue-600 dark:text-blue-300 border border-blue-500/20
                                @else bg-gray-500/10 text-gray-600 dark:text-slate-300 border border-gray-500/20
                                @endif">
                                {{ ucfirst($item['role'] ?? 'customer') }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('users.edit', $item['id']) }}" class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">Editar</a>
                                <span class="text-gray-300 dark:text-slate-600">|</span>
                                <form action="{{ route('users.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-rose-600 dark:text-rose-400 font-medium">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-12 text-center text-gray-500 dark:text-slate-400">
                            No hay usuarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>