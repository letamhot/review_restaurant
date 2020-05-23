<?php

namespace App\Services;

interface TagService extends BaseService
{
    public function ajaxStore($request);

    public function getAllAJAX();

    public function getAllOnlyTrashedAJAX();
}
