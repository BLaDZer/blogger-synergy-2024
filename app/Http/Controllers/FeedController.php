<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth()->user();

        $order_old_first = $request->get('order', 'new') === 'old';

        $posts = $user->feedPosts()
            ->orderBy('created_at', $order_old_first ? 'ASC' : 'DESC');

        return view('feed', ['user' => $user, 'posts' => $posts->get()]);
    }
}
