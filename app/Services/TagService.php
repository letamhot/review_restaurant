<?php

namespace App\Services;

interface TagService extends BaseService
{
    public function showdeleted();
    public function restoreDelete($id);
    public function ajaxIndex($request);
    public function ajaxStore($request);
    public function ajaxUpdate($id);
    public function ajaxDestroy($id);
}
