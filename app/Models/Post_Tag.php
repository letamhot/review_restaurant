<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post_Tag extends Model
{
    protected $table = 'post_tag';

    // public function post()
    // {
    //     return $this->belongsTo(Post::class, 'post_id', 'id');
    // }

    // public function tag()
    // {
    //     return $this->belongsTo(Tag::class, 'tag_id', 'id');
    // }
}