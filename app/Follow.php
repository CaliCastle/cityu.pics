<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_followers';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id', 'follower_id'
    ];

    /**
     * Gets followers count.
     *
     * @param User $user
     *
     * @return int
     */
    public static function followersCount(User $user)
    {
        return static::where('user_id', '=', $user->id)->count();
    }

    /**
     * Gets followings count.
     *
     * @param User $user
     *
     * @return int
     */
    public static function followingsCount(User $user)
    {
        return static::where('follower_id', '=', $user->id)->count();
    }
}
