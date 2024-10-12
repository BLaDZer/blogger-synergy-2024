<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasMany|Post[]
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return HasManyThrough|User[]
     */
    public function subscribedToUsers()
    {
        return $this->hasManyThrough(User::class, Subscription::class);
    }

    /**
     * @return HasManyThrough|User[]
     */
    public function subscribedPosts()
    {
        return $this->hasManyThrough(Post::class, Subscription::class);
    }

    /**
     * @return HasMany|Subscription[]
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
