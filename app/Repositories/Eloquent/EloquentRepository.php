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

    public function getAll()
    {
        return $this->model->all();
    }

    public function findByID($id)
    {
        return $this->model->findOrFail($id);
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
}
