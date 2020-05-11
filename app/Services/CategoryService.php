<?php

namespace App\Services;

interface CategoryService extends BaseService
{
    public function ajaxIndex($request);

    public function ajaxEdit($id);

    public function ajaxUpdate($request, $id);

    public function ajaxStore($request);

    public function ajaxDelete($id);
}
