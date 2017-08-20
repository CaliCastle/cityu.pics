<?php

namespace App\Events;

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

class NewCommentReply implements ShouldBroadcastNow, ShouldNotify
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Comment
     */
    public $comment;

    /**
     * @var Notification
     */
    public $notification;

    /**
     * @var int
     */
    public $exp = 10;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
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
    public function broadcastWhen()
    {
        return $this->shouldNotify();
    }

    /**
     * @return bool
     */
    public function shouldNotify()
    {
        return $this->user()->id != $this->comment->user->id;
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
                'user_id'    => $this->comment->user->id,
                'comment_id' => $this->comment->id
            ])
        ]);
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->comment->parentComment->user;
    }

    /**
     * @return string
     */
    public function getMessageKey()
    {
        return 'new-reply';
    }

    /**
     * @param $exp
     */
    public function changeExperience($exp)
    {
        $this->comment->user->changeExperience($exp, $this->getMessageKey());
    }
}
