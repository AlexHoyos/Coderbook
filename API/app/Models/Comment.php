<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = [
      'user_id', 'post_id', 'comment_id', 'mmedia_id', 'comment'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id')->select(['id', 'name', 'lname', 'profile_pic_id'])->with(['profilePic']);
    }

    public function post(){
        return $this->belongsTo('App\Models\Post', 'post_id')->select(['id', 'user_id']);
    }

    public function reactions(){
        return $this->hasMany('App\Models\Reaction')->select(['id', 'user_id', 'comment_id', 'reaction'])->with(['user']);
    }

    public function responses(){
        return $this->hasMany(Self::class)->select(['id', 'user_id', 'comment', 'created_at'])->with(['user'])->orderBy('id');
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

    public function responsesCount(){
        $this->responses_count = $this->hasMany(Self::class)->count();
    }

    public function userLiked(User $user){
        $reaction = $user->reacts()->where('comment_id','=',$this->id);
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
