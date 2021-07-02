<?php

namespace App\Events;

use App\Models\Reaction;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ReactedToPost extends Event
{
    use InteractsWithSockets, SerializesModels;
    public $reaction;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Reaction $reaction)
    {
        $this->reaction = $reaction;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     * */

    public function broadcastOn()
    {
        return ['post_reaction.'.$this->reaction->id];
    }
}
