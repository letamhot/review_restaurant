<?php
namespace App\Repositories;

interface ArticleRepository extends BaseRepository
{
    public function getDetail($id);

    public function getRandomPost($number);

    public function getLatestPost($number);

    public function getTopReactPost($days, $number, $sort_by);

    public function getAllBookmarked($user);
}
