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
        $this->app->singleton(
            \App\Contracts\AnimalServiceInterface::class,
            \App\Services\SQLAnimalService::class
        );

        $this->app->singleton(
            \App\Contracts\SpeciesServiceInterface::class,
            \App\Services\SQLiteSpeciesService::class
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
