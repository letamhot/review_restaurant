<?php

namespace App\Providers;

use App\Repositories\PostRepository;
use App\Repositories\Implement\PostRepositoryImpl;
use App\Services\PostService;
use App\Services\Implement\PostServiceImpl;
use Illuminate\Support\ServiceProvider;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(
            PostRepository::class,
            PostRepositoryImpl::class
        );

        $this->app->singleton(
            PostService::class,
            PostServiceImpl::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }
}
