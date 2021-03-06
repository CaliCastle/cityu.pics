<?php

namespace App;

use App\Events\CheckedIn;
use App\Events\LikedPost;
use App\Events\UserFollowed;
use App\Events\LikedComment;
use App\Events\CommentPosted;
use App\Events\NewCommentReply;
use TCG\Voyager\Traits\VoyagerUser;
use App\Events\ExperienceHasChanged;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use VoyagerUser;

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
     * Gets gender types.
     *
     * @return array
     */
    public static function genderTypes()
    {
        return ['male', 'female', 'unspecific'];
    }

    /**
     * Gets gender icon names.
     *
     * @param $gender
     *
     * @return string
     */
    public static function genderToIcon($gender)
    {
        switch ($gender) {
            case 'male':
                return 'mars';
            case 'female':
                return 'venus';
            default:
                return 'genderless';
        }
    }

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
        $post->likes()->withTimestamps()->toggle($this->id);

        // Fire event.
        if ($this->likedPost($post))
            event(new LikedPost($this, $post));

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
     * Gets the user's liked posts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'likes');
    }

    /**
     * Like/unlike the given comment.
     *
     * @param Comment $comment
     */
    public function likeComment(Comment $comment)
    {
        $comment->likes()->toggle($this->id);

        // Fire event.
        if ($this->likedComment($comment))
            event(new LikedComment($comment, $this));

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
     * Gets avatarUrl attribute.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getAvatarUrlAttribute()
    {
        return url('/storage/' . $this->avatar);
    }

    /**
     * Gets formatted experience.
     *
     * @return string
     */
    public function formattedExperience()
    {
        return number_format($this->attributes['experience']);
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

        // Fire event.
        if ($parent) {
            event(new NewCommentReply($comment));
        } else {
            event(new CommentPosted($comment));
        }

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

    /**
     * Checks follow state.
     *
     * @param User $user
     *
     * @return bool
     */
    public function followed(User $user)
    {
        return !!Follow::where([
            ['user_id', '=', $user->id],
            ['follower_id', '=', $this->id]
        ])->first();
    }

    /**
     * Checks if followed with each other.
     *
     * @param User $user
     *
     * @return bool
     */
    public function followedEachOther(User $user)
    {
        return $user->followed($this) && $this->followed($user);
    }

    /**
     * Follows/unfollows a user.
     *
     * @param User $user
     */
    public function follow(User $user)
    {
        if ($this->followed($user)) {
            Follow::where([
                ['user_id', '=', $user->id],
                ['follower_id', '=', $this->id]
            ])->delete();
        } else {
            Follow::create([
                'user_id'     => $user->id,
                'follower_id' => $this->id
            ]);

            // Fire UserFollowed event.
            event(new UserFollowed($user, $this));
        }
    }

    /**
     * Gets its followers.
     *
     * @param $key
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getFollowers($key = null)
    {
        $users = collect([]);

        foreach (Follow::where('user_id', '=', $this->id)->cursor() as $item) {
            $users->push(User::find($item->follower_id));
        }

        return $key ? $users->keyBy($key)->keys() : $users;
    }

    /**
     * Gets its followings.
     *
     * @param $key
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function getFollowings($key = null)
    {
        $users = collect([]);

        foreach (Follow::where('follower_id', '=', $this->id)->latest()->cursor() as $item) {
            $users->push(User::find($item->user_id));
        }

        return $key ? $users->keyBy($key)->keys() : $users;
    }

    /**
     * Get all the notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get all the read notifications.
     *
     * @return mixed
     */
    public function readNotifications()
    {
        return $this->notifications()->whereRead(true)->latest();
    }

    /**
     * Get all the unread notifications.
     *
     * @return mixed
     */
    public function unreadNotifications()
    {
        return $this->notifications()->whereRead(false)->latest();
    }

    /**
     * Get the inbox only notifications.
     *
     * @param int $count
     *
     * @return mixed
     */
    public function inboxNotifications($count = 99)
    {
        return $this->unreadNotifications()->take($count)->get();
    }

    /**
     * Quick getter for unread count.
     *
     * @return mixed
     */
    public function getUnreadAttribute()
    {
        return $this->unreadNotifications()->count() >= 100 ? '99+' : $this->unreadNotifications()->count();
    }

    /**
     * User's metas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metas()
    {
        return $this->hasMany(UserMeta::class);
    }

    /**
     * See if the user has checked in today.
     *
     * @return boolean
     */
    public function checkedIn()
    {
        /** @var null|UserMeta $latestCheck */
        $latestCheck = $this->metas()->where('key', 'check_in')->first();

        return is_null($latestCheck) ? false : $latestCheck->updated_at->isToday();
    }

    /**
     * Checks in.
     */
    public function checkIn()
    {
        if (!$this->checkedIn()) {
            $this->metas()->updateOrCreate(['key' => 'check_in'], ['value' => true]);

            event(new CheckedIn($this));
        }
    }

    /**
     * {@inheritdoc}
     * @author Cali
     */
    public function jsonSerialize()
    {
        $attributes = $this->attributesToArray();

        if (auth()->check() && auth()->user()->id === $this->id) {
            return array_merge($attributes, $this->profileSerializeAttributes());
        }

        return array_merge($attributes, $this->extraSerializeAttributes());
    }

    /**
     * Get the extra serialize attributes.
     *
     * @return array
     * @author Cali
     */
    protected function extraSerializeAttributes()
    {
        return [
            'avatarUrl' => url('/storage/' . $this->avatar)
        ];
    }

    /**
     * Get the extra profile serialize attributes.
     *
     * @return array
     */
    protected function profileSerializeAttributes()
    {
        return [
            'checkedIn'   => $this->checkedIn(),
            'email'       => $this->email,
            'unread'      => $this->unread,
            'avatarUrl'   => url('/storage/' . $this->avatar),
            'description' => $this->description
        ];
    }

    /**
     * Changes user's experience amount.
     *
     * @param $exp
     * @param $reason
     */
    public function changeExperience($exp, $reason)
    {
        $this->incrementOrDecrement('experience', intval($exp), [], intval($exp) > 0 ? 'increment' : 'decrement');

        // Fire event.
        event(new ExperienceHasChanged($this, $exp, $reason));
    }

    /**
     * Sets locale of a user.
     *
     * @param $locale
     *
     * @return bool
     */
    public function changeLocale($locale)
    {
        $this->locale = $locale;

        return $this->save();
    }

    /**
     * Gets description attribute.
     *
     * @return $this
     */
    public function getDescriptionAttribute()
    {
        return $this->metas()->where('key', '=', 'description')->value('value');
    }

    /**
     * Sets description attribute.
     *
     * @param $value
     */
    public function setDescriptionAttribute($value)
    {
        $this->metas()->updateOrCreate(['key' => 'description'], ['value' => $value]);
    }

    /**
     * Gets display_email attribute.
     *
     * @return bool
     */
    public function getDisplayEmailAttribute()
    {
        if (!$this->metas()->where('key', 'display_email')->exists())
            return true;

        return !!$this->metas()->where('key', '=', 'display_email')->value('value');
    }

    /**
     * Sets display_email attribute.
     *
     * @param $value
     */
    public function setDisplayEmailAttribute($value)
    {
        $this->metas()->updateOrCreate(['key' => 'display_email'], ['value' => $value]);
    }

    /**
     * Gets display_email attribute.
     *
     * @return bool
     */
    public function getSubscribeAttribute()
    {
        if (!$this->metas()->where('key', 'subscribe')->exists())
            return true;

        return !!$this->metas()->where('key', '=', 'subscribe')->value('value');
    }

    /**
     * Sets display_email attribute.
     *
     * @param $value
     */
    public function setSubscribeAttribute($value)
    {
        $this->metas()->updateOrCreate(['key' => 'subscribe'], ['value' => $value]);
    }

    /**
     * Gets feed_filter attribute.
     *
     * @return bool
     */
    public function getFeedFilterAttribute()
    {
        return !!$this->metas()->where('key', '=', 'feed_filter')->value('value');
    }

    /**
     * Sets feed_filter attribute.
     *
     * @param $value
     */
    public function setFeedFilterAttribute($value)
    {
        $this->metas()->updateOrCreate(['key' => 'feed_filter'], ['value' => $value]);
    }

    /**
     * Saves settings.
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function changeSettings(array $attributes)
    {
        if ($attributes['password']) {
            $this->password = bcrypt($attributes['password']);
        }

        if ($attributes['name'] != $this->name) {
            $this->name = $attributes['name'];
        }

        $this->description = $attributes['description'] ? : '';
        $this->gender = $attributes['gender'];

        return $this->save();
    }

    /**
     * Changes privacy settings.
     *
     * @param array $attributes
     */
    public function changePrivacy(array $attributes)
    {
        $this->display_email = array_key_exists('display_email', $attributes);
        $this->subscribe = array_key_exists('subscribe', $attributes);
    }

    /**
     * Changes feed settings.
     *
     * @param array $attributes
     */
    public function changeFeedSettings(array $attributes)
    {
        $this->feed_filter = array_key_exists('feed_filter', $attributes);
    }

    /**
     * Checks if feed needs to be filtered.
     *
     * @return bool
     */
    public function filteredFeed()
    {
        return !!$this->feed_filter;
    }

    /**
     * Searches by query to match name, email and description.
     *
     * @param string $query
     * @param int    $count
     *
     * @return static
     */
    public static function search($query = '', $count = 10)
    {
        return static::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->take($count)
            ->get()
            ->merge(UserMeta::search($query));
    }
}
