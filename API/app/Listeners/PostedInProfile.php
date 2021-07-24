<?php

namespace App\Listeners;


use App\Events\PostInProfile;
use App\Models\Notification;

class PostedInProfile
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
     * @param  PostInProfile  $event
     * @return void
     */
    public function handle(PostInProfile $event)
    {
        $Post = $event->post;
        if($event->deleted){

        } else {

           if($Post->type = 'to_user'){

               $data = [];
               $data['sender_id'] = $Post->user_id;
               $data['target_id'] = $Post->to_user_id;
               $data['post_id'] = $Post->id;
               $data['type'] = 'post_bio';
               $Notificacion = new Notification($data);
               $Notificacion->save();

           }

        }
    }
}
