<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpeciesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Ai\Agents\PetCareSugest;
use Illuminate\Support\Str;

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);

Route::middleware(['auth', 'user_is:admin,employee'])->group(function () {
    Route::resource('/users', UserController::class);
    Route::resource('/animals', AnimalController::class);
    Route::post('/animals/reset', [AnimalController::class, 'reset'])->name('animals.reset');
});

Route::middleware(['auth', 'user_is:admin'])->group(function () {
    Route::resource('species', SpeciesController::class);
    Route::post('/species/reset', [SpeciesController::class, 'reset'])->name('species.reset');
});

Route::get('/dashboard', function () {
    $mensaje = app(PetCareSugest::class)->prompt(
        "Eres el vendedor llamado Emilio de la veterinaria Pet's Care. Saluda al cliente que está logeado y pregúntale cómo está su mascota. NO OLVIDES OFRECER PRODUCTOS O SERVICIOS DE LA VETERINARIA!");
    $mensaje = Str::markdown($mensaje ?? 'No se pudo generar el mensaje.');
    return view('dashboard', compact('mensaje'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
