<?php

namespace App\Providers;

use App\ViewComposers\SideBarComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // on specific view with wildcards
        View::composer('front-end.random_posts', SideBarComposer::class);
    }
}
