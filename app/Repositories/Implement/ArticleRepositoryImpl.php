<?php

namespace App\Repositories\Implement;

use App\Models\Post;
use App\Repositories\ArticleRepository;
use App\Repositories\Eloquent\EloquentRepository;

class ArticleRepositoryImpl extends EloquentRepository implements ArticleRepository
{
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModel()
    {
        return Post::class;
    }

    /**
     * Make Model class.
     */
    protected function getPostModel()
    {
        return app()->make($this->getModel());
    }

    public function getDetail($id)
    {
        // dd($this->getPostModel());
        // return post has been approved or abort-404
        return $this->getPostModel()::whereId($id)->approved(true)->firstOrFail();
    }

    public function getRandomPost($number)
    {
        return $this->getPostModel()::approved(true)->take($number)->inRandomOrder()->get()->unique();
    }

    public function getLatestPost($number)
    {
        return $this->getPostModel()::latest()->approved(true)->take($number)->get();
    }

    public function getPostsByCategory($category_id)
    {
        return $this->getPostModel()::latest()->approved(true)->whereCategoryId($category_id)->get();
    }

    public function getTopReactPost($days, $number, $sort_by = 'desc')
    {
        return $this->getPostModel()::lastDays($days)->approved(true)
            ->joinReactionTotal()
            ->orderBy('reaction_total_weight', $sort_by)
            ->take($number)
            ->get();
    }

    public function getAllBookmarked($user)
    {
        return $this->getPostModel()::approved(true)
            ->whereReactedBy($user, 'Star')
            ->get();
    }
}
