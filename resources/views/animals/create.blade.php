@extends('layouts.animals')

@section('content')
    <h1 class="text-2xl font-bold text-white mb-6">Agregar Animal</h1>

    <form action="{{ url('/animals') }}" method="POST" class="bg-slate-800 rounded-lg shadow p-6 max-w-md text-white">
        @csrf

        <label for="name" class="block text-sm font-medium mb-1">Nombre</label>
        <input type="text" id="name" name="name"
               class="w-full border-gray-300 rounded-md shadow-sm mb-4 p-2 border text-black">

        <label for="species" class="block text-sm font-medium mb-1">Especie</label>
        <input type="text" id="species" name="species"
               class="w-full border-gray-300 rounded-md shadow-sm mb-4 p-2 border text-black">

        <label for="age" class="block text-sm font-medium mb-1">Edad</label>
        <input type="number" id="age" name="age"
               class="w-full border-gray-300 rounded-md shadow-sm mb-4 p-2 border text-black">

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Guardar
        </button>
    </form>
@endsection