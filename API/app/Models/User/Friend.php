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

    public static function findFriendship($user_a, $user_b){

        $friendReq = Self::where(function($query) use ($user_a, $user_b){
                $query->where('sender_id', $user_a)
                    ->where('target_id', $user_b);
            })
            ->orWhere(function($query) use ($user_a, $user_b){
                $query->where('sender_id', $user_b)
                    ->where('target_id', $user_a);
            })->get()->first();

        return $friendReq;

    }


}
