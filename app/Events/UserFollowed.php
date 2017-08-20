<?php

namespace App\Events;

use App\User;
use App\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Events\Interfaces\ShouldNotify;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class UserFollowed implements ShouldNotify, ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var User
     */
    protected $follower;

    /**
     * @var Notification
     */
    public $notification;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, User $follower)
    {
        $this->user = $user;
        $this->follower = $follower;
        $this->notification = $this->getNotification();
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
        return true;
    }

    /**
     * @return array
     */
    public function getNotification()
    {
        return $this->user()->notifications()->create([
            'content' => $this->getMessageKey(),
            'type'    => Notification::USER_TYPE,
            'related' => json_encode(['user_id' => $this->follower->id])
        ]);
    }

    /**
     * @return string
     */
    public function getMessageKey()
    {
        return 'followed';
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->user;
    }
}
