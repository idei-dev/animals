<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Inicio
        </h2>
    </x-slot>

    Estás logueado como {{ auth()->user()->name }} y tu rol es {{ auth()->user()->role }}.
</x-app-layout>
