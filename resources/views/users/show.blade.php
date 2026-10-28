<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalles del Usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800/60 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-slate-100">
                    <p><strong>ID:</strong> {{ $user['id'] }}</p>
                    <p><strong>Nombre:</strong> {{ $user['name'] }}</p>
                    <p><strong>Email:</strong> {{ $user['email'] }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>