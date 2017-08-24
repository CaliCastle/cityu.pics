<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'caption', 'media'
    ];

    /**
     * Whose post it is.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Its tags collection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Its likes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    /**
     * Its comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get its super comments
     *
     * @return mixed
     */
    public function superComments()
    {
        return $this->comments()->whereNull('parent');
    }

    /**
     * Create a post instance from front-end ajax composer request.
     *
     * @param array $data
     *
     * @return static
     */
    public static function createFromComposer(array $data)
    {
        $instance = new static(['caption' => $data['caption']]);
        $instance->media = implode(',', $data['media']);

        return $instance;
    }

    /**
     * Get all media each by each in an array.
     *
     * @return array
     */
    public function allMedia()
    {
        return explode(',', $this->media);
    }

    /**
     * Get the first image of the post.
     *
     * @return mixed
     */
    public function firstImage()
    {
        return $this->allMedia()[0];
    }

    /**
     * Checks if post has tags.
     *
     * @return bool
     */
    public function hasTags()
    {
        return $this->tags()->count() != 0;
    }

    /**
     * Gets likes attribute.
     *
     * @return mixed
     */
    public function getLikesAttribute()
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
     * Gets link of the post.
     *
     * @return string
     */
    public function link()
    {
        return route('post', ['post' => $this->id]);
    }

    /**
     * Gets short content.
     *
     * @param int $limit
     *
     * @return string
     */
    public function shortContent($limit = 50)
    {
        $content = $this->caption;
        preg_match_all('/\<img[^\>]*\>/', $content, $matches);

        foreach ($matches[0] as $match) {
            $content = str_replace($match, preg_replace('#<img.*alt="([^"]+)".*>#', '$1', $match), $content);
        }

        $content = str_replace('&nbsp;', ' ', $content);

        return str_limit($content, $limit);
    }

    /**
     * Searches through by the query.
     *
     * @param string $query
     *
     * @return static
     */
    public static function search($query = '')
    {
        return static::where('caption', 'like', "%{$query}%")->get()->take(30);
    }
}
