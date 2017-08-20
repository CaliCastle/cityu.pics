<?php

namespace App;

use function Couchbase\defaultDecoder;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * Normal type of notification.
     */
    const NORMAL_TYPE = 'normal';

    /**
     * Experience type of notification
     */
    const EXP_TYPE = 'experience';

    /**
     * User related type of notification.
     */
    const USER_TYPE = 'user';

    /**
     * Announcement type of notification.
     */
    const ANNOUNCEMENT_TYPE = 'announcement';

    /**
     * Profile type of notification.
     */
    const PROFILE_TYPE = 'profile';

    /**
     * Fillable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'content', 'related'
    ];

    /**
     * Hidden attributes.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'updated_at'
    ];

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge($this->toArray(), $this->extraAttributes());
    }

    /**
     * Get the extra attributes.
     *
     * @return array
     */
    public function extraAttributes()
    {
        return [
            'time'    => $this->created_at->toIso8601String(),
            'message' => $this->getMessage(),
            'avatar'  => $this->relatedAvatar(),
            'link'    => $this->relatedLink(),
            'image'   => $this->relatedImage()
        ];
    }

    /**
     * User relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Read the notification.
     *
     * @return bool
     */
    public function read()
    {
        $this->read = true;

        return $this->save();
    }

    /**
     * @return mixed
     */
    public function getRelated()
    {
        return json_decode($this->related);
    }

    /**
     * Gets the display message appropriately.
     *
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function getMessage()
    {
        if ($this->relatedDeleted()) {
            return trans('notifications.deleted', [], $this->user->locale);
        }
        $message = '';

        switch ($this->type) {
            case self::USER_TYPE: {
                switch ($this->content) {
                    case 'followed':
                    case 'liked':
                        return trans('notifications.' . $this->content, [
                            'user' => $this->relatedUser()->name
                        ], $this->user->locale);
                    case 'new-post':
                        return trans('notifications.new-post', [
                            'user' => $this->relatedUser()->name,
                            'post' => $this->relatedPost()->shortContent()
                        ], $this->user->locale);
                    case 'commented':
                    case 'new-reply':
                    case 'liked-comment': {
                        $comment = $this->relatedComment();

                        return trans('notifications.' . $this->content, [
                            'user'    => $comment->user->name,
                            'comment' => $comment->shortContent()
                        ], $this->user->locale);
                    }
                }
            }
            case self::EXP_TYPE: {
                return trans('notifications.earned-exp', [
                    'exp'    => intval($this->getRelated()->exp),
                    'reason' => trans('notifications.reasons.' . $this->getRelated()->reason)
                ], $this->user->locale);
            }
            case self::NORMAL_TYPE: {
                // TODO:
            }
            case self::ANNOUNCEMENT_TYPE: {
                // TODO:
            }
            default: {
                break;
            }
        }

        return $message;
    }

    /**
     * Gets the related user.
     *
     * @return null|User
     */
    public function relatedUser()
    {
        return !property_exists($this->getRelated(), 'user_id') ? null : User::findOrFail($this->getRelated()->user_id);
    }

    /**
     * Gets the related post.
     *
     * @return null|Post
     */
    public function relatedPost()
    {
        return !property_exists($this->getRelated(), 'post_id') ? null : Post::findOrFail($this->getRelated()->post_id);
    }

    /**
     * Gets the related comment.
     *
     * @return null|Comment
     */
    public function relatedComment()
    {
        return !property_exists($this->getRelated(), 'comment_id') ? null : Comment::findOrFail($this->getRelated()->comment_id);
    }

    /**
     * Gets the related avatar if any.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|null|string
     */
    public function relatedAvatar()
    {
        if ($this->relatedDeleted()) {
            return null;
        }
        if ($this->type != 'user' || !property_exists($this->getRelated(), 'user_id'))
            return null;

        return $this->relatedUser()->avatarUrl;
    }

    /**
     * Gets the related link if any.
     *
     * @return null|string
     */
    public function relatedLink()
    {
        if ($this->relatedDeleted()) {
            return null;
        }

        $link = '';

        switch ($this->type) {
            case self::USER_TYPE: {
                switch ($this->content) {
                    case 'followed':
                        return $this->relatedUser()->profileLink();
                    case 'new-post':
                    case 'liked':
                        return $this->relatedPost()->link();
                    case 'commented':
                    case 'new-reply':
                    case 'liked-comment':
                        return $this->relatedComment()->link();
                }
                break;
            }
            case self::EXP_TYPE: {
                $link = null;
                break;
            }
            case self::NORMAL_TYPE: {
                // TODO:
            }
            case self::ANNOUNCEMENT_TYPE: {
                // TODO:
            }
            default: {
            }
        }

        return $link;
    }

    /**
     * Get the related image if any.
     *
     * @return mixed|null
     */
    public function relatedImage()
    {
        if ($this->relatedDeleted()) {
            return null;
        }

        if ($this->type == 'user') {
            switch ($this->content) {
                case 'followed':
                    return null;
                case 'new-post':
                case 'liked':
                    return $this->relatedPost()->firstImage();
                case 'commented':
                case 'new-reply':
                case 'liked-comment':
                    return $this->relatedComment()->post->firstImage();
            }
        } else {
            return null;
        }
    }

    public function relatedDeleted()
    {
        if ($this->type == 'user') {
            switch ($this->content) {
                case 'followed':
                    return false;
                case 'new-post':
                case 'liked':
                    return property_exists($this->getRelated(), 'post_id') ? !Post::find($this->getRelated()->post_id) : true;
                case 'commented':
                case 'new-reply':
                case 'liked-comment':
                    return property_exists($this->getRelated(), 'comment_id') ? !Comment::find($this->getRelated()->comment_id) : true;
            }
        } else {
            return false;
        }
    }
}
