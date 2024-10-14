<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $post_id
 * @property int $tag_id
 */
class PostTag extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $fillable = ['post_id', 'tag_id'];
}
