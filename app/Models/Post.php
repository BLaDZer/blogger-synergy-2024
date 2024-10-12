<?php

namespace App\Models;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var bool
     */
    private $is_hidden = false;

    /**
     * @var DateTimeImmutable
     */
    private $created_at;

    /**
     * @var DateTimeImmutable|null
     */
    private $updated_at = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message', 'is_hidden'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function (self $post) {
            $post->created_at = new DateTimeImmutable('now');
        });
    }

    /**
     * @return bool
     */
    public function isOwner(User $user)
    {
        return $this->user_id === $user->id;
    }

    /**
     * @return BelongsTo|User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * @return BelongsToMany|Tag[]
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePublic(Builder $query)
    {
        return $query->where('is_hidden', '=', false);
    }
}
