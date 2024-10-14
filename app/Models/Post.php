<?php

namespace App\Models;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property string $message
 * @property bool $is_hidden
 * @property User $user
 * @property string $created_at
 * @property string $updated_at
 */
class Post extends Model
{
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
     * @return HasManyThrough|Tag[]
     */
    public function tags()
    {
        return $this->hasManyThrough(
            Tag::class,
            PostTag::class,
            'post_id',
            'id',
            'id',
            'tag_id'
        );
    }

    /**
     * @return HasMany|PostTag[]
     */
    public function postTags()
    {
        return $this->hasMany(PostTag::class);
    }

    /**
     * @param string[] $tags
     */
    public function addTags(array $tags)
    {
        $tags = array_map('trim', array_filter($tags));

        foreach ($tags as $tag_title) {
            /** @var Tag $tag */
            $tag = Tag::firstOrCreate(
                ['title' => $tag_title],
                ['title' => $tag_title]
            );

            $this->postTags()
                ->save(
                    new PostTag(
                        ['tag_id' => $tag->id, 'post_id' => $this->id]
                    )
                );
        }
    }

    /**
     * @return HasMany|Comment[]
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @param EloquentBuilder|Relation $query
     * @return EloquentBuilder|Relation
     */
    public static function addTagIdFilterToQuery($query, int $filter_tag_id)
    {
        return $query->whereExists(
            function (Builder $query) use ($filter_tag_id) {
                $query->select(DB::raw(1))
                    ->from('post_tags')
                    ->whereColumn('post_tags.post_id', '=', 'posts.id')
                    ->where('post_tags.tag_id', '=', $filter_tag_id);
            }
        );
    }

    public function addComment(Comment $comment)
    {
        $this->comments()
            ->save($comment);
    }
}
