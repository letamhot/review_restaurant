<?php

namespace App\Providers;

use App\Repositories\RoleRepository;
use App\Repositories\Implement\RoleRepositoryImpl;
use App\Services\RoleService;
use App\Services\Implement\RoleServiceImpl;
use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(
            RoleRepository::class,
            RoleRepositoryImpl::class
        );

        $this->app->singleton(
            RoleService::class,
            RoleServiceImpl::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }
}
