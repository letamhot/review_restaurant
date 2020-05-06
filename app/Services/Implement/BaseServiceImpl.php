<?php

namespace App\Services\Implement;

use App\Services\BaseService;

abstract class BaseServiceImpl implements BaseService
{
    protected $modelRepository;

    public function __construct()
    {
        $this->setModelRepository();
    }

    abstract public function getModelRepository();

    public function setModelRepository()
    {
        $this->modelRepository = app()->make($this->getModelRepository());
    }

    public function getAll()
    {
        return $this->modelRepository->getAll();
    }

    public function findByID($id)
    {
        return $this->modelRepository->findByID($id);
    }

    public function create($request)
    {
        return $this->modelRepository->create($request);
    }

    public function update($request, $object)
    {
        return $this->modelRepository->update($request, $object);
    }

    public function destroy($id)
    {
        return $this->modelRepository->destroy($id);
    }

    public function forceDestroy($id)
    {
        return $this->modelRepository->forceDestroy($id);
    }
}
