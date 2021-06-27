<?php

namespace App\Models;

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
        'name', 'lname', 'username', 'email', 'password', 'wallpaper_pic_id', 'profile_pic_id', 'rankId', 'api_token', 'lastIp'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'wallpaper_pic_id', 'profile_pic_id', 'rankId', 'api_token', 'created_at', 'updated_at', 'lastIp'
    ];

    public function getPosts(){
        return $this->hasMany('App\Models\Post');
    }

    public function profilePic(){
        return $this->belongsTo('App\Models\MMedia', 'profile_pic_id')->select(['id','url']);
    }

    public function reacts(){
        return $this->hasMany('App\Models\Reaction');
    }

    public function isOnFillable($key){
        return in_array($key, $this->fillable);
    }

}
