<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $fillable = [
        'user_id', 'post_id', 'comment_id', 'reaction'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id')->select(['id','name','lname', 'profile_pic_id'])->with('profilePic');
    }

}
