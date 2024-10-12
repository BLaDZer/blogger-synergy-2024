<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    public $title;

    public $created_at;

    /**
     * @return BelongsToMany|Post[]
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
