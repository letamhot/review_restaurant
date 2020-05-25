<?php

namespace App\Services\Implement;

use App\Repositories\ArticleRepository;
use App\Services\ArticleService;
use App\Services\ReactionService;
use Illuminate\Support\Facades\Auth;

class ArticleServiceImpl extends BaseServiceImpl implements ArticleService
{
    protected $reactionService;

    public function __construct(ReactionService $reactionService)
    {
        $this->reactionService = $reactionService;

    }
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModelRepository()
    {
        return ArticleRepository::class;
    }

    public function showDetail($id)
    {
        // get post instance
        $post = $this->makeRepo()->getDetail($id);
        if (Auth::user()) {
            // get total reaction of this post
            $totalReaction = $this->reactionService->getTotalReactionOneReactant($post);

            $post->totalLike = $totalReaction['totalLike'];
            $post->totalStar = $totalReaction['totalStar'];
        }
        $allPostComment = \risul\LaravelLikeComment\Models\Comment::where('item_id', $post->id)->get()->count();
        $post->totalComment = $allPostComment;
        $post->tag = $post->tag()->pluck('name')->toArray(); // array list of tag name
        $post->author = implode('', $post->user()->pluck('name')->toArray()); // convert array to string

        return $post;

        // return view('front-end.landingpage', compact('post'));
    }

    public function getRandomPost($number)
    {
        return $this->makeRepo()->getRandomPost($number);
    }

    public function getLatestPost($number)
    {
        return $this->makeRepo()->getLatestPost($number);
    }

    public function getTopReactPost($days, $number, $sort_by)
    {
        return $this->makeRepo()->getTopReactPost($days, $number, $sort_by);
    }

    public function getAllBookmarked($user)
    {
        return $this->makeRepo()->getAllBookmarked($user);
    }

    /**
     * Make Model Class.
     */
    protected function makeRepo()
    {
        return app()->make($this->getModelRepository());
    }

}
