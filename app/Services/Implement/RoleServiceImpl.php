<?php

namespace App\Services\Implement;

use App\Repositories\RoleRepository;
use App\Services\RoleService;

class RoleServiceImpl extends BaseServiceImpl implements RoleService
{
    /**
     * Certain model.
     *
     * @return string
     */
    public function getModelRepository()
    {
        return RoleRepository::class;
    }

    public function ajaxStore($request)
    {
        return $this->makeRepo()->ajaxStore($request);
    }

    /**
     * Make Model Class.
     */
    protected function makeRepo()
    {
        return app()->make($this->getModelRepository());
    }
}
