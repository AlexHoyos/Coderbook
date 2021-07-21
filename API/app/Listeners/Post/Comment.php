<?php

namespace App\Listeners\Post;

use App\Events\CommentPost;
use App\Models\Notification;
use App\Models\Post;

class Comment
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
     * @param  CommentPost  $event
     * @return void
     */
    public function handle(CommentPost $event)
    {
        $Comment = $event->comment;
        //return response()->json($Comment->id);
        if($event->deleted){

            $Notificacion = Notification::where('comment_id', $Comment->id)
                ->where('sender_id', $Comment->user_id)->get()->first();
            Notification::destroy($Notificacion->id);

        } else {
            $Post = Post::find($Comment->post_id);
            if($Post instanceof Post){
                $data = [];
                $data['sender_id'] = $Comment->user_id;
                $data['target_id'] = $Post->user_id;
                $data['type'] = 'comment';
                $data['post_id'] = $Post->id;
                $data['comment_id'] = $Comment->id;
                $Notificacion = new Notification($data);
                $Notificacion->save();
            }

        }
    }
}
