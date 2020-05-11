<?php

namespace App\Repositories\Eloquent;

use App\Repositories\BaseRepository;

abstract class EloquentRepository implements BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make($this->getModel());
    }

    public function getAll($type)
    {
        switch ($type) {
            case false:
                return $this->model->onlyTrashed()->get();

                break;
            case true:
                return $this->model->withTrashed()->get();

                break;
            default:
                return $this->model->all();

                break;
        }
    }

    public function getAllWithTrashed()
    {
        return $this->model->withTrashed()->get();
    }

    public function getAllOnlyTrashed()
    {
        return $this->model->onlyTrashed()->get();
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findByIdWithTrashed($id)
    {
        return $this->model->withTrashed()->findOrFail($id);
    }

    public function findByIdOnlyTrashed($id)
    {
        return $this->model->onlyTrashed()->findOrFail($id);
    }

    public function create($request)
    {
        try {
            return $this->model->create($request);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function update($request, $object)
    {
        try {
            $object->update($request);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function destroy($object)
    {
        try {
            $object->delete();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function forceDestroy($object)
    {
        try {
            $object->forceDelete();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function restoreSoftDelete($object)
    {
        return $this->findByIdOnlyTrashed($object)->restore();
    }

    public function permanentDestroySoftDeleted($object)
    {
        $result = $this->findByIdOnlyTrashed($object);

        return $this->forceDestroy($result);
    }
}
