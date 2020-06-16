<?php

namespace App\Repositories;

interface PostRepository extends BaseRepository
{
    public function getAllCategory();

    public function getAllTag();

    public function status();

    public function check($request, $post);

    public function postStatistic();

    public function user_post();

    public function search($query);
}
