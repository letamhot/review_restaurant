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
        return $this->getPostModel()::whereId($id)->approved(true)->with('tag')->firstOrFail();
    }

    public function getRandomPost($number)
    {
        return $this->getPostModel()::approved(true)->take($number)->inRandomOrder()->get()->unique();
    }

    public function getLatestPost($number)
    {
        $posts = $this->getPostModel()::latest()->approved(true)
            ->withCount('likers')
            ->take($number)->get();

        foreach ($posts as $post) {
            $post->user_name = implode('', $post->user()->pluck('name')->toArray());
            $post->user_avatar = implode('', $post->user()->pluck('avatar')->toArray());
            $allPostComment = \risul\LaravelLikeComment\Models\Comment::where('item_id', $post->id)->count();
            $post->totalComment = $allPostComment;
        }
        return $posts;
    }

    public function getPostsByCategory($category_id)
    {
        return $this->getPostModel()::latest()->approved(true)->whereCategoryId($category_id)->get();
    }

    public function getTopReactPost($days, $number, $sort_by = 'desc')
    {
        $posts = $this->getPostModel()::lastDays($days)->approved(true)
            ->withCount('likers')
            ->withCount('favoriters')
            ->orderBy('likers_count', $sort_by)
            ->orderBy('favoriters_count', $sort_by)
            ->orderBy('created_at', $sort_by)
            ->take($number)
            ->get();

        foreach ($posts as $post) {
            $post->user_name = implode('', $post->user()->pluck('name')->toArray());
            $post->user_avatar = implode('', $post->user()->pluck('avatar')->toArray());
            $allPostComment = \risul\LaravelLikeComment\Models\Comment::where('item_id', $post->id)->count();
            $post->totalComment = $allPostComment;
        }
        return $posts;
    }

    public function getAllBookmarked($user)
    {
        return $this->getPostModel()::approved(true)
            ->whereReactedBy($user, 'Star')
            ->get();
    }
}
