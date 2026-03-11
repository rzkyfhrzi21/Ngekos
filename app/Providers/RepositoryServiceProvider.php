<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\{BoardingHouseRepositoryInterface, CategoryRepositoryInterface, CityRepositoryInterface};
use App\Repositories\{BoardingHouseRepository, CategoryRepository, CityRepository};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(BoardingHouseRepositoryInterface::class, BoardingHouseRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
