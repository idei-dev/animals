<x-layout>
    <x-slot:title>Detalle: {{ $species['name'] }}</x-slot:title>
    <div class="max-w-md mx-auto">
        <a href="{{ route('species.index') }}" class="text-sm text-indigo-600 hover:underline">← Volver</a>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 mt-4">
            <div class="flex justify-between items-center pb-3 border-b">
                <span class="font-mono text-xs text-slate-500">ID: #{{ $species['id'] }}</span>
                <span class="text-xs px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 font-semibold">Especie Maestra</span>
            </div>
            <div class="py-6">
                <h1 class="text-2xl font-bold text-slate-900">{{ $species['name'] }}</h1>
                <p class="text-sm text-slate-400 mt-1">Recurso listo para asociarse con múltiples animales.</p>
            </div>
            <div class="flex justify-between items-center pt-3 border-t">
                <a href="{{ route('species.edit', $species['id']) }}" class="text-sm text-indigo-600 font-medium hover:underline">Editar</a>
                <form action="{{ route('species.destroy', $species['id']) }}" method="POST" onsubmit="return confirm('¿Eliminar?');">
                    @csrf @method('DELETE')
                    <button class="text-sm text-rose-600 font-medium hover:underline">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>