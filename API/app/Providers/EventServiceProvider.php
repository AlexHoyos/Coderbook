<?php

namespace App\Providers;

use App\Events\ReactedToPost;
use App\Listeners\Post\Reaction;
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
    ];

    public function shouldDiscoverEvents()
    {
        return true;
    }
}
