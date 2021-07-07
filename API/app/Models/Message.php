<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    public function shortMessage(){
        if(strlen($this->message) > 30){
            $this->message = substr($this->message, 0, 30) . '...';
        }
    }

    public function targetUser(){

        return $this->belongsTo('App\Model\User', 'user_id')->select(['id', 'name', 'lname', 'profile_pic_id'])->with(['profilePic']);

    }

    public function getSeenAttribute($seen){
        return ($seen == 'y');
    }

}
