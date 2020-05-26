<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class FollowService
{
    protected $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function follow($request)
    {
        try {
            $user1 = Auth::user();
            $user2 = $this->userRepository->findById($request->userId);

            if ($user1->isFollowing($user2)) {
                $user1->unfollow($user2);
            } else {
                $user1->follow($user2);
            }
            
            return response()->json([
                    'isFollowing' => $user1->isFollowing($user2),
                ], 200);
        } catch (\Exception $e) {
            return $this->msgError($e->getMessage());
        }
    }

    public function getUserFollowingInfo($user)
    {
        try {
            $followings = $user->followings()->get();
            $followers = $user->followers()->get();
            $userFollowingInfo = [];
            
            $userFollowingInfo['totalFollowing'] = $followings->count();
            $userFollowingInfo['totalFollower'] = $followers->count();
            $userFollowingInfo['followingsList'] = $followings;
            $userFollowingInfo['followersList'] = $followers;

            return $userFollowingInfo;

            // return response()->json($userFollowingInfo, 200);
        } catch (\Exception $e) {
            return $this->msgError($e->getMessage());
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
