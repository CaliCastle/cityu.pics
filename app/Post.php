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
     * Create a post instance from front-end ajax composer request.
     * 
     * @param array $data
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
}
