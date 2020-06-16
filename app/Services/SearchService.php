<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;

class SearchService
{
    protected $postRepository;


    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function search($request)
    {
        $query = $request->input('query');
        if ($query) {
            $posts = $this->postRepository->search($query);
            return view('front-end/search', compact('posts'));
        }

        return redirect()->to('/');
    }
}
