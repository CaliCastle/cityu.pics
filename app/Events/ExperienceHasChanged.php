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
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ExperienceHasChanged implements ShouldNotify, ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $exp;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var
     */
    protected $reason;

    /**
     * @var
     */
    public $notification;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param      $exp
     * @param      $reason
     */
    public function __construct(User $user, $exp, $reason)
    {
        $this->user = $user;
        $this->exp = intval($exp);
        $this->reason = $reason;
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
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'notification' => $this->notification->jsonSerialize(),
            'experience'   => $this->exp
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
            'type'    => Notification::EXP_TYPE,
            'related' => json_encode([
                'exp'    => $this->exp,
                'reason' => $this->reason
            ])
        ]);
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getMessageKey()
    {
        return 'earned-exp';
    }
}
