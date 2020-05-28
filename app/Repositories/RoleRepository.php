<?php

namespace App\Repositories;

interface RoleRepository extends BaseRepository
{
    public function ajaxStore($request);

    public function roleStatistic();
}
