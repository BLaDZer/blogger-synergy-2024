<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /** @var User $user */
        $user = Auth()->user();

        $user->posts()
            ->create([
                'message' => $request->post('message'),
                'is_hidden' => $request->post('is_hidden', false),
            ]);

        return redirect()->route('user.profile', ['user_id' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showCreateForm()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function view(int $post_id)
    {
        $post = Post::findOrFail($post_id);

        /** @var User $user */
        $user = Auth()->user();

        return view('posts.view', ['user' => $user, 'post' => $post]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
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
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Post $post
     * @return \Illuminate\Http\Response
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
            'is_hidden' => $request->post('is_hidden', false),
        ]);

        return redirect()->route('user.profile', ['user_id' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
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
