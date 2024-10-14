<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class FeedController extends AbstractUserAuthorizedController
{
    /**
     * @return Renderable
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth()->user();

        $order_old_first = $request->get('order', 'new') === 'old';

        $posts = $user->feedPosts()
            ->orderBy('created_at', $order_old_first ? 'ASC' : 'DESC');

        $filter_tag_id = $request->get('tag');

        if ($filter_tag_id) {
            $posts = Post::addTagIdFilterToQuery($posts, $filter_tag_id);
        }

        return view('feed', ['user' => $user, 'posts' => $posts->get()]);
    }
}
