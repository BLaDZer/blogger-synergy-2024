<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function view(int $user_id)
    {
        /** @var User $user */
        $user = Auth()->user();
        $viewing_user = User::findOrFail($user_id);

        $user_posts = $viewing_user->posts()
            ->orderBy('created_at', 'DESC');

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

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscribe(int $user_id)
    {
        /** @var User $user */
        $user = Auth()->user();
        $subscribe_to_user = User::findOrFail($user_id);

        $user->subscribeTo($subscribe_to_user);

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsubscribe(int $user_id)
    {
        /** @var User $user */
        $user = Auth()->user();
        $unsubscribe_from_user = User::findOrFail($user_id);

        $user->unsubscribeFrom($unsubscribe_from_user);

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
