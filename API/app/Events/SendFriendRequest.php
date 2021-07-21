<?php

namespace App\Events;

use App\Models\User\Friend;

class SendFriendRequest extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Friend $friend, $deleted = false)
    {
        $this->friend = $friend;
        $this->deleted = $deleted;
    }
}
