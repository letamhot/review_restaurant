<?php

namespace App\Providers;

use App\Repositories\ArticleRepository;
use App\Repositories\Implement\ArticleRepositoryImpl;
use App\Services\ArticleService;
use App\Services\Implement\ArticleServiceImpl;
use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            ArticleRepository::class,
            ArticleRepositoryImpl::class
        );

        $this->app->singleton(
            ArticleService::class,
            ArticleServiceImpl::class
        );
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
