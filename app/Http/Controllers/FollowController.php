<?php

namespace App\Http\Controllers;

use App\Services\FollowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    protected $followService;

    public function __construct(FollowService $followService)
    {
        $this->followService = $followService;
    }

    /**
     * Current Auth User follow other user
     * Input: ID of user will be following
     */
    public function follow(Request $request)
    {
        return $this->followService->follow($request);
    }
    /**
     * Get followings & followers list
     */
    public function getUserFollowingInfo()
    {
        try {
            $user = Auth::user();
            return $this->followService->getUserFollowingInfo($user);
        } catch (\Exception $e) {
            // return message info
            return null;
        }
    }
}
