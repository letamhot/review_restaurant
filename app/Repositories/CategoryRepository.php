<?php

namespace App\Repositories;

interface CategoryRepository extends BaseRepository
{
    public function ajaxIndex($request);

    public function ajaxEdit($id);

    public function ajaxUpdate($request, $id);

    public function ajaxStore($request);

    public function ajaxDelete($id);
}
