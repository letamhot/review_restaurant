<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Tag extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    // protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'name', 'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Set the proper slug attribute.
     *
     * @param string $value
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }
    public function post()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id')->withTimestamps();
    }
    public function post_tag()
    {
        return $this->hasMany(Post_Tag::class, 'tag_id ', 'id')->withTimestamps();
    }
}
