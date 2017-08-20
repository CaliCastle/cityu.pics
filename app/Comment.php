<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Fillable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'post_id', 'parent'
    ];

    /**
     * Its post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Its user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Parent comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentComment()
    {
        return $this->belongsTo(static::class, 'parent');
    }

    /**
     * Children comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(static::class, 'parent');
    }

    /**
     * The likes of the comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'comment_likes');
    }

    /**
     * Gets how many likes the comment has.
     *
     * @return string
     */
    public function getLikes()
    {
        $likes = $this->likes()->count();

        if ($likes >= pow(1000, 1) && $likes < pow(1000, 2)) {
            $result = round($likes / pow(1000, 2), 2) . 'k';
        } elseif ($likes >= pow(1000, 2)) {
            $result = round($likes / pow(1000, 2), 2) . 'm';
        } else {
            $result = $likes;
        }

        return $result;
    }

    /**
     * Gets the short version of content.
     *
     * @param int $limit
     *
     * @return string
     */
    public function shortContent($limit = 50)
    {
        $content = $this->content;
        preg_match_all('/\<img[^\>]*\>/', $content, $matches);

        foreach ($matches[0] as $match) {
            $content = str_replace($match, preg_replace('#<img.*alt="([^"]+)".*>#', '$1', $match), $content);
        }

        $content = str_replace('&nbsp;', ' ', $content);

        return str_limit($content, $limit);
    }

    /**
     * Gets the link of the comment.
     *
     * @return string
     */
    public function link()
    {
        return route('post', ['post' => $this->post->id]);
    }
}
