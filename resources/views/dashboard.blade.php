<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Inicio
        </h2>
    </x-slot>

    @role('customer')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {!! $mensaje ?? 'Bienvenido a la tienda de mascotas. Aquí encontrarás todo lo que necesitas para cuidar y consentir a tus amigos peludos.' !!}
                </div>
            </div>
        </div>
    </div>
    @endrole
</x-app-layout>
