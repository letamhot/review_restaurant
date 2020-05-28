<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Implement\PostRepositoryImpl;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use Illuminate\Support\Facades\Auth;

class ReactionService
{
    protected $postRepository;
    protected $tagRepository;

    public function __construct(PostRepository $postRepository, TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * React to Post (like or favorite/bookmark).
     *
     * @param $reaction
     * @param mixed $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function react($request)
    {

        try {
            $user = Auth::user();
            $post = $this->postRepository->findById($request->postId);
            $result = [];

            if ($request->reactionType == 'like') {
                if ($user->hasLiked($post)) {
                    $user->toggleLike($post);
                } else {
                    $user->like($post);
                }
                $result = [
                    'type' => 'like',
                    'status' => [
                        'like' => $user->hasLiked($post),
                    ],
                    'totals' => [
                        'likes' => $post->likes()->count(),
                    ],
                ];
            } else if ($request->reactionType == 'star') {
                if ($user->hasFavorited($post)) {
                    $user->toggleFavorite($post);
                } else {
                    $user->favorite($post);
                }
                $result = [
                    'type' => 'favorite',
                    'status' => [
                        'favorite' => $user->hasFavorited($post),
                    ],
                    'totals' => [
                        'favorites' => $post->favorites()->count(),
                    ],
                ];
            }

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return $this->msgError($e->getMessage());
        }
    }

    /**
     * Get total reaction (total like, total bookmark) of specific model (reactant).
     */
    public function getTotalReactionOneReactant($post)
    {
        try {
            $totalReaction = [];

            $totalReaction['totalLikes'] = $post->likers()->count();
            $totalReaction['totalFavorites'] = $post->favoriters()->count();

            return $totalReaction;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Check auth user has reacted to certain model
     *
     */
    public function isUserReacted($user, $post)
    {
        try {
            $reactionResult = [];
            $reactionResult['isLiked'] = $user->hasLiked($post);
            $reactionResult['isFavorited'] = $user->hasFavorited($post);

            return $reactionResult;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get total favorite and favorite list
     */
    public function getUserFavoriteList($user)
    {
        try {
            $favorites  = $user->favorites()->get();
            $userFavoriteList = [];
            $userFavoriteList['totalCount'] = $favorites->count();
            $userFavoriteList['listAll'] = $favorites;

            return $userFavoriteList;

            // return response()->json($userFavoriteList, 200);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Message info to JSON
     */
    protected function msgError($msg = null)
    {
        return response()->json([
            'message' => 'Some thing went wrong!',
            'errors' => $msg,
        ], 204);
    }
}
