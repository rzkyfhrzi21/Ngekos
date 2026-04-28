<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\{BoardingHouseRepositoryInterface, CategoryRepositoryInterface, CityRepositoryInterface, TransactionRepositoryInterface};
use App\Repositories\{BoardingHouseRepository, CategoryRepository, CityRepository, TransactionRepository};

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
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
