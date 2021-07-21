<?php

namespace App\Listeners;

use App\Events\SendFriendRequest;
use App\Models\Notification;

class FriendRequest
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
     * @param  SendFriendRequest  $event
     * @return void
     */
    public function handle(SendFriendRequest $event)
    {
        $Friendship = $event->friend;
        if($event->deleted){

            $Notificacion = Notification::where('target_id', $Friendship->target_id)
                ->where('sender_id', $Friendship->sender_id)
                ->where('type', 'friend_req')->get()->first();

            Notification::destroy($Notificacion->id);

        } else {

            $data = [];
            $data['sender_id'] = $Friendship->sender_id;
            $data['target_id'] = $Friendship->target_id;
            $data['type'] = 'friend_req';
            $Notificacion = new Notification($data);
            $Notificacion->save();

        }
    }
}
