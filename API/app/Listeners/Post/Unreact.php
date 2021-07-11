<?php

namespace App\Listeners\Post;

use App\Events\UnreactToPost;
use App\Models\Notification;

class Unreact
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
     * @param  UnreactToPost  $event
     * @return void
     */
    public function handle(UnreactToPost $event)
    {
        $Reaction = $event->reaction;
        $Post = Post::find($Reaction->post_id);
        if($Post instanceof $Post){

            $Notification = Notification::where('user_id', '=', $Reaction->user_id)
                -where('post_id', $Post->id)->get()->first();

            if($Notification instanceof Notification)
                $Notification->delete();
        }
    }
}
