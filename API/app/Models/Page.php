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

    public function likes(){
        return $this->hasMany(Like::class, 'page_id')->with('user');
    }

    public function likesCount(){
        $this->likes = $this->hasMany(Like::class, 'page_id')->get()->count();
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

}
