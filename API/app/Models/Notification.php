<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'sender_id', 'target_id', 'type', 'post_id', 'comment_id', 'reaction_id'
    ];
}
