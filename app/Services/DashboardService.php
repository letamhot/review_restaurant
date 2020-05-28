<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Repositories\RoleRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;

class DashboardService
{
    protected $userRepository;
    protected $tagRepository;
    protected $roleRepository;
    protected $categoryRepository;
    protected $postRepository;

    public function __construct(
        UserRepository $userRepository,
        TagRepository $tagRepository,
        RoleRepository $roleRepository,
        CategoryRepository $categoryRepository,
        PostRepository $postRepository
    ) {
        $this->userRepository = $userRepository;
        $this->tagRepository = $tagRepository;
        $this->roleRepository = $roleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }

    public function statistic()
    {
        $users = $this->userRepository->userStatistic();
        $tags = $this->tagRepository->tagStatistic();
        $roles = $this->roleRepository->roleStatistic();
        $categories = $this->categoryRepository->categoryStatistic();
        $posts = $this->postRepository->postStatistic();

        return view('backend.admin.dashboard', compact(['users','tags','roles','categories','posts']));
    }
}
