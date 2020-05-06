<?php

namespace App\Services;

interface BaseService
{
    public function getAll();

    public function findByID($id);

    public function create($request);

    public function update($request, $object);

    public function destroy($id);

    public function forceDestroy($id);
}
