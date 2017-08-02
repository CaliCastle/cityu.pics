<?php

namespace App;

use TCG\Voyager\Traits\VoyagerUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, VoyagerUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the confirmation email link.
     *
     * @return string
     */
    public function getConfirmationLink()
    {
        return secure_url('confirm/' . $this->getRememberToken());
    }

    /**
     * Set confirmation.
     */
    public function confirmed()
    {
        $this->confirmed = 1;
        $this->saveOrFail();
    }
}
