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

    public function ajaxIndex($request)
    {
        return $this->makeRepo()->ajaxIndex($request);
    }

    public function ajaxEdit($id)
    {
        /*
        try {
            return $this->makeRepo()->ajaxEdit($id);
        } catch (\Exception $e) {
            return null;
        }
        */
        return $this->makeRepo()->ajaxEdit($id);
    }

    public function ajaxUpdate($request, $id)
    {
        return $this->makeRepo()->ajaxUpdate($request, $id);
    }

    public function ajaxStore($request)
    {
        return $this->makeRepo()->ajaxStore($request);
    }

    public function ajaxDelete($id)
    {
        return $this->makeRepo()->ajaxDelete($id);
    }

    protected function makeRepo()
    {
        return app()->make($this->getModelRepository());
    }
}
