<?php

namespace App\Repositories;

interface TagRepository extends BaseRepository
{
    public function ajaxStore($request);

    public function getAllAJAX();

    public function getAllOnlyTrashedAJAX();
}
