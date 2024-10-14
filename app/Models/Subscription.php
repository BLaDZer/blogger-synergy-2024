<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $subscriber_id
 * @property int $user_id
 */
class Subscription extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $fillable = ['user_id', 'subscriber_id'];

    public function subscriber()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
