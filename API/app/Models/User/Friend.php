<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $fillable = [
        'sender_id', 'target_id', 'accepted'
    ];

    public function userData(){
        return $this->belongsTo('App\Models\User', 'user_id', )->select(['id', 'name', 'lname', 'profile_pic_id'])->with('profilePic');
    }


}
