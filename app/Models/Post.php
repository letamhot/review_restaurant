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

    public function category()
    {
        return $this->belongsTo(Category::class);
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
        $this->attributes['slug'] = $slug;
    }

    public function setIs_Approvedttribute($key, $value)
    {
        if($value) {
            $this->attributes['is_approved'] = true;
        }
        
        else {
            $this->attributes['is_approved'] = false;
        }
    }

}
