<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
