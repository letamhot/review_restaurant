<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = "messages";

    
    public function user()
    {
        return $this->belongsTo(User::class);
    

}
