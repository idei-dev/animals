<?php

namespace App\Providers;

use App\Contracts\AnimalServiceInterface;
use App\Contracts\SpeciesServiceInterface;
use App\Services\SQLAnimalService;
use App\Services\SQLiteSpeciesService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            AnimalServiceInterface::class,
            SQLAnimalService::class
        );

        $this->app->singleton(
            SpeciesServiceInterface::class,
            SQLiteSpeciesService::class
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
