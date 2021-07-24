<?php

namespace App\Events;

use App\Models\Post;

class PostInProfile extends Event
{
    /**
     * Create a new event instance.
     * @param Post $post
     * @param bool $deleted
     * @return void
     */
    public function __construct(Post $post, $deleted = false)
    {
        $this->post = $post;
        $this->deleted = $deleted;
    }
}
