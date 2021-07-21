<?php

namespace App\Events;

use App\Models\Comment;
use App\Models\Reaction;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CommentPost extends Event
{
    use SerializesModels;
    public $comment;
    public $deleted = false;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, $deleted = false)
    {
        $this->comment = $comment;
        $this->deleted = $deleted;
    }



}
