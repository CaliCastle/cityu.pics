<?php

namespace App\Events;

use App\Post;
use App\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class FeedPosted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Post
     */
    public $post;

    /**
     * @var int
     */
    public $exp = 100;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
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
     * Gets the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->post->user;
    }

    /**
     * @return array
     */
    public function getNotification()
    {
        return [
            'content' => $this->getMessageKey(),
            'type'    => Notification::USER_TYPE,
            'related' => json_encode([
                'user_id' => $this->post->user->id,
                'post_id' => $this->post->id
            ])
        ];
    }

    /**
     * @return string
     */
    public function getMessageKey()
    {
        return 'new-post';
    }

    /**
     * @param $exp
     */
    public function changeExperience($exp)
    {
        $this->user()->changeExperience($exp, $this->getMessageKey());
    }
}
