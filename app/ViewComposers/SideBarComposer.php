<?php

namespace App\ViewComposers;

use App\Services\ArticleService;
use App\Services\CategoryService;
use App\Services\TagService;
use Illuminate\View\View;

class SideBarComposer
{

    protected $articleService;
    protected $categoryService;
    protected $tagService;

    public function __construct(ArticleService $articleService, CategoryService $categoryService, TagService $tagService)
    {
        $this->articleService = $articleService;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
    }

    public function compose(View $view)
    {
        /**
         * Bind data to the view.
         *
         * @param View $view
         */

        $randomPosts = $this->articleService->getRandomPost(4);
        $categories = $this->categoryService->getAll();
        $tags = $this->tagService->getAll();

        $view->with(['randomPosts' => $randomPosts, 'categories' => $categories, 'tags' => $tags]);
    }
}
