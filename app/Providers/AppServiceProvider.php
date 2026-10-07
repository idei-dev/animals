<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Contracts\AnimalServiceInterface::class,
            \App\Services\SQLAnimalService::class
        );

        // Paso 3: Vinculamos la interfaz SpeciesServiceInterface con la implementación SpeciesMockService
        $this->app->singleton(
            \App\Contracts\SpeciesServiceInterface::class,
            \App\Services\SpeciesMockService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
