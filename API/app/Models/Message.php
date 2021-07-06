<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    public function targetUser(){

        return $this->belongsTo('App\Model\User', 'user_id')->select(['id', 'name', 'lname', 'profile_pic_id'])->with(['profilePic']);

    }

}
