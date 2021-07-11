<?php

namespace App\Events;

use App\Models\Reaction;

class UnreactToPost extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Reaction $reaction)
    {
        $this->reaction = $reaction;
    }
}
