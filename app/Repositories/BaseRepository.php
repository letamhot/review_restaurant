<?php

namespace App\Repositories;

interface BaseRepository
{
    public function getAll($type);

    public function getAllWithTrashed();

    public function getAllOnlyTrashed();

    public function findById($id);

    public function findByIdWithTrashed($id);

    public function findByIdOnlyTrashed($id);

    public function create($request);

    public function update($request, $object);

    public function destroy($object);

    public function forceDestroy($object);

    public function restoreSoftDelete($object);

    public function permanentDestroySoftDeleted($object);
}
