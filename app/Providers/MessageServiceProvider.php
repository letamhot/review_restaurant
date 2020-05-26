<?php

namespace App\Providers;

use App\Repositories\MessageRepository;
use App\Repositories\Implement\MessageRepositoryImpl;
use App\Services\MessageService;
use App\Services\Implement\MessageServiceImpl;
use Illuminate\Support\ServiceProvider;

class MessageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(
            MessageRepository::class,
            MessageRepositoryImpl::class
        );

        $this->app->singleton(
            MessageService::class,
            MessageServiceImpl::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    { }
}
