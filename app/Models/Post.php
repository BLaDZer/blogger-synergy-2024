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
    public $title;

    /**
     * @var string
     */
    public $body;

    /**
     * @var bool
     */
    public $is_hidden = false;

    /**
     * @var DateTimeImmutable
     */
    public $created_at;

    /**
     * @var DateTimeImmutable|null
     */
    public $updated_at = null;

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
     * @return Builder
     */
    public static function public()
    {
        // magic call
        return parent::public();
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
