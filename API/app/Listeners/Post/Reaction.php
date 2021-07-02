<?php

namespace App\Listeners\Post;

use App\Events\ReactedToPost;

class Reaction
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ReactedToPost  $event
     * @return void
     */
    public function handle(ReactedToPost $event)
    {
        //
    }
}
