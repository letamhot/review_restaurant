<?php

namespace App\Providers;

use App\Repositories\TagRepository;
use App\Repositories\Implement\TagRepositoryImpl;
use App\Services\TagService;
use App\Services\Implement\TagServiceImpl;
use Illuminate\Support\ServiceProvider;

class TagServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(
            TagRepository::class,
            TagRepositoryImpl::class
        );

        $this->app->singleton(
            TagService::class,
            TagServiceImpl::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    { }
}
