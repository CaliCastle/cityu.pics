<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountRegistered extends Mailable
{
    use SerializesModels;

    /**
     * Get the user.
     *
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (!$this->user->getRememberToken())
            $this->user->setRememberToken(str_random(60));

        return $this->from(config('mail.from.address'))
                    ->view('emails.registered');
    }
}
