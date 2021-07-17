<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MMedia extends Model
{

    protected $fillable = [
        'user_id', 'post_id', 'page_id', 'type', 'url', 'pp_x', 'pp_y', 'pp_size'
    ];

    public static function saveMMedia($id, $file, $page = false){
        if($page){
            $newName = $id . '_' . (time() + rand(1,10000)) . '.' . $file->getClientOriginalExtension();
            $file->move('media/page/'.$id.'/', $newName);
            return $newName;
        } else {
            $newName = $id . '_' . (time() + rand(1,10000)) . '.' . $file->getClientOriginalExtension();
            $file->move('media/usr/'.$id.'/', $newName);
            return $newName;
        }
    }

}
