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
        'password', 'remember_token', 'confirm_token'
    ];

    /**
     * Get the confirmation email link.
     *
     * @return string
     */
    public function getConfirmationLink()
    {
        return secure_url('confirm/' . $this->confirm_token . '/' . $this->email);
    }

    /**
     * Get confirmation token.
     *
     * @return string
     */
    public function getConfirmationCode()
    {
        return $this->confirm_token;
    }

    /**
     * Set confirmation.
     *
     * @return bool
     */
    public function confirmed()
    {
        $this->confirmed = 1;
        $this->confirm_token = '';
        $this->saveOrFail();

        return true;
    }

    /**
     * Check if user has confirmed.
     *
     * @return bool
     */
    public function hasConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * Validates confirmation code.
     *
     * @param $code
     * @return bool
     */
    public function validateConfirmation($code)
    {
        if ($code == $this->confirm_token && !$this->hasConfirmed())
            return $this->confirmed();

        return false;
    }
}
