<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * Fillables.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Belongs To Many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Create the tag/tags.
     *
     * @param $tags
     *
     * @return Model
     */
    public static function generate($tags, Post $post)
    {
        if (!is_array($tags)) {
            $tags = str_replace('#', '', $tags);

            return $post->tags()->attach(static::firstOrCreate(['name' => $tags])->id);
        }

        foreach ($tags as $tag) {
            $tag = str_replace('#', '', $tag);
            $tagInstance = static::firstOrCreate(['name' => $tag]);
            $post->tags()->attach($tagInstance->id);
        }
    }

    /**
     * Checks if the tag exists.
     *
     * @param $tag
     *
     * @return bool
     */
    public static function checkExistence($tag)
    {
        return !is_null(static::where('name', $tag)->first());
    }

    /**
     * Searches through by the query.
     *
     * @param string $query
     * @param int    $count
     *
     * @return static
     */
    public static function search($query = '', $count = 25)
    {
        return static::where('name', 'like', "%{$query}%")->get()->take($count);
    }

    /**
     * Gets related posts count.
     *
     * @return int
     */
    public function relatedPostsCount()
    {
        return number_format($this->posts()->count());
    }

    /**
     * Gets its link.
     *
     * @return string
     */
    public function link()
    {
        return route('tag', ['tag' => $this->name]);
    }
}
