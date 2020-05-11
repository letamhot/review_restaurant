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

    public function getAll($type = null)
    {
        return $this->modelRepository->getAll($type);
    }

    public function getAllWithTrashed()
    {
        return $this->modelRepository->getAllWithTrashed();
    }

    public function getAllOnlyTrashed()
    {
        return $this->modelRepository->getAllOnlyTrashed();
    }

    public function findById($id)
    {
        return $this->modelRepository->findById($id);
    }

    public function findByIdWithTrashed($id)
    {
        return $this->modelRepository->findByIdWithTrashed($id);
    }

    public function findByIdOnlyTrashed($id)
    {
        return $this->modelRepository->findByIdOnlyTrashed($id);
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

    public function restoreSoftDelete($object)
    {
        return $this->modelRepository->restoreSoftDelete($object);
    }

    public function permanentDestroySoftDeleted($object)
    {
        return $this->modelRepository->permanentDestroySoftDeleted($object);
    }
}
