<?php

namespace App\Services\Implement;

use App\Repositories\PostRepository;
use App\Services\PostService;

class PostServiceImpl extends BaseServiceImpl implements PostService
{
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModelRepository()
    {
        return PostRepository::class;

    }

    public function getAllCategory()
    {
        return app()->make($this->getModelRepository())->getAllCategory();
    }
}