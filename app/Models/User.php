<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
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
     * @return Builder
     */
    public function feedPosts()
    {
        return Post::with(['user'])
            ->where(function ($query) {
                $query->whereIn(
                    'user_id',
                    $this->subscribedToUsers()->select('users.id')
                )
                    ->orWhere('user_id', $this->id);
            });
    }

    /**
     * @return HasManyThrough|User[]
     */
    public function subscribedToUsers()
    {
        return $this->hasManyThrough(
            User::class,
            Subscription::class,
            'subscriber_id',
            'id',
            null,
            'user_id'
        );
    }

    /**
     * @return HasMany|Subscription[]
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'subscriber_id');
    }

    /**
     * @return $this
     */
    public function subscribeTo(self $user)
    {
        $this->subscriptions()
            ->create(['subscriber_id' => $this->id, 'user_id' => $user->id]);

        return $this;
    }

    /**
     * @return $this
     */
    public function unsubscribeFrom(self $user)
    {
        $this->subscriptions()
            ->where('user_id', '=', $user->id)
            ->delete();

        return $this;
    }

    /**
     * @return bool
     */
    public function isSubscribedTo(self $user)
    {
        return $this->subscriptions()
            ->where('user_id', '=', $user->id)
            ->exists();
    }
}
