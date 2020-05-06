<?php

namespace App\Services\Implement;

use App\Repositories\CategoryRepository;
use App\Services\CategoryService;

class CategoryServiceImpl extends BaseServiceImpl implements CategoryService
{
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModelRepository()
    {
        return CategoryRepository::class;
    }
}
