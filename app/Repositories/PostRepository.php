<?php

namespace App\Repositories;

interface PostRepository extends BaseRepository
{
    public function getAllCategory();
    public function getAllTag();
    public function status();
    public function check($request, $post);
}