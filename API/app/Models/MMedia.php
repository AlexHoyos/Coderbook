<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MMedia extends Model
{

    protected $fillable = [
        'user_id', 'post_id', 'type', 'url'
    ];

    public static function saveMMedia($user_id, $file){
        $newName = $user_id . '_' . time() + rand(1,10000) . '.' . $file->getClientOriginalExtension();
        $file->move('media/usr/'.$user_id.'/', $newName);
        return $newName;
    }

}
