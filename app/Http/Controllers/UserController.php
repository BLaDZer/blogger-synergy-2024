<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class UserController extends AbstractUserAuthorizedController
{
    /**
     * @return Renderable
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth()->user();

        $users = User::where('id', '!=', $user->id)->get();

        return view(
            'users.list',
            [
                'users' => $users,
                'user' => $user,
                'subscriptions' => $user->subscriptions()->get(),
            ]
        );
    }

    /**
     * @return Renderable
     */
    public function view(Request $request, int $user_id)
    {
        /** @var User $user */
        $user = Auth()->user();

        /** @var User $viewing_user */
        $viewing_user = User::findOrFail($user_id);

        $user_posts = $viewing_user->posts()
            ->orderBy('created_at', 'DESC');

        $filter_tag_id = $request->get('tag');

        if ($filter_tag_id) {
            $user_posts = Post::addTagIdFilterToQuery($user_posts, $filter_tag_id);
        }

        return view(
            'users.view',
            [
                'current_user' => $user,
                'user' => $viewing_user,
                'is_subscribed' => $user->isSubscribedTo($viewing_user),
                'posts' => $user_posts->get(),
            ]
        );
    }
}
