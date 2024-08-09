<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\RepositoryDesignPattern\BaseRepository;
use App\RepositoryDesignPattern\UserRepository;
use App\RepositoryDesignPattern\Interfaces\BaseInterface;
use App\RepositoryDesignPattern\Interfaces\UserInterface;
use App\RepositoryDesignPattern\VehicleSpecsValuesRepository;
use App\RepositoryDesignPattern\VehicleGeneralSpecsRepository;
use App\RepositoryDesignPattern\Interfaces\VehicleSpecsValuesInterface;
use App\RepositoryDesignPattern\Interfaces\VehicleGeneralSpecsInterface;


class RepositoryDesignPatternServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseInterface::class, BaseRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(VehicleGeneralSpecsInterface::class, VehicleGeneralSpecsRepository::class);
        $this->app->bind(VehicleSpecsValuesInterface::class, VehicleSpecsValuesRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
