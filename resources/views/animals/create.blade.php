@extends('layouts.animals')

@section('content')
    <h1 class="text-2xl font-bold text-white mb-6">Agregar Animal</h1>

    <form action="{{ route('animals.store') }}" method="POST" class="bg-slate-800 rounded-lg shadow p-6 max-w-md text-white">
        @csrf

        {{-- 1. (Opcional) Bloque al inicio del formulario con todos los errores --}}
        <!-- @if ($errors->any())
            <div class="mb-4 rounded-md border border-red-500 bg-red-500/10 p-3 text-sm text-red-300">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif -->

        {{-- Campo: Nombre --}}
        <label for="name" class="block text-sm font-medium mb-1">Nombre</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}"
               class="w-full border-gray-300 rounded-md shadow-sm p-2 border text-black">
        @error('name')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror

        {{-- Campo: Especie --}}
        <label for="species" class="block text-sm font-medium mt-4 mb-1">Especie</label>
        <input type="text" id="species" name="species" value="{{ old('species') }}"
               class="w-full border-gray-300 rounded-md shadow-sm p-2 border text-black">
        @error('species')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror

        {{-- Campo: Edad --}}
        <label for="age" class="block text-sm font-medium mt-4 mb-1">Edad</label>
        <input type="number" id="age" name="age" value="{{ old('age') }}"
               class="w-full border-gray-300 rounded-md shadow-sm p-2 border text-black">
        @error('age')
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror

        <button type="submit" class="mt-6 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Guardar
        </button>
    </form>
@endsection