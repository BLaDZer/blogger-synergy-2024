<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

class SubscriptionController extends AbstractUserAuthorizedController
{
    /**
     * @return RedirectResponse
     */
    public function subscribe(int $user_id)
    {
        /** @var User $user */
        $user = Auth()->user();
        /** @var User $subscribe_to_user */
        $subscribe_to_user = User::findOrFail($user_id);

        $user->subscribeTo($subscribe_to_user);

        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     */
    public function unsubscribe(int $user_id)
    {
        /** @var User $user */
        $user = Auth()->user();
        /** @var User $unsubscribe_from_user */
        $unsubscribe_from_user = User::findOrFail($user_id);

        $user->unsubscribeFrom($unsubscribe_from_user);

        return redirect()->back();
    }
}
