<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends AbstractUserAuthorizedController
{
    /**
     * @return RedirectResponse
     */
    public function create(Request $request, int $post_id)
    {
        /** @var Post $post */
        $post = Post::findOrFail($post_id);

        /** @var User $user */
        $user = Auth()->user();

        $new_comment = new Comment();
        $new_comment->user_id = $user->id;
        $new_comment->post_id = $post->id;
        $new_comment->message = $request->get('message');

        $post->addComment($new_comment);

        return redirect()->back();
    }
}
