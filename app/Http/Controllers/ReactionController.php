<?php

namespace App\Http\Controllers;

use App\Services\ReactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    protected $reactionService;

    public function __construct(ReactionService $reactionService)
    {
        $this->reactionService = $reactionService;
    }

    /**
     * React as Like or Favorite
     */
    public function react(Request $request)
    {
        return $this->reactionService->react($request);
    }

    /**
     * get bookmark list of current auth user
     */
    public function getUserFavoriteList()
    {
        $user = Auth::user();
        return $this->reactionService->getUserFavoriteList($user);
    }
}
