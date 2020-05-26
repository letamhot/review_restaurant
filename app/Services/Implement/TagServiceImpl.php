<?php

namespace App\Services\Implement;

use App\Repositories\TagRepository;
use App\Services\TagService;

class TagServiceImpl extends BaseServiceImpl implements TagService
{
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModelRepository()
    {
        return TagRepository::class;
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
