<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\SpeciesController;

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);

// Route::get('/usuarios', [UserController::class, 'index']);

Route::resource('/animals', AnimalController::class);
Route::post('/animals/reset', [AnimalController::class, 'reset'])->name('animals.reset');
Route::resource('species', SpeciesController::class);
Route::post('/species/reset', [SpeciesController::class, 'reset'])->name('species.reset');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
