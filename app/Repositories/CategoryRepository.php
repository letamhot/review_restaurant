<?php

namespace App\Repositories;

interface CategoryRepository extends BaseRepository
{
    public function ajaxStore($request);
}
