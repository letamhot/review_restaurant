<?php

namespace App\Repositories;

interface CategoryRepository extends BaseRepository
{
    public function ajaxStore($request);

    public function getAllAJAX();

    public function getAllOnlyTrashedAJAX();

    public function categoryStatistic();
}
