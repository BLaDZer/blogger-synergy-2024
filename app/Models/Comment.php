<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $user;

    public $post;

    public $message;

    public $created_at;

    public $updated_at;
}
