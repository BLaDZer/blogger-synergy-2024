<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class HomeController extends AbstractUserAuthorizedController
{
    /**
     * @return RedirectResponse
     */
    public function index()
    {
        return redirect()->route('feed');
    }
}
