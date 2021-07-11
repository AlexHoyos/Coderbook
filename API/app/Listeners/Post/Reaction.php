<?php

namespace App\Listeners\Post;

use App\Events\ReactedToPost;
use App\Models\Notification;
use App\Models\Post;

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
        $Reaction = $event->reaction;
        $Post = Post::where('id', '=', $Reaction->post_id)->get()->first();
        if($Post instanceof Post){

            $data = [];
            $data['sender_id'] = $Reaction->user_id;
            $data['target_id'] = $Post->user_id;
            $data['type'] = 'reaction';
            $data['post_id'] = $Post->id;
            $data['reaction_id'] = $Reaction->id;
            $Notificacion = new Notification($data);
            $Notificacion->save();

        }

    }
}
