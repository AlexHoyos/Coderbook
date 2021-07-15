<?php

namespace App\Models\Page;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    protected $table = 'pages_administrators';
    protected $fillable = [
        'page_id', 'admin_id', 'role'
    ];
}
