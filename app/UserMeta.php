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
}
