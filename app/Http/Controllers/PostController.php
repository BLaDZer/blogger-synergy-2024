<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostController extends AbstractUserAuthorizedController
{
    /**
     * @return RedirectResponse
     */
    public function create(Request $request)
    {
        /** @var User $user */
        $user = Auth()->user();

        $post = $user->posts()
            ->create([
                'message' => $request->post('message'),
                'is_hidden' => (bool) $request->post('is_hidden', false),
            ]);

        if ($request->post('tags')) {
            $tags = explode(' ', $request->post('tags'));

            $post->addTags($tags);
        }

        return redirect()->route('user.profile', ['user_id' => $user]);
    }

    /**
     * @return Renderable
     */
    public function showCreateForm()
    {
        return view('posts.create');
    }

    /**
     * @return Renderable
     */
    public function view(int $post_id)
    {
        /** @var Post $post */
        $post = Post::findOrFail($post_id);

        /** @var User $user */
        $user = Auth()->user();

        return view('posts.view', ['user' => $user, 'post' => $post]);
    }

    /**
     * @return Renderable
     */
    public function showEditForm(int $post_id)
    {
        /** @var Post $post */
        $post = Post::findOrFail($post_id);

        /** @var User $user */
        $user = Auth()->user();

        if (!$post->isOwner($user)) {
            return redirect()->route('posts.view', ['post_id' => $post_id]);
        }

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * @return RedirectResponse
     */
    public function update(Request $request, int $post_id)
    {
        /** @var Post $post */
        $post = Post::findOrFail($post_id);

        /** @var User $user */
        $user = Auth()->user();

        if (!$post->isOwner($user)) {
            return redirect()->route('posts.view', ['post_id' => $post_id]);
        }

        $post->update([
            'message' => $request->post('message'),
            'is_hidden' => (bool) $request->post('is_hidden', false),
        ]);

        return redirect()->route('user.profile', ['user_id' => $user]);
    }

    /**
     * @return RedirectResponse
     */
    public function destroy(int $post_id)
    {
        /** @var Post $post */
        $post = Post::findOrFail($post_id);

        /** @var User $user */
        $user = Auth()->user();

        if (!$post->isOwner($user)) {
            return redirect()->back();
        }

        $post->delete();

        return redirect()->route('user.profile', ['user_id' => $user]);
    }
}
