<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = [];
    protected $appends = ['role_name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'access_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getRoleNameAttribute()
    {
        return $this->attributes['role_name'] = optional($this->role)->name;
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany(Messages::class);
    }

    public function following()
    {
        return $this->belongsToMany(User::class,'follower', 'user_id', 'following_id' );
    }

    /**
     * Get the route key for the model instead of real ID.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Get the user's Provider name.
     *
     * @param string $value
     *
     * @return string
     */
    public function getProviderNameAttribute($value)
    {
        return ucfirst($value);
    }

    
    public static function getAuthor($id)
    {
        $user = self::find($id);
        return [
            'id'     => $user->id,
            'name'   => $user->name,
            'email'  => $user->email,
            'url'    => '',  // Optional
            'avatar' => $user->avatar,  // Default avatar
            // 'admin'  => $user->role === 'Admin', // bool
        ];
    }

    public function routeNotificationForApn(){
    return $this->ios_push_token;
    }
}
