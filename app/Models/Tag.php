<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    // protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'name', 'slug',
    ];

    public function post()
    {
        return $this->belongsToMany(Post::class, 'post_tag', 'tag_id', 'post_id')->withTimestamps();
    }

    public function post_tag()
    {
        return $this->hasMany(Post_Tag::class, 'tag_id ', 'id')->withTimestamps();
    }
}
