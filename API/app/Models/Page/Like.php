<?php

namespace App\Models\Page;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'page_likes';

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->select(['id','name','lname']);
    }

}
