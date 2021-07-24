<?php

namespace App\Providers;

use App\Events\CommentPost;
use App\Events\PostInProfile;
use App\Events\ReactedToPost;
use App\Events\SendFriendRequest;
use App\Listeners\FriendRequest;
use App\Listeners\Post\Comment;
use App\Listeners\Post\Reaction;
use App\Listeners\PostedInProfile;
use Illuminate\Support\Facades\Event;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /***
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            ReactedToPost::class,
            [Reaction::class, 'handle']
        );

        Event::listen(
            CommentPost::class,
            [Comment::class, 'handle']
        );

        Event::listen(
            SendFriendRequest::class,
            [FriendRequest::class, 'handle']
        );

        Event::listen(
            PostInProfile::class,
            [PostedInProfile::class, 'handle']
        );

    }

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\ExampleEvent::class => [
            \App\Listeners\ExampleListener::class,
        ],
        ReactedToPost::class => [
            Reaction::class,
        ],
        CommentPost::class => [
            Comment::class
        ],
        SendFriendRequest::class => [
            FriendRequest::class
        ],
        PostInProfile::class => [
            PostedInProfile::class
        ]
    ];

    public function shouldDiscoverEvents()
    {
        return true;
    }
}
