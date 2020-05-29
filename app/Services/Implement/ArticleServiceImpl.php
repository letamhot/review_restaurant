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
        $user = Auth::user();
        if ($user) {
            // get total reaction of this post
            $totalReaction = $this->reactionService->getTotalReactionOneReactant($post);

            $post->totalLike = $totalReaction['totalLikes'];
            $post->totalStar = $totalReaction['totalFavorites'];

            // can check through AJAX call isUserReacted() method
            $user_reaction = $this->reactionService->isUserReacted($user, $post);
            $post->isUserLiked = $user_reaction['isLiked'];
            $post->isUserFavorited = $user_reaction['isFavorited'];
        }
        $allPostComment = \risul\LaravelLikeComment\Models\Comment::where('item_id', $post->id)->get()->count();
        $post->totalComment = $allPostComment;
        // $post->tag = $post->tag()->pluck('name')->toArray(); // array list of tag name
        $post->author = implode('', $post->user()->pluck('name')->toArray()); // convert array to string

        return $post;
    }

    public function getRandomPost($number)
    {
        return $this->makeRepo()->getRandomPost($number);
    }

    public function getLatestPost($number)
    {
        $latestPosts =  $this->makeRepo()->getLatestPost($number);
        return response()->json($latestPosts);
    }

    public function getPostsByCategory($category_id)
    {
        $posts = $this->makeRepo()->getPostsByCategory($category_id);
        return response()->json($posts);
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
