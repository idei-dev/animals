<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnimalController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/usuarios', [UserController::class, 'index']); 

// Route::get('home', function () {
//     return view('home');
// })->name ('home');

// group routes for animals
Route::group(['prefix' => 'animals'], function () {
    Route::get('/', [AnimalController::class, 'index'])->name('animals.index');
    Route::get('/create', [AnimalController::class, 'create'])->name('animals.create');
    Route::post('/', [AnimalController::class, 'store'])->name('animals.store');
    Route::get('/{id}/edit', [AnimalController::class, 'edit'])->name('animals.edit');
    Route::put('/{id}', [AnimalController::class, 'update'])->name('animals.update');
    Route::delete('/{id}', [AnimalController::class, 'destroy'])->name('animals.destroy');
});

// // READ - Listar todos los animales
// Route::get('/animals', [AnimalController::class, 'index']);

// // CREATE - Mostrar formulario para crear uno nuevo
// Route::get('/animals/create', [AnimalController::class, 'create']);

// // CREATE - Procesar el guardado del nuevo animal
// Route::post('/animals', [AnimalController::class, 'store']);

// // UPDATE - Mostrar formulario de edición
// Route::get('/animals/{id}/edit', [AnimalController::class, 'edit']);

// // UPDATE - Procesar la actualización
// Route::put('/animals/{id}', [AnimalController::class, 'update']);

// // DELETE - Procesar la eliminación
// Route::delete('/animals/{id}', [AnimalController::class, 'destroy']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
