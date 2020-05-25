<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Implement\PostRepositoryImpl;
use App\Repositories\TagRepository;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Illuminate\Support\Facades\Auth;

class ReactionService
{
    protected $postRepository;
    protected $tagRepository;
    protected $reactionLikeType;
    protected $reactionStarType;
    protected $reactionFavoriteType;
    public function __construct(PostRepositoryImpl $postRepository, TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
        $this->postRepository = $postRepository;
        $this->reactionLikeType = ReactionType::fromName('Like');
        $this->reactionStarType = ReactionType::fromName('Star'); // bookmark
        $this->reactionFavoriteType = ReactionType::fromName('Heart'); // follow Tag
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

            $reactionType = ReactionType::fromName($request->reactionType);

            $reacter = $user->getLoveReacter();
            $reactant = $post->getLoveReactant();

            if ($reacter->hasReactedTo($reactant, $reactionType)) {
                $reacter->unreactTo($reactant, $reactionType);
            } else {
                $reacter->reactTo($reactant, $reactionType);
            }

            return response()->json([
                'status' => [
                    'like' => $reacter->hasReactedTo($reactant, $this->reactionLikeType),
                    'star' => $reacter->hasReactedTo($reactant, $this->reactionStarType),
                ],
                'totals' => [
                    'likes' => $reactant->getReactionCounterOfType($this->reactionLikeType)->getCount(),
                    'stars' => $reactant->getReactionCounterOfType($this->reactionStarType)->getCount(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return $this->msgError($e->getMessage());
        }
    }

    public function followTag($request)
    {
        try {
            $user = Auth::user();
            $tag = $this->tagRepository->findById($request->tagId);

            $reactionType = ReactionType::fromName($request->reactionType);

            $reacter = $user->getLoveReacter();
            $reactant = $tag->getLoveReactant();

            if ($reacter->hasReactedTo($reactant, $reactionType)) {
                $reacter->unreactTo($reactant, $reactionType);
            } else {
                $reacter->reactTo($reactant, $reactionType);
            }

            return response()->json([
                'status' => [
                    'heart' => $reacter->hasReactedTo($reactant, $this->reactionFavoriteType),

                ],
                'totals' => [
                    'hearts' => $reactant->getReactionCounterOfType($this->reactionFavoriteType)->getCount(),
                ],
            ], 200);
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
            $reactant = $post->getLoveReactant();

            $totalReaction = [];
            $totalReaction['totalLike'] = $reactant->getReactionCounterOfType($this->reactionLikeType)->getCount();
            $totalReaction['totalStar'] = $reactant->getReactionCounterOfType($this->reactionStarType)->getCount();
            return $totalReaction;

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Check auth user has reacted to certain model
     *
     */
    public function isUserReacted($post)
    {
        try {
            $reactant = $post->getLoveReactant();
            $reacter = Auth::user()->getLoveReacter();
            $reactionResult = [];
            $reactionResult['isLiked'] = $reacter->hasReactedTo($reactant, $this->reactionLikeType);
            $reactionResult['isStarred'] = $reacter->hasReactedTo($reactant, $this->reactionStarType);

            return $reactionResult;

        } catch (\Exception $e) {
            return null;
        }
    }

    protected function msgError($msg = null)
    {
        return response()->json([
            'message' => 'Some thing went wrong!',
            'errors' => $msg,
        ], 204);
    }
}
