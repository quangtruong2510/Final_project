<?php

namespace App\Http\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            'App\Http\Repositories\UserRepository\UserRepositoryInterface',
            'App\Http\Repositories\UserRepository\UserRepository',
        );
        $this->app->bind(
            'App\Http\Repositories\CategoryRepository\CategoryRepositoryInterface',
            'App\Http\Repositories\CategoryRepository\CategoryRepository'
        );
        $this->app->bind(
            'App\Http\Repositories\DestinationRepository\DestinationRepositoryInterface',
            'App\Http\Repositories\DestinationRepository\DestinationRepository'
        );
    }
}