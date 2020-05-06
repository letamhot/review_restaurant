<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'slug', 'content', 'is_approved', 'cover_image', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    /**
     * Eloquent Query Scopes
     *  approved().
     *
     * @param mixed $query
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', 1);
    }

    /**
     * Eloquent Query Scopes
     *  lastDays().
     *
     * @param mixed $query
     * @param mixed $number
     */
    public function scopeLastDays($query, $number)
    {
        $dates = \Carbon\Carbon::today()->subDays($number);

        return $query->where('created_at', '>=', $dates);
    }

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
        // check the new slug is exist or not
        if (static::whereSlug($slug)->exists()) {
            $slug = $this->incrementSlug($slug);
        }
        $this->attributes['slug'] = $slug;
    }

    /**
     * Increment slug.
     *
     * @param string $slug
     *
     * @return string
     */
    protected function incrementSlug($slug)
    {
        $latestSlug = $this->getLatestSlug($slug);
        // check the last character of the slug is number or not
        if (is_numeric($latestSlug[-1])) {
            // increment the value found with 1 and return the result
            return preg_replace_callback('/(\d+)$/', function ($mathces) {
                return $mathces[1] + 1;
            }, $latestSlug);
        }

        // latest slug is the first one
        // then this is the second one
        // "{$slug}-2"
        return $slug.'-2';
    }

    protected function getLatestSlug($slug)
    {
        /*
         * get the slug of the latest created post
         * @return string
         */
        return static::select('slug')->where('slug', 'like', $slug.'%')->latest()->take(1)->value('slug');
    }
}
