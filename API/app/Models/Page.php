<?php

namespace App\Models;

use App\Models\Page\Administrator;
use App\Models\Page\Like;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'owner_id', 'title', 'visibility', 'category', 'description', 'principal_pic_id', 'wallpaper_pic_id'
    ];

    public function principalPic(){
        return $this->belongsTo(MMedia::class, 'principal_pic_id')->select(['id','url', 'pp_x', 'pp_y', 'pp_size']);
    }

    public function likes(){
        return $this->hasMany(Like::class, 'page_id')->with('user');
    }

    public function posts(){
        return $this->hasMany(Post::class, 'page_id')->orderBy('id', 'desc');
    }

    public function likesCount(){
        $this->likes_count = $this->hasMany(Like::class, 'page_id')->get()->count();
    }

    public function checkAdmin($uid){
        $Admin = Administrator::where('page_id', $this->id)->where('admin_id', $uid)->get()->first();

        if($Admin instanceof Administrator){
            $this->admin = true;
            $this->admin_role = $Admin->role;
            return true;
        } else {
            $this->admin = false;
            return false;
        }

    }

    public function userLiked($uid){
        $Like = Like::where('user_id', $uid)->where('page_id', $this->id)->get()->count();
        $this->user_liked = ($Like > 0) ? true : false;
    }

}
