<?php

namespace App\Services;

interface ArticleService extends BaseService
{
    public function showDetail($id);

    public function getRandomPost($number);

    public function getLatestPost($number);

    public function getTopReactPost($days, $number, $sort_by);

    public function getAllBookmarked($user);
}
