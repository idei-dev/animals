<?php

namespace App\Providers;

use App\Contracts\AnimalServiceInterface;
use App\Contracts\SpeciesServiceInterface;
use App\Contracts\UserServiceInterface;
use App\Services\SQLAnimalService;
use App\Services\SQLiteSpeciesService;
use App\Services\SQLiteUserService;
use App\Contracts\AnimalOwnerServiceInterface;
use App\Services\SQLiteAnimalOwnerService;
use App\Contracts\AnimalEventServiceInterface;
use App\Services\SQLiteAnimalEventService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            UserServiceInterface::class,
            SQLiteUserService::class
        );

        $this->app->singleton(
            AnimalServiceInterface::class,
            SQLAnimalService::class
        );

        $this->app->singleton(
            SpeciesServiceInterface::class,
            SQLiteSpeciesService::class
        );

        $this->app->bind(
            AnimalOwnerServiceInterface::class,
            SQLiteAnimalOwnerService::class
        );

        $this->app->bind(
            AnimalEventServiceInterface::class,
            SQLiteAnimalEventService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('role', function (...$roles) {
            return Auth::check() && \in_array(Auth::user()->role, $roles);
        });
    }
}
