<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $tablename = 'posts';
    protected $fillable = [
      'user_id', 'content', 'privacy', 'type', 'to_user_id', 'shared_post_id', 'page_id'
    ];

    public $postedSince;

    public function sharedPost(){
        return $this->belongsTo(Self::class, 'shared_post_id')->with(['user', 'mmedias']);
    }

    public function mmedias(){
        return $this->hasMany('App\Models\MMedia');
    }

    public function user(){
        $user = $this->belongsTo('App\Models\User')->select(['id','name','lname','profile_pic_id'])->with(['profilePic']);
        return $user;
    }

    public function page(){
        return $this->belongsTo(Page::class)->select(['id', 'title', 'principal_pic_id'])->with(['principalPic']);
    }

    public function toUser(){
        return $this->belongsTo('App\Models\User', 'to_user_id')->select(['id', 'name', 'lname']);
    }

    public function reactions(){
        return $this->hasMany('App\Models\Reaction')->select(['id', 'user_id', 'reaction'])->with(['user']);
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment')->select(['id', 'user_id', 'comment', 'created_at'])->with(['user'])->orderByDesc('id');
    }

    public function reactionsCount(){

        $this->reactions_count = $this->hasMany('App\Models\Reaction')->count();

    }

    public function getMostReact(){
       // ['like', 'love', 'lol', 'wow', 'sad', 'angry']
        $this->most_react = 'like';
        $like = $this->reactions()->select(['reaction'])->where('reaction', '=', 'like')->count();
        $love = $this->reactions()->select(['reaction'])->where('reaction', '=', 'love')->count();
        $lol = $this->reactions()->select(['reaction'])->where('reaction', '=', 'lol')->count();
        $wow = $this->reactions()->select(['reaction'])->where('reaction', '=', 'wow')->count();
        $sad = $this->reactions()->select(['reaction'])->where('reaction', '=', 'sad')->count();
        $angry = $this->reactions()->select(['reaction'])->where('reaction', '=', 'angry')->count();
        $max = max($like, $love, $lol, $wow, $sad, $angry);

        if($max == $like)
            $this->most_react =  'like';
        if($max == $love)
            $this->most_react =  'love';
        if($max == $lol)
            $this->most_react =  'lol';
        if($max == $wow)
            $this->most_react =  'wow';
        if($max == $sad)
            $this->most_react =  'sad';
        if($max == $angry)
            $this->most_react =  'angry';
    }

    public function commentsCount(){

        $this->comments_count = $this->hasMany('App\Models\Comment')->count();

    }

    public function sharedCount(){
        $this->shared_count = $this->hasMany('App\Models\Post', 'shared_post_id')->count();
    }

    public function userLiked(User $user){
        $reaction = $user->reacts()->where('post_id','=',$this->id);
        $bool = $reaction->count();
        $this->user_liked = ($bool) ? true : false;
        if($bool)
            $this->user_reaction = $reaction->first()->reaction;
    }

    public function getCreatedAtAttribute($date)
    {
        return strtotime($date);
    }



}
