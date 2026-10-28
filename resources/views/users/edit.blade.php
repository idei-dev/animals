<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Usuario
        </h2>
    </x-slot>

    <div class="max-w-lg mx-auto">
        <div class="mb-6">
            <a href="{{ route('users.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 hover:underline">
                ← Volver al listado
            </a>
        </div>

        <form action="{{ route('users.update', $user['id']) }}" method="POST" class="bg-white dark:bg-slate-800/60 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-slate-700">
                    <span class="text-xs font-mono bg-gray-100 dark:bg-slate-900 px-2.5 py-1 rounded text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-800">
                        ID: #{{ $user['id'] }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                        @if(($user['role'] ?? '') === 'admin') bg-purple-500/10 text-purple-600 dark:text-purple-300 border border-purple-500/20
                        @elseif(($user['role'] ?? '') === 'employee') bg-blue-500/10 text-blue-600 dark:text-blue-300 border border-blue-500/20
                        @else bg-gray-500/10 text-gray-600 dark:text-slate-300 border border-gray-500/20
                        @endif">
                        Rol actual: {{ ucfirst($user['role'] ?? 'customer') }}
                    </span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Nombre</label>
                    <div class="w-full px-3.5 py-2 rounded-lg border border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-slate-100 text-sm font-medium">
                        {{ $user['name'] }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Email</label>
                    <div class="w-full px-3.5 py-2 rounded-lg border border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-slate-100 text-sm font-medium">
                        {{ $user['email'] }}
                    </div>
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Rol</label>
                    <select name="role"
                            id="role"
                            @class([
                                'w-full px-3.5 py-2 rounded-lg border text-sm transition focus:outline-none focus:ring-2',
                                'border-rose-500 bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:border-rose-400 focus:ring-rose-500/20' => $errors->has('role'),
                                'border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500/20' => ! $errors->has('role'),
                            ])>
                        <option value="customer" class="bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100" {{ old('role', $user['role'] ?? '') === 'customer' ? 'selected' : '' }}>
                            Cliente (customer)
                        </option>
                        <option value="employee" class="bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100" {{ old('role', $user['role'] ?? '') === 'employee' ? 'selected' : '' }}>
                            Empleado (employee)
                        </option>
                        <option value="admin" class="bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100" {{ old('role', $user['role'] ?? '') === 'admin' ? 'selected' : '' }}>
                            Administrador (admin)
                        </option>
                    </select>

                    @error('role')
                        <p class="text-xs text-rose-600 dark:text-rose-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-200 dark:border-slate-700">
                    <a href="{{ route('users.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition">Cancelar</a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition shadow-sm">Actualizar Rol</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
