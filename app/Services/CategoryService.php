<?php

namespace App\Services;

interface CategoryService extends BaseService
{
    public function ajaxStore($request);

    public function getAllAJAX();

    public function getAllAJAX();
    public function getAllOnlyTrashedAJAX();
}
