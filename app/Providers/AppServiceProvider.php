<?php

namespace App\Providers;

use App\Models\Tag;
use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer([
            'front-end.tagdetail', 'front-end.categories', 'front-end.landing-page', 'front-end.latest-news', 'front-end.tagdetail', 'front-end.post_user'
        ], function ($view) {
            $tags = Tag::all();
            $categories = Category::all();
            $newsmonth = Post::whereMonth('created_at', '=', Carbon::now()->month)->take(3)->get();
            $newsweek = Post::where('created_at', '>=', Carbon::now()->subdays(7))->take(3)->get();
            $newsday = Post::where('created_at', '>=', Carbon::now()->subdays(1))->take(3)->get();
            $view->with([
                'tags' => $tags, 'newsmonth' => $newsmonth, 'newsweek' => $newsweek, 'newsday' => $newsday, 'categories' => $categories
            ]);
        });
    }
}
