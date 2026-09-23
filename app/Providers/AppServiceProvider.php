<?php

/**
 * Paso 3: El Service Provider (Enseñando a Laravel)
 * Aquí explicas la Inyección de Dependencias y el Contenedor de Servicios (IoC). El controlador
 * va a pedir un AnimalServiceInterface, y tenemos que decirle a Laravel qué entregarle.
 *
 * Lo registramos en app/Providers/AppServiceProvider.php (o uno dedicado):
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\AnimalServiceInterface;
use App\Services\SessionAnimalService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // "Cuando alguien pida la Interfaz, entrégale esta Implementación"
        $this->app->bind(AnimalServiceInterface::class, SessionAnimalService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
