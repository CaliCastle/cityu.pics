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
        'name', 'email', 'password', 'confirm_token'
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
     * Gets the confirmation email link.
     *
     * @return string
     */
    public function getConfirmationLink()
    {
        return secure_url('confirm/' . $this->confirm_token . '/' . $this->email);
    }

    /**
     * Gets confirmation token.
     *
     * @return string
     */
    public function getConfirmationCode()
    {
        return $this->confirm_token;
    }

    /**
     * Resets confirmation code/token.
     *
     * @return bool
     */
    public function resetConfirmationCode()
    {
        $this->confirm_token = random_int(0, 9) . random_int(0, 9) . random_int(0, 9) . random_int(0, 9) . random_int(0, 9);
        $this->confirmed = 0;

        return $this->saveOrFail();
    }

    /**
     * Sets confirmation.
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
     * Checks if user has confirmed.
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

    /**
     * Gets user's posts collection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
