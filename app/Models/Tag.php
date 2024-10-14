<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $title
 * @property string $created_at
 */
class Tag extends Model
{
    const UPDATED_AT = null;

    protected $fillable = ['title'];

    /**
     * @return BelongsToMany|Post[]
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
