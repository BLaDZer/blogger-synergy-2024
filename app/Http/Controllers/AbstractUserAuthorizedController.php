<?php

namespace App\Http\Controllers;

abstract class AbstractUserAuthorizedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
