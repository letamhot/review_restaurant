<?php

namespace App\ViewComposers;

use App\Services\ArticleService;
use App\Services\CategoryService;
use App\Services\TagService;
use Illuminate\View\View;

class SideBarComposer
{

    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function compose(View $view)
    {
        /**
         * Bind data to the view.
         *
         * @param View $view
         */

        $random_posts = $this->articleService->getRandomPost(4);

        $view->with(['random_posts' => $random_posts]);
    }
}
