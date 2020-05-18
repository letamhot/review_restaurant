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
    public function showdeleted()
    {

        return app()->make($this->getModelRepository())->showdeleted();
    }
    public function restoreDelete($id)
    {

        return app()->make($this->getModelRepository())->restoreDelete($id);
    }

    public function ajaxIndex($request)
    {

        return app()->make($this->getModelRepository())->ajaxIndex($request);
    }
    public function ajaxStore($request)
    {

        return app()->make($this->getModelRepository())->ajaxStore($request);
    }
    public function ajaxUpdate($id)
    {

        return app()->make($this->getModelRepository())->ajaxUpdate($id);
    }
    public function ajaxDestroy($id)
    {
        return app()->make($this->getModelRepository())->ajaxDestroy($id);
    }
}
