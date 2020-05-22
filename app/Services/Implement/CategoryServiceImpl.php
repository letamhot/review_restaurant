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

    public function ajaxStore($request)
    {
        return $this->makeRepo()->ajaxStore($request);
    }

    public function getAllAJAX()
    {
        return $this->makeRepo()->getAllAJAX();
    }

    public function getAllOnlyTrashedAJAX()
    {
        return $this->makeRepo()->getAllOnlyTrashedAJAX();
    }

    /**
     * Make Model Class.
     */
    protected function makeRepo()
    {
        return app()->make($this->getModelRepository());
    }
}
