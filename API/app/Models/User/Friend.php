<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    public function targetData(){
        $this->user = $this->belongsTo('App\Models\User', 'target_id')->where('id', '=', $this->id)->select(['name', 'lname', 'profile_pic_id'])->with('profilePic');
    }

    public function senderData(){
        $this->user = $this->belongsTo('App\Models\User', 'sender_id')->where('id', '=', $this->id)->select(['name', 'lname', 'profile_pic_id'])->with('profilePic');
    }
}
