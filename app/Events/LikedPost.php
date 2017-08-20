<?php

namespace App\Events;

use App\User;
use App\Post;
use App\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Events\Interfaces\ShouldNotify;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class LikedPost implements ShouldNotify, ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var
     */
    public $user;

    /**
     * @var Post
     */
    public $post;

    /**
     * @var Notification
     */
    public $notification;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
        $this->notification = $this->shouldNotify() ? $this->getNotification() : null;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('App.User.' . $this->user()->id);
    }

    /**
     * @return bool
     */
    public function broadcastWhen()
    {
        return $this->shouldNotify();
    }

    /**
     * Broadcast data.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'notification' => $this->notification->jsonSerialize()
        ];
    }

    /**
     * @return bool
     */
    public function shouldNotify()
    {
        return $this->user()->id != $this->user->id;
    }

    /**
     * @return string
     */
    public function getMessageKey()
    {
        return 'liked';
    }

    /**
     * @return array
     */
    public function getNotification()
    {
        return $this->user()->notifications()->create([
            'content' => $this->getMessageKey(),
            'type'    => Notification::USER_TYPE,
            'related' => json_encode([
                'user_id' => $this->user->id,
                'post_id' => $this->post->id
            ])
        ]);
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->post->user;
    }
}
