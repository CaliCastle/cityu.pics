<?php

namespace App\Events;

use App\User;
use App\Comment;
use App\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Events\Interfaces\ShouldNotify;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class LikedComment implements ShouldNotify, ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Comment
     */
    public $comment;

    /**
     * @var
     */
    public $user;

    /**
     * @var Notification
     */
    public $notification;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, User $user)
    {
        $this->comment = $comment;
        $this->user = $user;
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
     * @return mixed
     */
    public function getNotification()
    {
        return $this->user()->notifications()->create([
            'content' => $this->getMessageKey(),
            'type'    => Notification::USER_TYPE,
            'related' => json_encode([
                'user_id'    => $this->user->id,
                'comment_id' => $this->comment->id
            ])
        ]);
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->comment->user;
    }

    /**
     * @return string
     */
    public function getMessageKey()
    {
        return 'liked-comment';
    }

    /**
     * @return bool
     */
    public function shouldNotify()
    {
        return $this->user()->id != $this->user->id;
    }
}
