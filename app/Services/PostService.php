<?php

namespace App\Services;

interface PostService extends BaseService
{
public function getAllCategory();
public function getAllTag();
public function getDate();
public function getMonth();

}