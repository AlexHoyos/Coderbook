<?php

namespace App\Events;

use App\Models\Reaction;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ReactedToPost extends Event
{
    use SerializesModels;
    public $reaction;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Reaction $reaction, $re_react = false)
    {
        $this->reaction = $reaction;
        $this->rreact = $re_react;
    }



}
