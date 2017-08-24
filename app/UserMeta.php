<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    /**
     * Mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value'
    ];

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'user_meta';

    /**
     * The user it belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author Cali
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Searches for a query.
     *
     * @param string $query
     *
     * @return \Illuminate\Support\Collection
     */
    public static function search($query = '')
    {
        $ids = static::where([
            ['key', 'description'],
            ['value', 'like', "%{$query}%"]])
            ->take(10)
            ->get(['user_id']);
        $users = collect();

        foreach ($ids as $meta => $id) {
            $users->push(User::find($id)->first());
        }

        return $users;
    }
}
