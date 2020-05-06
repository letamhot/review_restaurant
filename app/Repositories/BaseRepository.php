<?php

namespace App\Repositories;

interface BaseRepository
{
    public function getAll();

    public function findByID($id);

    public function create($request);

    public function update($request, $object);

    public function destroy($object);

    public function forceDestroy($object);
}
