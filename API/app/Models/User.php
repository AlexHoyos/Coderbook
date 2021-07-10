<?php

namespace App\Models;

use App\Models\User\Friend;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Lumen\Http\Request;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lname', 'username', 'email', 'password', 'wallpaper_pic_id', 'profile_pic_id', 'rankId', 'api_token', 'lastIp', 'see_notif', 'see_msg'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'wallpaper_pic_id', 'profile_pic_id', 'rankId', 'api_token', 'updated_at', 'lastIp', 'relation_with_id'
    ];

    public function getPosts(){
        return $this->hasMany('App\Models\Post');
    }

    public function profilePic(){
        $profile_pic = $this->belongsTo('App\Models\MMedia', 'profile_pic_id')->select(['id','url']);
        return $profile_pic;
    }

    public function wallpaperPic(){
        return $this->belongsTo(MMedia::class, 'wallpaper_pic_id')->select(['id', 'url']);
    }

    public function relation(){
        return $this->belongsTo(Self::class, 'relation_with_id')->select(['id', 'name', 'lname']);
    }

    public function recentPhotos(){
        return $this->hasMany(MMedia::class)->select(['id', 'url', 'type'])->where('type', '!=', 'mp4')->orderByDesc('id')->limit(9);
    }

    public function recentFriends(){
        $limit = 9;
        $senderFriends = $this->hasMany(Friend::class, 'sender_id')->select(['id', 'target_id as user_id', 'accepted'])->where('accepted', '=', 'y')->limit($limit)->getResults()->all();
        $limit -= count($senderFriends);
        $targetFriends = [];
        if($limit > 0){
            $targetFriends = $this->hasMany(Friend::class, 'target_id')->select(['id', 'sender_id as user_id', 'accepted'])->where('accepted', '=', 'y')->limit($limit)->getResults()->all();
        }

        $recent_friends = [];
        foreach(array_merge($senderFriends, $targetFriends) as $friend){

            $user = User::select(['id', 'name', 'lname', 'profile_pic_id'])->where('id', '=', $friend['user_id'])->first();
            $user->profilePic;
            $recent_friends[] = $user;

        }

        $this->recent_friends = $recent_friends;
    }

    public function friends(){
        $friends_target = $this->hasMany(Friend::class, 'sender_id')->select(['id', 'target_id as user_id', 'accepted'])->where('accepted', '=', 'y')->with('userData')->getResults()->all();
        $friends_sender = $this->hasMany(Friend::class, 'target_id')->select(['id', 'sender_id as user_id', 'accepted'])->where('accepted', '=', 'y')->with('userData')->getResults()->all();
        $this->friends = array_merge($friends_sender, $friends_target);
    }

    public function getMessages($uid){

        $messages = Message::where('sender_id', '=', $uid)->where('target_id', '=', $this->id)->orWhere('sender_id', '=', $this->id)->where('target_id', '=', $uid)->orderBy('id', 'asc')->get()->all();
        return $messages;

    }

    public function getLastMessage($uid){

        $messages = Message::where('sender_id', '=', $uid)->where('target_id', '=', $this->id)->orWhere('sender_id', '=', $this->id)->where('target_id', '=', $uid)->orderBy('id', 'desc')->limit(1)->get()->first();
        return $messages;

    }

    public function isFriendOf($uid){
        $isSender = Friend::where('sender_id', '=', $this->id)->where('target_id', '=', $uid)->get()->count();
        $isTarget = Friend::where('target_id', '=', $this->id)->where('sender_id', '=', $uid)->get()->count();
        return ($isSender || $isTarget);
    }

    public function friendsCount(){
        $incoming = $this
            ->hasMany(Friend::class, 'sender_id')
            ->select(['id', 'target_id', 'accepted'])
            ->where('accepted', '=', 'y')
            ->count();
        $outgoing = $this
            ->hasMany(Friend::class, 'target_id')
            ->select(['id', 'sender_id', 'accepted'])
            ->where('accepted', '=', 'y')
            ->count();
        $this->total_friends = $incoming + $outgoing;
    }

    public function reacts(){
        return $this->hasMany('App\Models\Reaction');
    }

    public function isOnFillable($key){
        return in_array($key, $this->fillable);
    }

    public function getCreatedAtAttribute($date)
    {
        return strtotime($date);
    }

    public function getBirthDateAttribute($date)
    {
        return strtotime($date);
    }

}
