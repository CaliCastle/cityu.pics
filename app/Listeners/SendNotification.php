<?php

namespace App\Listeners;

use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotification
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
     * @param  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user();
        // Create notifications for individuals.
        foreach ($user->getFollowers() as $f) {
            $follower = User::find($f->follower_id);
            $follower->notifications()->create($event->getNotification());
        }
    }
}
