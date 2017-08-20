<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Registered' => [
            'App\Listeners\RegistrationListener',
        ],
        'App\Events\FeedPosted'             => [
            'App\Listeners\ChangeExperience',
            'App\Listeners\SendNotification'
        ],
        'App\Events\CommentPosted'          => [
            'App\Listeners\ChangeExperience'
        ],
        'App\Events\NewCommentReply'        => [
            'App\Listeners\ChangeExperience'
        ],
        'App\Events\UserFollowed'           => [],
        'App\Events\LikedPost'              => [],
        'App\Events\LikedComment'           => [],
        'App\Events\AnnouncementPosted'     => [],
        'App\Events\ExperienceHasChanged'   => []
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
