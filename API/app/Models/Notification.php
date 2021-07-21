<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'sender_id', 'target_id', 'type', 'post_id', 'comment_id', 'reaction_id'
    ];

    public function sender(){
        return $this->belongsTo(User::class, 'sender_id')->select(['id', 'name', 'lname']);
    }

    public function reaction(){
        return $this->belongsTo(Reaction::class, 'reaction_id')->select(['id', 'post_id', 'comment_id', 'reaction']);
    }

    public function getCreatedAtAttribute($date)
    {
        return strtotime($date);
    }

}
