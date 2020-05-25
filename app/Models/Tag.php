<?php

namespace App\Models;

use App\Traits\EloquentScope;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Tag extends Model implements ReactableContract
{
    use Reactable;
    use SoftDeletes;
    use EloquentScope;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'slug',
    ];

    public function post()
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }

    public function post_tag()
    {
        return $this->hasMany(Post_Tag::class, 'tag_id ', 'id')->withTimestamps();
    }

    /*
     * Get the route key for the model.
     *
     * @return string
     */
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
}
