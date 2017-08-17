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
     *
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

    /**
     * Gets user's comments collection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Like/unlike the given post.
     *
     * @param Post $post
     */
    public function likePost(Post $post)
    {
        $post->likes()->toggle($this->id);

        return $this->likedPost($post) ? $post->increment('like_count') : $post->decrement('like_count');
    }

    /**
     * Checks if liked the post.
     *
     * @param Post $post
     *
     * @return bool
     */
    public function likedPost(Post $post)
    {
        return !!$post->likes()->wherePivot('user_id', '=', $this->id)->first();
    }

    /**
     * Like/unlike the given comment.
     *
     * @param Comment $comment
     */
    public function likeComment(Comment $comment)
    {
        $comment->likes()->toggle($this->id);

        return $this->likedComment($comment) ? $comment->increment('like_count') : $comment->decrement('like_count');
    }

    /**
     * Checks if liked the comment.
     *
     * @param Comment $comment
     *
     * @return bool
     */
    public function likedComment(Comment $comment)
    {
        return !!$comment->likes()->wherePivot('user_id', '=', $this->id)->first();
    }

    /**
     * Gets user's profile link.
     *
     * @return string
     */
    public function profileLink()
    {
        return route('profile', ['user' => $this->name]);
    }

    /**
     * Checks if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Checks if the user is verified.
     *
     * @return bool
     */
    public function isVerified()
    {
        return $this->hasRole('verified');
    }

    /**
     * Changes user's avatar.
     *
     * @param $path
     *
     * @return bool
     */
    public function changeAvatar($path)
    {
        $this->avatar = 'users/avatars/' . $path;

        return $this->save();
    }

    /**
     * Comments a post.
     *
     * @param Post $post
     * @param      $content
     * @param bool $parent
     *
     * @return Comment
     */
    public function commentPost(Post $post, $content, $parent = false)
    {
        $attributes = ['content' => $content, 'post_id' => $post->id];

        if ($parent)
            $attributes = array_add($attributes, 'parent', $parent);

        $comment = $this->comments()->create($attributes);

        return $comment;
    }

    /**
     * Gets followers count.
     *
     * @return int
     */
    public function getFollowersAttribute()
    {
        return Follow::followersCount($this);
    }

    /**
     * Gets followings count.
     *
     * @return int
     */
    public function getFollowingsAttribute()
    {
        return Follow::followingsCount($this);
    }
}
