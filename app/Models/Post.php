<?php

namespace App\Models;

use App\Traits\EloquentScope;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelLike\Traits\Likeable;

class Post extends Model
{
    use SoftDeletes;
    use EloquentScope;
    use Likeable;
    use Favoriteable;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'slug', 'content', 'is_approved', 'cover_image', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id')->withTimestamps();
    }
    public function post_tag()
    {
        return $this->hasMany(Post_Tag::class, 'post_id', 'id')->withTimestamps();
    }

    /**
     * Eloquent Query Scopes get X days before
     * For example lastDays($number).
     *
     * @param mixed $query
     * @param mixed $number
     */
    // public function scopeLastDays($query, $number)
    // {
    //     $dates = \Carbon\Carbon::today()->subDays($number);

    //     return $query->where('created_at', '>=', $dates);
    // }

    /**
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
        // Normalize the title which is the value
        $slug = Str::slug($value);
        $this->attributes['slug'] = $slug;
    }

    public function setIs_Approvedttribute($key, $value)
    {
        if ($value) {
            $this->attributes['is_approved'] = true;
        } else {
            $this->attributes['is_approved'] = false;
        }
    }
}
