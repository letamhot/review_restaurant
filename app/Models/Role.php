<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    // protected $table = ['roles'];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = ['created_at', 'updated_at'];

    // protected $guarded = [];

    protected $fillable = [
        'name', 'description',
    ];

    public function users()
    {
        return $this->hasMany(User::class)->withTimestamps();
    }
}